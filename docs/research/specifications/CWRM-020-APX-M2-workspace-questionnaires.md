# CWRM-020-APX-M2 — Questionnaires de validation, un par Workspace

**Document ID :** CWRM-020-APX-M2
**Statut :** Draft — Protocole expérimental, hors core CWRM (même statut que CWRM-020-APX-WS005)
**Date :** 2026-08-06
**Depends on :** [CWRM-020](CWRM-020-interview-protocol.md) — toutes les IP-REQ-001→044 s'appliquent
**Origine :** Sprint 1 M2 (WS-002 "Comprendre"), étendu aux six Workspaces à la demande du Product Owner

---

## 0. Principe commun aux six questionnaires

Aucun de ces questionnaires ne part de zéro là où un artefact existe déjà. Pour chaque Workspace, la
première colonne est : *qu'est-ce qui est déjà écrit, et avec quelle confiance ?* Les questions
posées confrontent ce déjà-écrit au terrain — elles ne cherchent pas à réinventer.

**Critère de sortie commun**, applicable à toute traduction M2 issue de ces entretiens (rappel de la
règle discutée en session) :

1. Cohérente avec les lois de M1 (ACT/OBS/PAT/transformations déjà établies).
2. Confrontée à des praticiens (pas seulement conçue).
3. Non réfutée à ce stade.

Cette règle est l'équivalent, côté M2, de Gate 3 (GOV-000 §4, Design → Engineering) — elle ne le
remplace pas, elle l'applique à l'objet "traduction produit" spécifiquement.

**Format de chaque section :** rappel de l'existant → objectif du round → questions ciblées.

---

## 1. WS-001 — Morning Brief ("Me préparer")

**Existant.** PP-001 (*Signal precedes Horizon*, ancré ACT-F009-001/002 + 7 profils), PP-002
(*Preparation follows Uncertainty*, ACT-F004-003/F007-005/F001-015), PP-003 (*Context reconstruction
unified*, multi-source F001/F002/F009), PP-004 (*Obligations secondary, not invisible*,
ACT-F001-005/006/007). **Constat :** ces quatre Principles n'affichent pas de champ `Statut` avec
confiance chiffrée (contrairement à PP-005/006/008) — à corriger séparément, hors périmètre de ce
questionnaire.

**Objectif du round.** Valider si le triptyque Signal / Horizon / Obligations décrit réellement la
première minute de travail, et si son ordre de priorité (Signal avant tout) résiste à d'autres
profils que ceux déjà cités.

**Questions ciblées.**
- *"Racontez-moi votre arrivée au cabinet hier, ou votre dernier jour de travail."* (ancrage RP-001)
- *"Qu'est-ce que vous regardez en premier — avant même d'ouvrir un dossier patient ?"* (test PP-001)
- *"Qu'est-ce qui vous pousse à préparer un dossier à l'avance, plutôt que d'arriver et de le découvrir ?"* (test PP-002 — incertitude vs temps écoulé)
- *"Combien d'applications ou d'outils différents consultez-vous pour savoir où en est votre journée ?"* (test PP-003)
- *"Les tâches administratives du matin — vous les voyez tout de suite, ou seulement si vous allez les chercher ?"* (test PP-004)

---

## 2. WS-002 — Patient Context ("Comprendre")

**Existant.** PP-005 (*Surface the relevant recent interaction first*, ≈), PP-006 (*Historical depth
follows context gap*, ≈), PP-008 (*Collapse historical detail by default*, ≈) — les trois avec
exception documentée (échographiste). DR-001 à DR-004 — toutes `Draft`, `Validated: false`. La
transformation T2 (AR-001B, `Stable`) — *contexte absent → contexte reconstruit*.

**Objectif du round.** C'est le Workspace prioritaire de M2 (Sprint 1). Confronter les quatre Display
Rules à de vrais praticiens — aucune n'a encore été validée — et trancher, si possible, Challenge 1
et Challenge 3 de la session précédente : *"Reconstruire le contexte" est-il autre chose que T2 ?
Les micro-actes de reconstruction sont-ils universels ou spécifiques au métier ?*

