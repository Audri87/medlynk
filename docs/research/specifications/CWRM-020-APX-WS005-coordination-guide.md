# CWRM-020-APX-WS005 — Grille d'entretien/codage : Coordination clinique

---

## 0. Metadata

| Field | Value |
|---|---|
| Document ID | CWRM-020-APX-WS005 |
| Title | Interview & Coding Guide Supplement — Coordination clinique |
| Version | 0.3 |
| Status | Draft — Instrument non normatif (supplément informatif à CWRM-020) |
| Layer | 100 — Method (application ciblée) |
| Date | 2026-08-05 |
| Authors | CWRM Research Team |
| Depends on | [CWRM-020](CWRM-020-interview-protocol.md) — toutes les IP-REQ-001→044 restent applicables · [CWRM-001](CWRM-001-research-method.md) v2.1 — OBS-REQ-001/002/003 |
| Consommé par | Protocole de test WS-005, [GOV-000](../../process/GOV-000-medlink-governance-v1.0.md) §1ter-b |
| Origine | [WBD-004](../../product/workspaces/WBD-004-consultation-vs-documentation.md) — trou identifié entre WS-003 et WS-006 ("WS-005 — Je partage") |

### Changelog

| Version | Date | Nature |
|---|---|---|
| 0.1 | 2026-08-05 | Draft initial — formalisation de la grille ACT/OBS/PAT fournie en session |
| 0.2 | 2026-08-05 | Ajout de la Section 1bis — Principes de recherche (RP-WS005-001 à 005 : falsification avant confirmation, séparation observation/interprétation, exhaustivité avant synthèse, journal des découvertes inattendues, Definition of Done) |
| 0.3 | 2026-08-05 | Ajout de la Section 6bis — PAT-REQ-001 (Pattern explique des Observations), explicitement scopé à ce document suite à un conflit identifié avec CWRM-AF-001 (gel architectural du pipeline core). OBS-REQ-001/002/003 correspondantes formalisées côté CWRM-001 v2.1 (pas dans ce document). |

---

## 1. Statut de ce document

Ce document **n'est pas une nouvelle spécification CWRM**. Il ne s'insère pas dans le pipeline
`CWRM-020 → 030 → 040 → 050 → 060 → 070` (voir [INDEX](INDEX.md)). C'est un **supplément
d'application** : une grille de sonde et de codage, à utiliser *en plus* de CWRM-020, avec un
objectif unique — faire émerger les signaux Layer 1 (ACT/OBS) nécessaires pour tester l'hypothèse
Responsibility de WS-005 (GOV-000 §1ter-b).

Toutes les exigences normatives de CWRM-020 (consentement, anonymisation, verbatim, versioning des
transcripts, etc.) s'appliquent sans exception. Ce document n'en retire ni n'en assouplit aucune.

---

## 1bis. Principes de recherche

Ce supplément applique les principes généraux de CWRM-020 à une question de recherche spécifique.
Les règles suivantes s'ajoutent à celles déjà définies dans CWRM-020 et s'appliquent à toute
utilisation de cette grille.

### RP-WS005-001 — Falsification avant confirmation

La Responsibility candidate de WS-005 (*Clinical Coordination*, provisoire) constitue une hypothèse
de travail.

Cette grille n'a pas pour objectif de confirmer cette hypothèse.

Elle a pour objectif de produire les observations permettant de la confirmer, de la nuancer ou de la
réfuter.

Si les observations montrent que la continuité clinique repose sur une autre responsabilité, cette
dernière prévaut.

Le corpus est toujours prioritaire sur l'hypothèse produit.

---

### RP-WS005-002 — Séparation Observation / Interprétation

Pendant le recodage :

- seuls les ACT et les OBS sont produits ;
- aucune Product Question n'est reformulée ;
- aucun Pattern n'est formulé tant que l'ensemble des transcripts n'a pas été recodé.

Toute interprétation est reportée à WE-005.

---

### RP-WS005-003 — Exhaustivité avant synthèse

Le recodage est considéré comme terminé uniquement lorsque l'ensemble du corpus ciblé a été
parcouru.

