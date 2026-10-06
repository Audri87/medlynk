# « À traiter » — Fiche d'implémentation

| Field | Value |
|---|---|
| Objet | « À traiter » — **vue de travail, pas un Workspace** (pas de numéro WS) |
| Version | 0.2 |
| Date | 2026-10-06 |
| Statut | Décision produit `Founder-Driven`, `→ (evidence: ?)` — non testée |
| Sources | Décisions produit du 2026-10-06 · [ADR-0025](../../adr/ADR-0025-innovations-produit-non-observees.md) · [ADR-0006](../../adr/ADR-0006-capability.md) (port `WorkItemProvider`) · [HR-001](../../HR-001-hotspot-register-v1.md) H-PND-001 · [AR-001](../../AR-001-architecture-review.md) Finding-003 (annoté) |
| Prototype | `WS-002-WS-003-parcours-v8.html`, section `#todo` |

> Même nature que [CARE-RECORD-implementation](CARE-RECORD-implementation.md) : une fiche adossée à des
> décisions existantes, pas un Blueprint. « À traiter » n'est pas soumis au contrôle d'éligibilité
> Workspace (GOV-000 §4, Règle v1.8) parce qu'il ne revendique pas ce statut.

---

## Définition — `Product Decision`

« À traiter » est la **collection unique des actions restant à effectuer par le praticien**, y
compris celles qui n'ont pas pu être traitées au moment où elles sont apparues.

Ce n'est pas une liste de tâches générique : c'est la **continuité des actions restant à faire**.
Chaque élément conserve sa **provenance**, qui explique pourquoi il existe.

Principe à préserver : *MedLink ne doit pas seulement mémoriser ce qui s'est passé. Il doit permettre
au praticien de ne pas perdre ce qui reste à faire.*

## Provenances — `Product Decision`

| Provenance | Exemple | Origine dans l'existant | Preuve |
|---|---|---|---|
| **Interruption** | « Rappeler Dr Martin concernant Mme Dupont » | PP-011 (WS-003) ; capture : [HYP-003-005](WS-003-consultation.md) | `?` — Innovation |
| **Consultation** | Ordonnance à rédiger, courrier à produire, examen à demander | WS-003 §9 Mode Clôture (reste-à-faire, ⚠ 2026-10-06) | `?` |
| **Entrant** | Résultat, document, message, transmission demandant une action | WS-001 §6 Bloc Signals ; [WS-005](WS-005-implementation.md) (Transmission) | Transmission : Evidence 5 profils (ADR-0020) ; autres : `?` |
| **Fin de journée** | Élément gardé pour le lendemain | [WS-006](WS-006-implementation.md) HYP-006-002 | `✓` 1 profil pour le fait du report (ACT-F009-033) ; `?` pour le lieu de reprise (Finding-003) |

**Précision (prototype, non tranchée).** Un élément « gardé pour demain » **conserve sa provenance
d'origine** (un résultat reste "Entrant") — "gardé pour demain" est un état de l'élément, pas une
provenance. La provenance **Fin de journée** ne concerne donc qu'un élément *créé* au moment de la
clôture. WS-006 ne permet pas aujourd'hui d'en créer (non décidé) : le groupe "Fin de journée" est
vide dans le prototype. À trancher si le round montre un besoin de noter, en partant, une action
nouvelle.

## Propriété — `Product Decision`

Un seul propriétaire fonctionnel : « À traiter ». Les autres écrans affichent, signalent, ajoutent ou
traitent — ils ne possèdent pas de collection concurrente.