**Questions ciblées.**
- *"Avant d'entrer voir ce patient, qu'est-ce que vous avez besoin de savoir ?"* (ancrage T2)
- *"Est-ce que vous diriez que vous 'reconstruisez le contexte', ou est-ce que ce terme ne correspond à rien de précis pour vous ?"* (test direct Challenge 1/7 — poser la question frontalement plutôt que déduire)
- *"Qu'est-ce que vous cherchez en premier — la dernière visite, ou autre chose ?"* (test DR-001/002 selon profil)
- *"Pour ce patient-là spécifiquement, l'historique complet vous sert-il, ou seulement le plus récent ?"* (test PP-006/008 et exception DR-003)
- *"Quand vous ouvrez ce patient, quelles informations d'identité ou de sécurité avez-vous besoin de voir immédiatement, sans les chercher — et lesquelles pouvez-vous retrouver seulement si nécessaire ?"* (ajoutée le 2026-08-06 — trois prototypes successifs ont fait osciller ce point entre 1 et 3 tags sans jamais le confronter au terrain ; à trancher en entretien, pas en itération de design)
- *"Si je vous demandais de me lister, dans l'ordre, ce que vous vérifiez systématiquement avant un patient — que diriez-vous ?"* (test de l'universalité des micro-actes, Challenge 3 — comparer la réponse entre profils "suivi" et profils "checklist")

---

## 3. WS-003 — Consultation (Gold Standard)

**Existant.** PP-009 à PP-015, toutes `Founder-Driven` (Model C). Evidence actuelle : PP-013 et
PP-014 renforcées à `≈` par WE-004 (7/9 profils). PP-009, 010, 011, 012, 015 restent `evidence: ?` —
décidées, jamais confrontées au corpus.

**Objectif du round.** Ne pas rouvrir tout le Workspace — Gold Standard, déjà stable en pratique.
Cibler exclusivement les cinq Principles encore sans ancrage empirique, pour savoir s'ils se
corroborent ou s'ils doivent être révisés en tant que décisions fondateur.

**Questions ciblées.**
- *"Pendant la consultation, où est votre ordinateur — physiquement, dans votre attention ?"* (test PP-009 — le logiciel s'efface)
- *"Pouvez-vous faire deux choses à la fois pendant une consultation — écouter et noter en même temps — ou est-ce que l'un chasse l'autre ?"* (test PP-010 — un seul focus cognitif)
- *"Si vous êtes interrompu en pleine consultation, comment reprenez-vous ensuite ?"* (test PP-011)
- *"Préférez-vous écrire librement, ou remplir des champs structurés ?"* (test PP-012)
- *"Comment savez-vous que la consultation est vraiment terminée, côté administratif ?"* (test PP-015)

---

## 4. WS-004 — nom à confirmer (persistance)

**Existant.** Aucun `PP-NNN` assigné spécifiquement. Mandat corrigé (WBD-004 v2.1, Finding-004) :
*"transformer la capture brute en mémoire clinique fiable, structurée, réutilisable — pour
soi-même."* Transformation T4 (AR-001B, `Stable`) — *capture brute → mémoire consolidée*.

**Objectif du round.** C'est le Workspace le moins mature en évidence formelle malgré une
transformation sous-jacente déjà stable. Découverte, pas seulement validation — y compris sur le nom,
toujours *"à confirmer"* depuis WBD-004 v1.0.

**Questions ciblées.**
- *"Qu'est-ce qui fait qu'une note que vous avez écrite est vraiment utilisable la prochaine fois — et qu'est-ce qui la rend inutilisable ?"* (critère de fiabilité, jamais documenté explicitement)
- *"À quel moment considérez-vous qu'une note est 'finie' ?"* (recoupe GAP-D-003, WE-004 — critère de fin jamais identifié)
- *"Si vous deviez donner un nom à ce moment où vous transformez vos notes brutes en quelque chose de réutilisable, quel mot utiliseriez-vous ?"* (utile pour trancher le nom du Workspace)
- *"Cette mémoire, vous la relisez vous-même — jamais quelqu'un d'autre ?"* (vérification directe que le mandat "pour soi-même" tient, au-delà des 9 profils déjà codés)

---

## 5. WS-005 — nom candidat *Clinical Coordination* (partage)

**Existant.** [CWRM-020-APX-WS005](CWRM-020-APX-WS005-coordination-guide.md) — grille déjà écrite,
ne pas la reconstruire. [Finding-005](../../AR-001-architecture-review.md) a mesuré la corroboration
réelle de chacune des quatre composantes du mandat : Transmission `Evidence` (5 profils), Avis
`Unsupported` (0 occurrence, corpus entier), Délégation `Observation` (1 profil, pas de verbatim
direct), Reprise de patient `Evidence — mais mal rattaché` (relève de T2, pas de WS-005).

**Objectif du round.** Ce n'est pas une nouvelle grille — c'est un complément ciblé sur exactement ce
que Finding-005 a laissé ouvert. Sonder frontalement "avis" plutôt que d'attendre qu'il émerge,
élargir "délégation" à d'autres profils que F009, et clarifier le store de sortie de la transmission
(non précisé même après correction de WBD-004).

**Questions ciblées.**
- *"Vous arrive-t-il de demander l'avis d'un confrère avant de décider quelque chose pour un patient ? Dans quelles circonstances ?"* (sonde directe — jamais posée telle quelle jusqu'ici, ce qui peut expliquer l'absence totale dans le corpus)
- *"Vous arrive-t-il de transférer une tâche ou un patient à un collègue ? Comment décidez-vous à qui, et comment le collègue sait-il quoi faire ?"* (élargir Délégation au-delà de F009)
- *"Quand vous transmettez une information à quelqu'un — patient ou confrère — est-ce que ça repart dans le dossier du patient, ou est-ce que ça part par un autre canal complètement ?"* (store de sortie, question laissée ouverte par AR-001 Finding-004)
- **Ne pas sonder** *"reprise de patient"* dans ce questionnaire — déjà rattaché à T2/WS-002 (Finding-005), y revenir ici recréerait la confusion déjà corrigée.

---

## 6. WS-006 — "Je termine" (clôture)

**Existant.** Aucun Blueprint. Statut `Research Workspace` (GOV-000 §4). Evidence éparse :
ACT-F001-024→027 (vérification matériel, sauvegarde, tour du cabinet, sortie), ACT-F007-025
(fermeture des dossiers), ACT-F009-033 (report des tâches non terminées). WE-004 (Q8) documente déjà
un *"GAP quasi complet"* : aucun praticien n'a formulé de critère de fin pour une note isolée — le
même flou existe probablement pour la journée entière.

**Objectif du round.** Le plus exploratoire des six — découverte pure, pas validation. Deux questions
non résolues à couvrir en priorité : le critère de fin de journée lui-même, et la frontière avec
WS-001 du lendemain (jamais spécifiée — signalée comme Finding candidat non formalisé, REV-001 §8).

**Questions ciblées.**
- *"Comment savez-vous que votre journée est vraiment terminée ?"* (comble directement le GAP Q8 de WE-004, appliqué à l'échelle de la journée)
- *"Qu'est-ce qui vous empêcherait de partir tranquille, ce soir ?"* (critère négatif — ce qui bloque la clôture, pas ce qui la permet)
- *"Le lendemain matin, est-ce que vous repensez à ce qui restait en suspens la veille — et comment vous en souvenez-vous ?"* (sonde directement la frontière WS-006 → WS-001, jamais spécifiée)
- *"Les tâches reportées — vous les retrouvez où, le lendemain ?"* (mécanisme concret du report, ACT-F009-033)

---

## Historique

| Date | Version | Nature |
|---|---|---|
| 2026-08-06 | 0.1 | Draft initial — six questionnaires, chacun ancré dans l'existant (PP-NNN, DR-NNN, WBD-004, Finding-005) plutôt que construit à partir de zéro |