Aucune synthèse ne peut être produite à partir d'un sous-ensemble de transcripts.

---

### RP-WS005-004 — Journal des découvertes inattendues

Toute observation importante ne relevant pas des cinq axes de cette grille est enregistrée dans un
journal des découvertes inattendues (`Unexpected Findings`).

Ces éléments ne participent pas à WE-005 mais peuvent conduire à l'ouverture d'un futur Workspace ou
d'un futur PDX.

Ils ne doivent jamais être ignorés.

---

### RP-WS005-005 — Definition of Done

La grille est considérée comme exécutée lorsque :

- tous les transcripts ciblés ont été recodés ;
- tous les ACT pertinents ont été extraits ;
- les OBS ont été consolidées ;
- aucune décision produit n'a encore été formulée ;
- WE-005 peut être rédigé à partir des observations recueillies.

---

## 2. Pourquoi ce document existe

`WBD-004` a identifié un trou dans la Clinical Loop :

```
WS-001 → WS-002 → WS-003 → ??? → WS-005 (« Je partage ») → WS-006
```

`GOV-000 v1.5 §1ter-b` fait de WS-005 le premier test de l'hypothèse méthodologique
**Cognitive Responsibility** (`Responsibility → Product Question → Workspace`), avec un nom de
Responsibility candidat déjà retenu : **Clinical Coordination**. Le protocole de test exige de
construire WS-005 "en partant réellement" de cette Responsibility — ce qui suppose de disposer
d'abord d'un corpus de preuve (ACT/OBS) réellement centré sur elle. C'est le rôle de cette grille.

Elle formalise la trame ACT/OBS/PAT fournie en session, structurée autour de cinq axes retenus
explicitement (Section 5) : **confiance, continuité, transmission, responsabilité, coordination**.

---

## 3. Deux modes d'application

**Mode A — Recodage rétrospectif du corpus existant (prioritaire, coût nul en collecte).**
Le corpus F-001 à F-009 (`docs/research/interviews/`) est déjà Accepted (v2.0) au sens CWRM-020 §10.
Un premier passage de recodage avec cette grille, sans nouvel entretien, est possible et recommandé
avant toute nouvelle collecte — en particulier sur les profils à surface de coordination visible :

| Profil | Pourquoi prioritaire |
|---|---|
| F-009 — Infirmière coordinatrice | Déjà codée avec des ACT explicites de coordination (ACT-F009-027 à 031 : relais entre médecins/pharmaciens, transmission, passage de relais) |
| F-006 — Sage-femme | Suivi longitudinal, probable relais avec gynécologue/médecin traitant — non encore sondé sous cet angle |
| F-008 — Infirmière libérale | Coordination domicile/prescripteur probable — non encore sondée sous cet angle |
| F-002 — Infirmière sophrologue | Angle de recoupement avec le médecin prescripteur — à vérifier |

Vérification faite sur les ACT déjà codées : aucun de F-002, F-006, F-008 ne contient aujourd'hui
d'action taguée coordination — ce n'est pas une preuve d'absence, seulement une preuve que cette
grille n'a pas encore été appliquée à ces transcripts.

**Mode B — Sonde supplémentaire en nouvel entretien.** Pour toute nouvelle Production Interview
(CWRM-020 §7.4), cette grille s'ajoute comme relance systématique en **Phase 3** (description de
journée) et **Phase 5** (frictions/exceptions), sans remplacer les questions d'ancrage existantes.

---

## 4. Grille ACT — actions à sonder

Pour chaque action listée, la question de sonde reste soumise à IP-REQ-018 (question ouverte) et
IP-REQ-020 (sonde autorisée uniquement) — reformulation dans les termes du participant, jamais de
question fermée ou orientée.

