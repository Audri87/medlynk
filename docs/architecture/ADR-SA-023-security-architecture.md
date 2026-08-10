# ADR-SA-023 — Security Architecture

**Type :** Software Architecture Decision — Politique transversale
**Statut :** Accepted
**Date :** 2026-07-29
**Autorité :** Ce document gouverne l'authentification, l'autorisation et l'audit dans MedLink. Il est subordonné à ADR-SA-000.
**HDS :** Ce document prend en compte les exigences d'hébergement de données de santé (HDS) — certification obligatoire en production.

---

## Conformité ADR-SA-000

| Principe | Statut | Note |
|---|---|---|
| P-01 — Indépendance du Domain | ✅ Conforme | La sécurité est appliquée dans l'Interface Layer — §3 |
| P-02 — Aggregates gardiens | ✅ Conforme | Les règles d'autorisation métier restent dans le Domain si elles expriment un invariant |
| P-03 — Application Services orchestrent | ✅ Conforme | Les Application Services reçoivent un acteur déjà authentifié |
| P-05 — Events immuables | ✅ Conforme | Les Domain Events portent l'actorId — piste d'audit immuable |
| autres | ⚪ Sans objet | |

---

## 1. Contexte

MedLink manipule des données de santé. Les contraintes de sécurité sont :
- **RGPD** — protection des données personnelles
- **HDS** — hébergement de données de santé (certification obligatoire en production)
- **Isolation des organisations** — un acteur ne voit que les données de son organisation
- **Responsabilité professionnelle** — un praticien reste responsable de ses actes cliniques

Ces contraintes ne sont pas des features. Ce sont des invariants non négociables.

---

## 2. Authentification

### Mécanismes

| Interface | Mécanisme | Nature |
|---|---|---|
| API REST | JWT (JSON Web Token) | Stateless — pas de session serveur |
| Interface web (Symfony UX) | Session PHP + cookie HttpOnly | Stateful — session serveur |

### Qui gère l'authentification

**L'Identity Platform** est propriétaire de l'authentification. La Clinical Platform ne gère pas de mots de passe, ne valide pas de credentials, et ne produit pas de tokens.

La Clinical Platform consomme un token déjà validé. Elle extrait l'identité de l'acteur depuis le token et l'utilise pour l'autorisation.

### Contenu du token

