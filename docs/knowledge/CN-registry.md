# CN-registry — Registre des Cognitive Needs

**Type :** Registre normatif
**Statut :** Draft v0.1
**Date :** 2026-07-30
**Gouverné par :** CI-registry · CCF-000 · MKO-000
**Gouverne :** WR-xxx

---

## Principe

Un Cognitive Need est la traduction d'un Invariant en besoin humain concret, formulé du point de vue du praticien (voix active, première personne).

Il existe entre l'Invariant (proposition scientifique à la troisième personne) et le Requirement (contrainte système). Il est la voix du praticien dans la chaîne de dérivation.

**Règle de dérivation :** Tout CN doit être traçable à au moins un CI via la relation `IMPLIES`. Tout CN sans CI parent est invalide.

**Règle de traduction :** Un CN est formulé en *besoin ressenti*, pas en *contrainte technique*. "Je dois comprendre rapidement" — pas "le système doit afficher en < 30 secondes". Cela appartient au Requirement.

---

---

## CN-01 — Rapid Situation Understanding

**Identifiant :** CN-01
**Statut :** Active

### Définition

> *Je dois être capable de comprendre la situation actuelle d'un patient en quelques instants, avant d'agir. Si cette compréhension me prend trop de temps, mon acte clinique en souffre.*

### Motivation

CI-01 établit que la reconstruction existe. CN-01 traduit ce fait en besoin ressenti : le praticien *a besoin* que cette reconstruction soit rapide et fiable. La lenteur de reconstruction n'est pas une gêne ergonomique — c'est un risque clinique. Un praticien qui cherche l'information pendant qu'il essaie de raisonner dégrade les deux processus simultanément.

### Relations

```
CI-01  --[IMPLIES]-->        CN-01
CN-01  --[SATISFIED_BY]-->   WR-01 (reconstruction < 30s)
CN-01  --[SATISFIED_BY]-->   WR-04 (anchor de sécurité minimum)
CN-01  --[SATISFIED_BY]-->   WR-08 (mode suivi / mode découverte)
```

### Justification scientifique

Dérivé de CI-01. Observé directement :
- *"En 30 secondes je dois savoir où j'en suis."* — F-003
- *"Avant d'entrer, je relis rapidement mes notes."* — F-002

Le seuil des 30 secondes n'est pas un Requirement ici — c'est une observation qui guidera le Requirement WR-01.

### Dépendances

- **WR-01** — Reconstruction de contexte en < 30 secondes
- **WR-04** — Anchor de sécurité minimum accessible

### Historique des révisions

| Date | Version | Nature |
|---|---|---|
| 2026-07-30 | v1.0 | Création — dérivé de CI-01 |

---

---

## CN-02 — Delta Identification

**Identifiant :** CN-02
**Statut :** Active

### Définition

> *Pour un patient que je suis déjà, je n'ai pas besoin de retrouver qui il est. J'ai besoin de savoir ce qui a changé depuis la dernière fois que je l'ai vu. C'est toujours ma première question.*

### Motivation

CI-02 établit que le raisonnement delta est le mode dominant pour les patients connus. CN-02 traduit ce fait en besoin ressenti : le praticien ne veut pas un résumé de l'historique — il veut le changement. Présenter l'historique complet à un praticien en mode suivi, c'est répondre à la mauvaise question.

### Relations

```
CI-02  --[IMPLIES]-->        CN-02
CN-02  --[SATISFIED_BY]-->   WR-02 (delta comme état par défaut)
CN-02  --[SATISFIED_BY]-->   WR-08 (mode suivi / mode découverte)
```

### Justification scientifique

Dérivé de CI-02. Observé directement :
- *"L'évolution depuis la dernière séance."* — F-007
- *"Comment ça s'est passé, ce qui s'est amélioré, ce qui s'est aggravé."* — F-009
- *"Depuis quand une anomalie existe — c'est toujours la question."* — F-005

**Delta minimum observé chez F-009 :** état général, évolution positive, évolution négative, modification de traitement.

### Dépendances

- **WR-02** — Delta comme état par défaut
- **WR-08** — Deux modes de reconstruction

### Historique des révisions

| Date | Version | Nature |
|---|---|---|
| 2026-07-30 | v1.0 | Création — dérivé de CI-02 |

---

---

## CN-03 — Working Memory Relief

**Identifiant :** CN-03
**Statut :** Active

### Définition

> *Je ne peux pas tout retenir à la fois. Je dois pouvoir me concentrer sur ce qui compte maintenant, sans être submergé par ce qui n'est pas pertinent pour l'acte du moment.*

### Motivation

CI-03 établit que la mémoire de travail est limitée. CN-03 traduit ce fait en besoin ressenti : le praticien a besoin que l'environnement cognitif — l'interface incluse — ne lui impose pas de charge inutile. Chaque information affichée qui n'est pas nécessaire à l'action du moment est une dette cognitive.