| Action | Sonde suggérée | Phase CWRM-020 |
|---|---|---|
| Transmet (une information, un dossier, une décision) | *"À qui avez-vous transmis cela, et comment ?"* | 3, 4 |
| Reçoit | *"Comment avez-vous reçu cette information — et qu'en avez-vous fait ensuite ?"* | 3, 4 |
| Demande un avis | *"Qu'est-ce qui vous a fait demander un avis à ce moment précis ?"* | 3, 5 |
| Délègue | *"Qu'est-ce que vous avez délégué, et à qui ? Comment avez-vous su que c'était fait ?"* | 3, 5 |
| Reprend un patient (déjà suivi par un confrère) | *"Qu'est-ce que vous aviez besoin de savoir avant de reprendre ce patient ?"* | 3 |
| Relit un courrier | *"Qu'est-ce que vous cherchiez dans ce courrier ?"* | 4 |
| Téléphone (à un confrère, un service) | *"Qu'est-ce qui a déclenché l'appel plutôt qu'un écrit ?"* | 3, 5 |
| Répond à un confrère | *"Comment cette demande vous est-elle parvenue, et qu'avez-vous dû retrouver pour y répondre ?"* | 3, 4 |
| Reprend après hospitalisation | *"Qu'est-ce qui manquait, à ce moment, pour reprendre le suivi ?"* | 3, 5 |

---

## 5. Grille OBS — déclencheurs à écouter

Ces déclencheurs ne sont **pas** des catégories de codage final (celles-ci restent définies par
CWRM-030, à venir) — ce sont des signaux d'alerte pendant l'entretien ou la relecture, qui indiquent
qu'un verbatim mérite une relance ou une extraction ACT.

| Déclencheur | Signal verbatim attendu | Relance suggérée |
|---|---|---|
| Perte de contexte | *"je ne savais pas que..."*, *"j'ai dû tout redemander"* | *"Qu'est-ce qui vous aurait évité de redemander ça ?"* |
| Mauvaise décision (évitable) | *"si j'avais su..."*, *"on a refait l'examen car..."* | *"Qu'est-ce qui aurait dû être disponible à ce moment ?"* |
| Redondance | *"je l'ai redemandé"*, *"ça a été refait deux fois"* | *"Pourquoi cette information n'était-elle pas déjà là ?"* |
| Appel téléphonique (comme symptôme, pas comme action neutre) | *"j'ai dû appeler pour être sûr"* | *"Qu'est-ce qu'un écrit ne vous aurait pas donné ?"* |
| Courrier jugé inutile | *"ce courrier ne sert à rien"*, *"je ne le lis même plus"* | *"Qu'est-ce qui en ferait un courrier utile ?"* |
| Confiance (accordée) | *"je sais que je peux compter sur..."* | *"Qu'est-ce qui vous fait dire ça ?"* |
| Méfiance / défiance | *"je préfère vérifier moi-même"*, *"je ne me fie pas à..."* | *"Qu'est-ce qui vous a amené à revérifier ?"* |

---

## 6. Grille PAT — restriction de portée explicite

Cette grille **ne recherche que** des patterns relevant des cinq axes suivants. C'est une
restriction délibérée, pas un oubli :

- **Confiance**
- **Continuité**
- **Transmission**
- **Responsabilité**
- **Coordination**

Tout signal extrait qui ne se rattache à aucun de ces cinq axes reste hors du périmètre de cette
grille — il peut être codé normalement par ailleurs (CWRM-020/030 générique), mais n'entre pas dans
la synthèse WS-005 issue de ce supplément.

---

## 6bis. Pattern (PAT) — objet local, non intégré au pipeline CWRM core

> ⚠️ **Portée limitée à ce document.** `CWRM-AF-001` (Architectural Freeze v1.0, Accepted —
> Binding, 2026-08-04) gèle la chaîne méthodologique `Interview → ACT → Observation → Invariant →
> Requirement → Design Decision` et interdit toute nouvelle couche architecturale sans passer par le
> protocole d'évolution à 5 questions (§"Critères d'acceptation pour toute évolution future").
> **PAT-REQ-001 ci-dessous ne s'applique donc qu'à l'usage de "Pattern" dans ce supplément WS-005.**
> Il ne modifie ni CWRM-001 ni CWRM-000A, et ne fait pas de Pattern un objet du pipeline core. Une
> promotion éventuelle de Pattern en objet CWRM officiel devra répondre aux cinq questions de
> CWRM-AF-001 avant toute intégration à CWRM-001/CWRM-000A.

