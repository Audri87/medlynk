# ADR-SA-026 — Evolution Strategy

**Type :** Software Architecture Decision — Politique transversale
**Statut :** Accepted
**Date :** 2026-07-29
**Autorité :** Ce document gouverne la politique de compatibilité pour toute évolution du système. Il est subordonné à ADR-SA-000.

---

## Conformité ADR-SA-000

| Principe | Statut | Note |
|---|---|---|
| P-01 — Indépendance du Domain | ✅ Conforme | L'évolution du Domain n'impose pas d'évolution de l'Infrastructure |
| P-05 — Events immuables | ✅ Conforme | Un event publié ne change jamais — les breaking changes créent un nouvel event |
| P-07 — Publication post-commit | ✅ Conforme | La stratégie dual-write préserve la garantie at-least-once |
| P-10 — Read Models | ✅ Conforme | Les Projections sont rejouables depuis les events — évolution sans perte |
| autres | ⚪ Sans objet | |

---

## 1. Contexte

Un système qui ne peut pas évoluer sans casser ses consommateurs est fragile. Un système qui évolue sans politique explicite accumule une dette de compatibilité invisible.

Cette ADR établit les règles de compatibilité pour chaque type d'artefact : Aggregate, Domain Event, API, Projection, Command.

Le principe directeur est asymétrique : **l'additivité est libre, la rupture est gouvernée.**

---

## 2. Définitions

### Changement additif (non-breaking)

Un changement additif ne casse aucun consommateur existant.

- Ajout d'un champ optionnel
- Ajout d'un endpoint
- Assouplissement d'une contrainte (ex. : champ nullable qui devient non-null avec valeur par défaut)

### Changement rupturant (breaking)

Un changement rupturant casse au moins un consommateur existant sans modification de sa part.

- Suppression d'un champ
- Renommage d'un champ
- Changement de type d'un champ
- Changement de sémantique d'un champ existant
- Renforcement d'une contrainte (ex. : champ qui devient non-null sans valeur par défaut)

---

## 3. Principe Tolerant Reader

Tous les consommateurs de Domain Events et d'API DOIVENT implémenter le **Tolerant Reader Pattern** :

1. **Ignorer les champs inconnus** — un champ ajouté dans une nouvelle version ne cause pas d'erreur
2. **Valeur par défaut pour les champs manquants optionnels** — un champ optionnel absent est équivalent à sa valeur par défaut
3. **Ne pas valider la structure au-delà du besoin** — valider uniquement les champs effectivement utilisés

Le Tolerant Reader est la condition qui rend les changements additifs non-breaking. Sans lui, tout ajout de champ devient rupturant.

Un consommateur non-Tolerant-Reader est non conforme à cette ADR.

---

## 4. Matrice de compatibilité

| Changement | Aggregate | Domain Event | API | Projection | Command |
|---|---|---|---|---|---|
| Ajouter un champ optionnel | Interne — libre | ✅ Additif — safe | ✅ Additif — safe | ✅ Additif — safe | Interne — libre |
| Ajouter un champ obligatoire | Migration DB | 🔴 Breaking → v+1 | 🔴 Breaking → v+1 | ✅ Additif + défaut | Coordination interne |
| Supprimer un champ | Migration DB | 🔴 Breaking → v+1 | 🔴 Breaking → v+1 | ✅ Additif (nullable) | Coordination interne |
| Renommer un champ | Migration DB | 🔴 Breaking → v+1 | 🔴 Breaking → v+1 | Migration | Coordination interne |
| Changer la sémantique | Migration + review | 🔴 Breaking → v+1 | 🔴 Breaking → v+1 | Replay | Review obligatoire |
| Durcir un invariant | Review + migration | Nouveau event type | 🔴 Breaking → v+1 | Sans objet | Review + migration |

---

## 5. Évolution d'un Aggregate

### Nature de l'évolution

L'Aggregate est **interne** à son Bounded Context. Son évolution ne constitue un risque de compatibilité que vis-à-vis de deux éléments :
- le schéma de base de données (persistance)
- les Domain Events qu'il produit (contrats externes)