**Note de traduction :** CN-03 se formule en termes de *concentration possible*, pas de *quantité d'information*. Ce n'est pas "je veux voir peu d'informations" — c'est "je veux pouvoir me concentrer sur ce qui compte". La nuance est importante pour éviter des interfaces appauvries.

### Relations

```
CI-03  --[IMPLIES]-->        CN-03
CN-03  --[SATISFIED_BY]-->   WR-03 (information minimale par défaut)
CN-03  --[SATISFIED_BY]-->   WR-07 (gestion du limbo informationnel)
```

### Justification scientifique

Dérivé de CI-03. Observé directement :
- *"Si je ne note pas, j'oublie."* — F-009
- *"La charge mentale est énorme. Tout le monde m'appelle."* — F-009
- *"Je note après la séance, pas devant le patient."* — F-004, F-006

**Trois stratégies satisfaisant CN-03 observées dans le corpus :**
- Externalisation (notes, templates)
- Filtrage (ne consulter que le strict nécessaire)
- Partitionnement temporel (reporter ce qui peut l'être)

### Dépendances

- **WR-03** — Information minimale par défaut
- **WR-07** — Gestion du limbo informationnel

### Historique des révisions

| Date | Version | Nature |
|---|---|---|
| 2026-07-30 | v1.0 | Création — dérivé de CI-03 |

---

---

## CN-04 — Network Visibility

**Identifiant :** CN-04
**Statut :** Active

### Définition

> *Je dois pouvoir voir ce que les autres praticiens ont fait, dit ou noté autour de ce patient. Sans cela, je travaille à l'aveugle dans un réseau de soin que je ne perçois pas.*

### Motivation

CI-04 établit que la cognition clinique est distribuée. CN-04 traduit ce fait en besoin ressenti : le praticien n'est pas seul autour d'un patient, et il a besoin de percevoir ce réseau pour y jouer son rôle correctement. Une interface qui ne montre que les contributions du praticien lui-même ampute une partie essentielle de son information clinique.

**Note de traduction :** CN-04 se formule en termes de *visibilité*, pas d'*accès*. Le praticien ne veut pas accéder à un module "équipe" — il veut que les contributions du réseau soient naturellement visibles dans son contexte de travail.

### Relations

```
CI-04  --[IMPLIES]-->        CN-04
CN-04  --[SATISFIED_BY]-->   WR-05 (contributions inter-pro visibles et attribuées)
CN-04  --[SATISFIED_BY]-->   WR-09 (file de triage pour coordinateurs)
```

### Justification scientifique

Dérivé de CI-04. Observé directement :
- *"Je fais le lien entre les médecins, les infirmières, les pharmaciens et les patients."* — F-009
- *"Tant que je n'ai pas inscrit le résultat, il n'existe pas vraiment pour l'équipe."* — F-007
- *"Le compte rendu est envoyé au médecin prescripteur."* — F-006, F-007, F-008

### Dépendances

- **WR-05** — Contributions inter-professionnelles visibles et attribuées
- **WR-09** — File de triage pour profils coordinateurs

### Historique des révisions

| Date | Version | Nature |
|---|---|---|
| 2026-07-30 | v1.0 | Création — dérivé de CI-04 |

---

---

## CN-05 — Source Awareness

**Identifiant :** CN-05
**Statut :** Active

### Définition

> *Je dois savoir qui a produit chaque information que je consulte, quand, et dans quel contexte clinique. Sans cette connaissance, je ne peux pas calibrer ma confiance.*

### Motivation

CI-05 établit que la confiance est calibrée par attribution. CN-05 traduit ce fait en besoin ressenti : le praticien ne consulte pas une information de façon neutre — il l'évalue en fonction de sa source. Une information sans attribution ne peut pas être pondérée. Elle est soit ignorée, soit acceptée aveuglément — dans les deux cas, le raisonnement clinique est dégradé.

### Relations

```
CI-05  --[IMPLIES]-->        CN-05
CN-05  --[SATISFIED_BY]-->   WR-06 (attribution obligatoire)
CN-05  --[SATISFIED_BY]-->   WR-05 (contributions inter-pro attribuées)
```

### Justification scientifique

Dérivé de CI-05. Observé directement :
- *"Je regarde toujours qui a prescrit, et quand."* — F-008
- *"Son traitement en cours — et donc par qui il a été prescrit."* — F-009

**Trois paramètres satisfaisant CN-05 :** auteur (qui), temporalité (quand), contexte de production (dans quelles circonstances).

### Dépendances

- **WR-06** — Attribution obligatoire de toute information
- **WR-05** — Attribution des contributions inter-professionnelles

### Historique des révisions

| Date | Version | Nature |
|---|---|---|
| 2026-07-30 | v1.0 | Création — dérivé de CI-05 |

---

*Registre CN — Draft v0.1 — 2026-07-30*
*Tout nouveau CN doit être traçable à un CI existant via IMPLIES.*
*Un CN sans CI parent est invalide (MKO-000 Constraint C-003).*