| Écran | Relation à « À traiter » |
|---|---|
| Mon espace (WS-001) | Compteur « À traiter [N] » + accès. Point d'entrée, pas propriétaire. Correspond au Bloc Obligations du Blueprint (§6), replié par défaut (PP-004) |
| WS-003 Consultation | **Alimente** : reste-à-faire non traité à la clôture ; action notée pendant une interruption (HYP-003-005) |
| WS-006 Fin de journée | **Vue filtrée** pour la revue de fin de journée (éléments du jour encore ouverts) ; geste « Garder pour demain ». Ne possède rien |
| Coordination (WS-005) | Garde l'historique des transmissions ; une transmission reçue demandant une action **apparaît** dans « À traiter » |
| Care Record | Aucune relation de propriété (ADR-0010 : le Care Record n'orchestre jamais de workflow) |
| « À votre attention » (Mon espace) | **Signal** (ce qui a changé), pas action (ce qui reste à faire) — voir WS-001 HYP-001-003 |

## Architecture — `Architecture Constraint`

**Lecture : une Projection, aucun nouveau concept Domain.** `CLAUDE.md` cite *"Next Actions"* parmi
les Projections. Le port existe déjà : `WorkItemProvider` (`src/Shared/Application/Port/Workspace/`,
ADR-0006), agrégé par `WorkspaceAssembler`, une implémentation par Platform. Les éléments dérivables
d'un fait existant (résultat non acquitté, Brouillon non validé, activité ouverte, transmission non lue)
ne demandent rien de plus que leur Platform d'origine.

**Écriture : question Domain ouverte.** Les actions créées par le praticien (interruption) et les
décisions de revue (garder pour demain, fait, écarter) ne dérivent d'aucun fait existant. Elles
exigent un modèle d'écriture et un propriétaire, non définis → [HR-001](../../HR-001-hotspot-register-v1.md)
**H-PND-001**, `Open`, lié à H-INT-001, H-VRB-001, H-ES-001. Aucun Aggregate « Tâche » n'est créé.

**Écart technique noté, non traité** (Engineering, après Gate 3) : le DTO `WorkItem` n'a ni provenance,
ni référence de sujet. `Shared` ne doit pas connaître le patient — une éventuelle extension passerait
par une référence générique, comme le `metadata` d'`AttentionItem`. Par ailleurs, `WorkItemProvider`
expose aujourd'hui des éléments *actifs* (`activeWorkItems`, `startedAt`) — la sémantique « reste à
faire » devra être vérifiée contre ce contrat, pas présumée identique.

## Hypothèses UX — `UX Hypothesis`

La **présentation** de la provenance n'est pas tranchée avant le test. Le prototype propose deux
variantes commutables, sans variante privilégiée.

```
HYP-AT-001 — Provenance visible sur chaque élément
Origine:            Founder-Driven
Problème visé:      Comprendre pourquoi un élément existe sans l'ouvrir
Hypothèse:          Afficher la provenance réduit le temps de décision sur chaque élément
Risque si faux:     Bruit visuel sur une liste déjà dense
Test:               Variante avec / sans provenance : "Pourquoi cet élément est-il là ?"
Critère d'abandon:  La majorité ne la lit pas ou sait répondre sans elle → provenance en information
                    secondaire (au survol ou à l'ouverture)
Statut:             ? ⚠ — À tester

HYP-AT-002 — Regroupement par provenance plutôt que par type
Origine:            Founder-Driven
Problème visé:      Retrouver "ce qui vient de ma consultation de ce matin" vs "tous mes courriers"
Hypothèse:          Le praticien pense en origine de l'action plutôt qu'en type de document
Risque si faux:     Perte du traitement par lot (tous les résultats d'un coup)
Test:               Les deux regroupements commutables ; tâches de recherche dans chacun
Critère d'abandon:  La majorité utilise le regroupement par type → regroupement par provenance retiré
Statut:             ? ⚠ — À tester
```

## États

- Collection peuplée — construit.
- Collection vide — non construit dans le prototype.
- Élément traité (disparition, ou historique ?) — non spécifié.

## Prototype — mis à jour le 2026-10-06

- Liste rendue depuis une collection unique (`todoItems`) : compteurs calculés partout (badges de la
  sidebar, tuile de Mon espace, tuiles de l'écran, tuile WS-006, écran de confirmation).
- Provenance portée par chaque élément ; **présentation non tranchée** : contrôle de test "Regrouper par
  Type / Provenance" et "Provenance masquée / visible", défaut = état antérieur. C'est un instrument de
  test, pas une fonctionnalité.
- Données : celles de l'écran existant, sans nouveau patient. Ajout de l'avis de cardiologie de Sophie
  Martin, qui figurait déjà dans WS-006 sans figurer dans « À traiter » (incohérence corrigée : 10
  éléments au lieu de 9).
- Alimentation réelle depuis WS-003 (HYP-003-005) et geste "Garder pour demain" depuis WS-006
  (HYP-006-002). Non construit : alimentation automatique par le reste-à-faire de Clôture.

## Constats sur le prototype actuel

- (Avant le 2026-10-06) L'écran regroupait par **type**, sans provenance.
- Des résultats marqués « Normal » y figurent sans action identifiable — un résultat normal est-il une
  action à faire (acquitter) ou un signal ? Non tranché, rejoint la frontière signal / action.

## Erreurs / cas limites non couverts

- Élément concernant un patient non vu aujourd'hui (interruption) — affiché, mais aucun contexte
  patient ouvert depuis WS-003.
- Élément jamais traité, reconduit indéfiniment — aucune règle de vieillissement.
- Doublon : même action née en consultation puis signalée par un entrant — non traité.

---

## Évolution

| Version | Date | Nature |
|---|---|---|
| 0.1 | 2026-10-06 | Création — décisions produit du 2026-10-06 (collection unique, provenance, propriété). Lecture : Projection via `WorkItemProvider` existant. Écriture : HR-001 H-PND-001 `Open`, aucun concept Domain créé. HYP-AT-001 et HYP-AT-002 ; présentation de la provenance non tranchée avant le test. |
| 0.2 | 2026-10-06 | Prototype mis à jour (collection unique, compteurs calculés, variantes de test pour la provenance, alimentation depuis WS-003 et WS-006). Précision : "gardé pour demain" est un état, pas une provenance ; la provenance Fin de journée ne couvre que les éléments créés à la clôture, non prévus à ce jour. |