L'API interne de l'Aggregate (méthodes, constructeurs) peut évoluer librement tant que ses Domain Events restent conformes à leurs contrats.

### Évolution du schéma

| Type de changement | Stratégie |
|---|---|
| Ajout de colonne nullable | Migration DDL — non-breaking |
| Ajout de colonne non-null | Migration DDL + backfill — coordonné avec deployment |
| Suppression de colonne | Migration DDL après confirmation de non-usage |
| Renommage | Migration DDL en deux étapes (add → migrate data → remove old) |

### Durcissement d'un invariant

Si un nouvel invariant exclut des données existantes (ex. : un champ qui ne pouvait pas être null mais l'est dans des enregistrements anciens), une migration de données est obligatoire avant le déploiement du nouvel invariant. Aucun invariant ne peut être durci sans analyse des données existantes.

---

## 6. Évolution d'un Domain Event

### Règle fondamentale

Un Domain Event publié est **immuable** (P-05). Un event `ContributionCreated` version 1 ne sera jamais modifié après publication. Il restera dans l'Outbox avec son payload d'origine.

### Changements additifs — libres

L'ajout d'un champ dans le payload d'un Domain Event est un changement additif si :
1. Le champ est optionnel (nullable ou avec valeur par défaut)
2. Tous les consommateurs existants implémentent Tolerant Reader (§3)

Procédure :
1. Ajouter le champ dans la classe de l'event et dans le mapping Outbox
2. Mettre à jour le contrat dans DE-001
3. Déployer (les consommateurs ignorent le nouveau champ jusqu'à ce qu'ils le consomment)

### Changements rupturants — versionnage obligatoire

Si le changement est rupturant (§2), un nouveau type d'event est créé :

```
ContributionCreated          ← version 1 — conservé, jamais modifié
ContributionCreatedV2        ← version 2 — nouveau type de classe
```

Le champ `event_version` dans l'Outbox (ADR-SA-020) est mis à jour.

### Fenêtre de migration dual-write

Pendant la migration vers le nouvel event :

```
Phase 1 — Dual-write
    L'Aggregate produit ContributionCreated (v1) ET ContributionCreatedV2 (v2)
    Les consommateurs existants continuent de traiter v1
    Les nouveaux consommateurs traitent v2

Phase 2 — Migration des consommateurs
    Chaque consommateur de v1 est mis à jour pour traiter v2
    Période minimum : 30 jours après déploiement de la Phase 1

Phase 3 — Dépreciation de v1
    L'Aggregate cesse de produire v1
    Annonce dans CHANGELOG et ADR
    v1 reste dans l'Outbox (immuable) mais plus produit

Phase 4 — Suppression du code v1
    Après confirmation qu'aucun consommateur actif ne traite v1
```

### Rejouer l'Outbox après migration

Si un nouveau consommateur doit traiter des events historiques avec le nouveau format, deux options :

1. **Replay avec transformation** : le relay applique une transformation v1 → v2 lors du dispatch des events historiques
2. **Replay natif** : les events historiques v1 sont traités par le consommateur avec un adaptateur Tolerant Reader qui mappe les anciens champs

---

## 7. Évolution d'une API

### Versionnage depuis le jour 1

MedLink versionne ses APIs depuis la première route : `/api/v1/` (CLAUDE.md). Ce préfixe protège contre la pression de rétrocompatibilité indéfinie.

### Changements additifs — libres dans v1

- Ajouter un champ en réponse
- Ajouter un paramètre optionnel en requête
- Ajouter un nouvel endpoint

Les clients qui implémentent Tolerant Reader absorbent ces changements sans modification.

### Changements rupturants → nouvelle version majeure

Un changement rupturant déclenche la création de `/api/v2/` :

| Action | Procédure |
|---|---|
| Créer `/api/v2/` | Nouveau endpoint avec le nouveau contrat |
| Déprécier `/api/v1/` | Header `Deprecation: true` + `Sunset: {date}` |
| Fenêtre de dépréciation | Minimum **6 mois** |
| Arrêt de `/api/v1/` | Après la date Sunset — retour 410 Gone |

### Headers de dépréciation

```http
HTTP/1.1 200 OK
Deprecation: true
Sunset: Mon, 29 Jan 2027 00:00:00 GMT
Link: </api/v2/patients/{id}/contributions>; rel="successor-version"
```

### Versionnage des champs de requête/réponse

Les champs individuels ne sont pas versionnés dans la même version d'API. Une évolution de champ = migration vers v2.

---

## 8. Évolution d'une Projection

### Les Projections sont rejouables

Les Projections sont des données dérivées (P-10). Elles peuvent toujours être reconstruites depuis les Domain Events. C'est la propriété qui rend leur évolution sans risque de perte.

### Changements additifs — libres

Ajouter une colonne à une Projection est toujours safe :
1. Ajouter la colonne (nullable ou avec valeur par défaut)
2. Déployer le nouveau Projector
3. Rejouer les events historiques pour remplir la nouvelle colonne

### Changements structurels — replay

Tout changement structurel significatif (refactoring de la Projection, nouvelle stratégie de jointure) suit :

```
1. Créer la nouvelle Projection (nouvelle table ou schéma)
2. Déployer le nouveau Projector
3. Rejouer tous les Domain Events depuis le début — ADR-SA-020 §6
4. Valider la cohérence (comparer avec l'ancienne Projection)
5. Basculer les Query Handlers vers la nouvelle Projection
6. Supprimer l'ancienne Projection
```

### Replay en production

Le replay doit être possible sans interruption de service. Pendant le replay :
- L'ancienne Projection reste active pour les Query Handlers
- La nouvelle Projection est construite en parallèle
- Le basculement est atomique (changement de configuration ou de routing)

---

## 9. Évolution d'une Command

### Nature de l'évolution

Les Commands sont des DTOs internes. Dans un Modular Monolith, elles ne traversent pas de frontière réseau — leur évolution est coordonnée dans le même codebase.

### Changements additifs — libres

Ajouter un champ optionnel à une Command est safe : tous les appelants existants n'ont pas besoin de le fournir.

### Suppression ou renommage

Vérifier tous les appelants dans le codebase. Si un champ est supprimé, tous les appelants doivent être mis à jour dans le même commit.

### Si la Command traverse une frontière (futur)

Si MedLink migre vers une architecture distribuée, les Commands qui traversent une frontière réseau deviennent des contrats externes et suivent alors les règles de versionnage des Domain Events (§6).

---

## 10. Politique de dépréciation

| Artefact | Fenêtre minimale | Mécanisme |
|---|---|---|
| Domain Event v(n) | 30 jours après déploiement de v(n+1) | Log WARNING lors de dispatch de la version dépréciée |
| API v(n) | 6 mois | Headers `Deprecation` + `Sunset` |
| Projection (ancienne) | Durée du replay + 7 jours de validation | Monitoring comparatif |
| Command (interne) | 0 — coordonné dans le même commit | Recherche codebase obligatoire |

---

## 11. Invariants protégés

| Invariant | Protégé par |
|---|---|
| Un Domain Event publié ne change jamais | Immutabilité P-05 + versionnage par nouveau type |
| Aucun consommateur ne casse sans préavis | Tolerant Reader + fenêtre de migration |
| Les Projections peuvent toujours être reconstruites | Replay depuis Domain Events — P-10 |
| L'API est versionnée dès le premier endpoint | Préfixe `/api/v1/` — CLAUDE.md |
| Une dépréciation est toujours annoncée avec délai | Politique de dépréciation — §10 |

---

## Références

| Document | Relation |
|---|---|
| ADR-SA-000 | Constitution logicielle |
| ADR-SA-015 | clinicalActivityId dans E-01 — exemple de changement additif sur un event |
| ADR-SA-019 | Domain Event Publication — at-least-once et dual-write |
| ADR-SA-020 | Transactional Outbox — champ `event_version`, replay |
| ADR-SA-011 | Read Model Strategy — Projections et index |
| DE-001 | Domain Event Taxonomy — contrats à maintenir |