**PAT-REQ-001**
**Titre :** Un Pattern explique des Observations
**Énoncé :** Dans le cadre de ce supplément, un Pattern explique une ou plusieurs Observations
produites selon la Grille OBS (Section 5) et restreintes aux cinq axes de la Section 6. Un Pattern
n'est jamais formulé directement depuis un ACT — il présuppose au moins une OBS.
**Vérification :** Toute entrée Pattern cite explicitement la ou les OBS qu'elle explique.
**Rationale :** Conserve, à l'échelle de ce document, la séparation Observation/Interprétation déjà
posée par RP-WS005-002 — un Pattern est par nature interprétatif (il *explique*), ce qui est
précisément ce qu'une OBS s'interdit (OBS-REQ-002).
**Dépendances :** RP-WS005-002, RP-WS005-003 (aucun Pattern avant recodage exhaustif), OBS-REQ-001/002
(CWRM-001 v2.1)
**Statut vis-à-vis du core CWRM :** Candidat, non intégré — voir avertissement ci-dessus.

---

## 7. Sorties attendues

- Nouvelles entrées `ACT-Fxxx-0yy` (recodage) ou `ACT-Fxxx` (nouvel entretien), taguées `[WS-005]`
  dans la colonne Contexte pour les distinguer de la première vague de codage.
- Entrées `OBS-Fxxx` correspondantes, même tag.
- Ces sorties alimentent une future synthèse **WE-005** (sur le modèle de
  [WE-004](../../product/workspaces/WE-004-documentation.md)), qui elle-même nourrit la formulation
  des Product Questions de WS-005 (GOV-000 §1ter-b, étape 1).
- Un **journal des découvertes inattendues** (`Unexpected Findings`, RP-WS005-004) est tenu en
  parallèle : toute observation notable hors des cinq axes de la Section 6 y est consignée plutôt
  que rejetée. Il n'alimente pas WE-005 mais peut justifier l'ouverture d'un futur Workspace ou PDX.
  Aucun format de fichier n'est imposé par ce document ; le recodage peut, par exemple, le tenir comme
  fichier `docs/research/observations/UF-WS005-log.md`.

---

## 8. Ce que ce document ne fait pas (Out of Scope)

- Il ne décide pas des Product Questions de WS-005 — cela reste un artefact Product distinct
  (`WE-005` puis PDX/WBD si nécessaire), pas ce document de méthode.
- Il ne valide ni ne réfute l'hypothèse Cognitive Responsibility elle-même (GOV-000 §1ter-b) — il
  ne fait que produire la preuve Layer 1 nécessaire à ce jugement.
- Il ne remplace aucune exigence de CWRM-020 (IP-REQ-001 à 044 s'appliquent intégralement en Mode B).
- Il n'introduit aucun vocabulaire Domain — "Clinical Coordination" reste vocabulaire Product,
  jamais un concept Domain (GOV-000 §1ter-a, rappel explicite).

---

## 9. Dépendances

### Incoming

| Spécification | Nature de la dépendance |
|---|---|
| CWRM-020 — Interview Protocol | Toutes les IP-REQ restent contraignantes ; ce document en est un supplément d'application |
| CWRM-001 — Research Method | Définitions ACT / OBS |

### Outgoing

| Artefact | Nature de la dépendance |
|---|---|
| WE-005 *(à venir)* | Reçoit les ACT/OBS taggés `[WS-005]` produits par cette grille |
| GOV-000 §1ter-b — Protocole de test WS-005 | Consomme WE-005 pour formuler `Responsibility → Product Question → Workspace` |

---

## Historique

| Date | Version | Nature |
|---|---|---|
| 2026-08-05 | 0.1 | Draft initial — formalisation de la grille ACT/OBS/PAT (transmission, réception, avis, délégation, reprise de patient, courrier, téléphone, confrère, sortie d'hospitalisation ; déclencheurs de perte de contexte, décision, redondance, confiance/méfiance ; restriction de portée aux cinq axes confiance/continuité/transmission/responsabilité/coordination) |