Le JWT porte :
- `actorId` : identifiant de l'Actor (Kernel concept)
- `organizationId` : organisation de rattachement
- `roles` : rôles RBAC
- `scopes` : périmètre d'accès (optionnel — pour les accès inter-organisations)
- `exp` : expiration obligatoire (TTL court — 15 minutes pour l'API)
- `jti` : identifiant unique du token (pour révocation si nécessaire)

### Ce que la Clinical Platform ne fait jamais

- Stocker des credentials (mots de passe, clés privées)
- Valider un token localement sans vérification de signature
- Générer un token d'authentification

---

## 3. Autorisation

### Principe

L'autorisation répond à la question : **cet Actor peut-il effectuer cette Action sur cette Ressource dans ce contexte ?**

Elle se produit dans la **couche Interface**, avant que la Command ne soit construite. Elle est implémentée via des **Voters Symfony**.

Un Command Handler reçoit une Command provenant d'un acteur déjà authentifié et autorisé. Il ne re-vérifie pas l'autorisation.

### Modèle RBAC + ABAC

MedLink utilise un modèle hybride :

| Couche | Modèle | Exemple |
|---|---|---|
| Coarse-grained | RBAC (rôles) | Un Administrateur peut accéder à la configuration |
| Fine-grained | ABAC (attributs) | Un Praticien ne voit que les patients de son organisation |

Le RBAC est insuffisant seul pour des données de santé : le rôle "Praticien" ne suffit pas — il faut aussi que le praticien appartienne à la même organisation que le patient.

### Règles ABAC fondamentales

| Règle | Description |
|---|---|
| Isolation d'organisation | Un acteur ne voit que les ressources de son `organizationId` |
| Isolation de care team | Pour les données sensibles, l'accès est restreint aux membres de l'équipe de soin |
| Accès délégué | Un accès inter-organisation est possible uniquement avec un scope explicite dans le token |

### Voter Symfony — Structure

```
ClinicalContributionVoter {
    supports(attribute, subject):
        attribute IN [VIEW, PRODUCE, AMEND]
        subject IS ClinicalContributionResource

    voteOnAttribute(attribute, subject, token):
        actor = token.actorId
        switch attribute:
            VIEW:
                return actor.organizationId == subject.organizationId
            PRODUCE:
                return actor.hasRole(PRACTITIONER)
                    AND actor.organizationId == subject.organizationId
            AMEND:
                return actor.id == subject.auteurId
                    OR actor.hasRole(SUPERVISOR)
}
```

### Ce qui est interdit

| Interdit | Raison |
|---|---|
| Logique d'autorisation dans un Command Handler | L'autorisation précède la Command |
| Logique d'autorisation dans un Aggregate | L'Aggregate enforce des invariants métier — pas des règles d'accès |
| Requêtes base de données sans filtre `organization_id` | Isolation d'organisation non garantie |
| JWT sans signature asymétrique (RS256 ou ES256) | Risque de falsification |
| JWT sans expiration | Révocation impossible |

---

## 4. Isolation des données

### Règle fondamentale

Tout accès aux données cliniques est filtré par `organizationId`. Ce filtre est appliqué :
- dans tous les Query Handlers (clause WHERE obligatoire)
- dans tous les Voters (vérification d'attribut)
- dans les Repository Doctrine pour les agrégats multi-tenants

### Données partagées inter-organisations

Autorisées uniquement lorsque :
1. Un scope explicite figure dans le token JWT
2. Le Voter le valide explicitement
3. L'accès est loggué (audit — §5)

---

## 5. Audit

### Piste d'audit primaire — Domain Events

Les Domain Events sont la **piste d'audit primaire** de MedLink. Chaque Domain Event :
- porte un `actorId` (qui a effectué l'action)
- porte un `occurredAt` (quand)
- est immuable et persisté (P-05)
- est conservé indéfiniment (durée légale — données de santé)

La piste d'audit des actes cliniques est complète sans infrastructure supplémentaire.

### Piste d'audit secondaire — Accès en lecture

Pour les accès en lecture (consultation d'un dossier patient), les Domain Events ne sont pas produits (les Queries ne modifient pas le Domain). Un mécanisme d'audit complémentaire est requis par HDS pour tracer les accès.

| Événement | Mécanisme |
|---|---|
| Écriture clinique | Domain Event — piste primaire |
| Lecture de dossier patient | Access Log — table `access_audit` |
| Connexion / déconnexion | Identity Platform |
| Tentative d'accès non autorisée | Voter + Security Log (niveau WARNING) |

### Table d'accès (lecture)

```sql
CREATE TABLE access_audit (
    id              UUID        PRIMARY KEY DEFAULT gen_random_uuid(),
    actor_id        UUID        NOT NULL,
    organization_id UUID        NOT NULL,
    resource_type   VARCHAR(100) NOT NULL,
    resource_id     UUID        NOT NULL,
    action          VARCHAR(50) NOT NULL,
    accessed_at     TIMESTAMPTZ NOT NULL DEFAULT NOW(),
    correlation_id  UUID        NOT NULL
);
```

### Durée de rétention

| Données | Rétention |
|---|---|
| Domain Events (actes cliniques) | Durée légale — minimum 20 ans (données de santé) |
| Access Audit | Minimum 3 ans (HDS) |
| Logs applicatifs | Minimum 1 an |

---

## 6. Chiffrement

| Périmètre | Exigence |
|---|---|
| Données en transit | TLS 1.3 obligatoire — jamais HTTP en production |
| Données au repos | Chiffrement disque (hébergeur HDS) |
| Payload JSONB sensible | Chiffrement applicatif si données ultra-sensibles (ex : résultats génétiques) |
| Sauvegardes | Chiffrées et stockées dans une zone géographique conforme HDS |

---

## 7. Invariants protégés

| Invariant | Protégé par |
|---|---|
| Un acteur ne voit que les données de son organisation | ABAC isolation — §4 |
| Toute action clinique est traçable | Domain Events immuables — §5 |
| Aucun credential n'est stocké dans la Clinical Platform | Identity Platform — §2 |
| L'autorisation précède toujours la Command | Voter dans Interface Layer — §3 |
| Aucune donnée patient dans les logs | Politique de log — ADR-SA-024 |

---

## Références

| Document | Relation |
|---|---|
| ADR-SA-000 | Constitution logicielle |
| ADR-SA-017 | Runtime Architecture — couches |
| ADR-SA-024 | Observability — correlationId, logs d'accès |
| ADR-0002 | Business Platforms — Identity Platform propriétaire de l'auth |
| CLAUDE.md | HDS hosting mandatory in production |
