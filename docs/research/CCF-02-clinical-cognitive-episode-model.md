# CCF-02 — Clinical Cognitive Episode Model

**Type :** Research Foundation — Authoritative Document
**Statut :** Draft v1.0 — Corpus ambulatoire libéral (F-001 → F-009)
**Date :** 2026-07-30
**Framework :** Clinical Cognition Framework — CCF-000
**Dépend de :** CCF-01 — Clinical Cognitive Architecture
**Autorité :** Ce document est la seconde fondation scientifique de MedLink.
Il introduit et formalise le Clinical Cognitive Episode (CCE) comme unité d'analyse de la cognition clinique.
Il est indépendant de toute implémentation produit, interface ou composant.

---

## Définition fondatrice

Le **Clinical Cognitive Episode (CCE)** est l'unité fondamentale d'analyse de la cognition clinique.

Il représente un épisode cognitif délimité, débutant lorsqu'un praticien prend en charge une situation clinique et se terminant lorsque cette situation est stabilisée par une décision, une action ou un transfert de responsabilité.

Ce document formalise la structure temporelle du CCE : ses phases, ses transitions, ses ruptures, et ses propriétés transversales.

---

## Position dans le CCF

```
REALITY
════════════════════════════════════════════════════════════════
  Clinical Work

                            │
                            ▼

SCIENTIFIC FRAMEWORK
════════════════════════════════════════════════════════════════

  Clinical Cognitive Architecture                    CCF-01

► Clinical Cognitive Episode                   ◄ CE DOCUMENT
  ─────────────────────────────────────────────────────────────
  L'unité fondamentale d'analyse.
  7 phases. Transitions. Ruptures. Modèle dynamique.

  Cognitive Invariants                               CI-xxx

                            │
                            ▼

PRODUCT SPECIFICATION
════════════════════════════════════════════════════════════════
  Workspace Requirements (WR) · UX Principles (UX)

                            │
                            ▼

WORKSPACES
════════════════════════════════════════════════════════════════
  Patient · Practitioner · Collaboration · Care · Organisation
```

---

## Avertissement épistémologique

Ce document est un modèle, pas une théorie.

Un modèle est une représentation simplifiée d'un phénomène réel, conçue pour être utile à la prédiction et à la conception. Il est volontairement incomplet — sa valeur est dans sa solidité, pas dans son exhaustivité.

Un modèle est falsifiable. Chaque phase de ce document peut être réfutée par une observation empirique documentée. Si un profil clinique montre un ordre différent, une phase absente, ou un mécanisme non prévu, ce document est mis à jour.

Chaque affirmation est traçable à :
- une observation du corpus F-001 → F-009, ou
- une référence de la littérature scientifique

Aucune affirmation n'est une inférence créative.

**Corpus couvert :** Professionnels de santé libéraux en contexte ambulatoire — France — 2026.
**Extension prévue :** Contexte hospitalier, urgences, équipes pluridisciplinaires.

---

## Question fondatrice

> Quelle est la structure temporelle d'un Clinical Cognitive Episode ?

Le CCE est défini ci-dessus comme l'unité d'analyse. Ce document répond à une question plus précise : comment se déploie-t-il ?

CCF-01 a décrit la **structure** de la cognition clinique — ses invariants, ses familles, son cycle général.
CCF-02 décrit la **dynamique** d'un épisode : l'ordre des phases, les transitions entre elles, les points de rupture, les mécanismes de compensation.

CCF-01 est l'anatomie. CCF-02 est la physiologie.

Tout document MedLink qui modélise une consultation, une visite ou une interaction clinique utilise le CCE comme unité de référence.

---

---

# I. Terminologie — Pourquoi pas "Cognitive Flow"

## Le problème du terme "Cognitive Flow"

Le terme "Flow" (flux cognitif) pose deux problèmes scientifiques.

**Problème 1 — Conflit de nomenclature.** "Flow" est un terme technique établi en psychologie cognitive. Il désigne un état d'expérience optimale caractérisé par l'absorption totale dans une activité (Csikszentmihalyi, 1975). Utiliser "Cognitive Flow" pour désigner autre chose créerait une confusion avec ce corpus existant.

**Problème 2 — Manque de spécificité.** Toute séquence cognitive possède un "flux" au sens ordinaire du terme. Ce mot ne distingue pas ce phénomène d'autres phénomènes cognitifs. Il ne pointe vers aucun cadre théorique précis.

## Les alternatives existantes dans la littérature

| Terme | Origine | Adéquation |
|---|---|---|
| **Situation Awareness Cycle** | Endsley, 1988 | Partiel — couvre Perception → Projection, pas Action → Documentation |
| **Recognition-Primed Decision Process** | Klein, 1993 | Partiel — couvre Reconnaissance → Décision, pas Documentation → Cycle |
| **Clinical Reasoning Episode** | Higgs & Jones, 2000 | Proche — mais "Reasoning" est une des phases, pas le tout |
| **Cognitive Task Episode** | CTA — Crandall, Klein, Hoffman, 2006 | Trop générique — non spécifique au clinique |
| **Clinical Situation Assessment** | Endsley appliqué au clinique | Trop centré sur l'évaluation — n'inclut pas Action et Documentation |

## Proposition : Clinical Cognitive Episode (CCE)

**Justification :**

*Episode* est un terme précis en sciences cognitives. Il désigne une unité d'activité cognitive, temporellement délimitée, avec un début et une fin identifiables (Tulving, 1972 — mémoire épisodique ; Zacks et al., 2007 — segmentation des événements cognitifs). Un Episode a une entrée, un traitement, une sortie.

*Clinical* délimite le domaine — il ne s'agit pas d'un épisode cognitif quelconque, mais d'un épisode engagé autour d'un patient clinique.

*Cognitive* précise que l'objet est le processus mental — pas l'acte physique, pas le dossier, pas la relation.

**Le terme retenu pour ce document :** Clinical Cognitive Episode (CCE).

**Ce que le CCE délimite :**

Un CCE commence au moment où le praticien engage son attention sur un patient (ouverture du contexte, arrivée au domicile, entrée dans la chambre). Il se termine au moment où la documentation est close et le contexte transmis. Entre ces deux bornes se déploie l'ensemble du processus cognitif décrit dans ce document.

**Le CCE est l'unité atomique de l'activité clinique.** Une journée de travail est une succession de CCE. Un suivi de patient est une série de CCE connectés — la documentation d'un CCE est l'input du CCE suivant (cf. CCF-01 — le cycle fermé).

---

---

# II. Critique du modèle initial proposé

Le modèle initial proposé comportait neuf phases :

```
Perception → Reconstruction du contexte → Construction du modèle mental
→ Raisonnement clinique → Projection → Décision → Action
→ Documentation → Nouvelle situation clinique
```

Cette section documente le challenge de ce modèle phase par phase.

## Phase 1 et 2 — Perception et Reconstruction du contexte

**Problème :** "Perception" est un terme trop générique. Tout acte humain commence par la perception. Ce terme ne capture pas ce qui est spécifique à l'entrée dans un acte clinique.

**Analyse :** Dans le corpus, le déclencheur du CCE n'est pas un acte de perception neutre — c'est une *orientation* : le praticien dirige son attention vers ce patient, maintenant. F-003 : *"En 30 secondes je dois savoir."* Ce n'est pas de la perception passive — c'est une mise en route cognitive délibérée.

**Décision :** Remplacer "Perception" par **"Situation Intake"** — terme qui capture à la fois la réception des signaux et l'orientation attentionnelle vers le patient.

## Phase 2 et 3 — Reconstruction du contexte et Construction du modèle mental

**Problème :** Ces deux phases ne sont pas temporellement séquentielles — elles sont deux faces du même processus cognitif. On ne peut pas "reconstruire le contexte" sans "construire le modèle mental" — ce sont le processus (reconstruction) et son résultat (modèle) d'une même opération.

**Analyse :** Dans Endsley (1995), les niveaux 1 et 2 de Situation Awareness (Perception des éléments / Compréhension de la situation) constituent un seul processus d'évaluation de la situation, pas deux étapes séquentielles.

**Décision :** Fusionner en une seule phase — **"Situation Assessment"** — avec deux modes selon le contexte (delta pour patient connu, état pour patient nouveau).

## Phase 5 — Projection

**Problème apparent :** La Projection est souvent absente des modèles linéaires de raisonnement clinique. Certains auteurs l'intègrent dans le Raisonnement. Faut-il la supprimer ?

**Analyse :** Non. La Projection est une opération cognitive distincte. Dans Klein (1993), le mental simulation step du RPD est analytiquement séparable de la génération d'hypothèses. Un praticien peut raisonner *sur* la situation actuelle sans simuler *l'évolution future*. Ce sont deux opérations cognitives différentes — l'une descriptive (qu'est-ce qui se passe ?), l'autre prédictive (qu'est-ce qui va se passer si...).

Corpus : F-006 (sage-femme) projette explicitement les prochaines phases du terme. F-004 (psychologue) projette l'évolution de la relation thérapeutique. F-009 (coordinatrice) projette les conséquences de chaque décision sur le réseau.

**Décision :** **Conserver la Projection comme phase distincte.** Mais noter qu'elle peut être quasi-instantanée (experte, S1) ou délibérative (novice, situation complexe, S2).

## Phase 6 et 7 — Décision et Action

**Problème :** Pour les experts en situations familières, Décision et Action semblent fusionnées — il n'y a pas de délibération consciente entre les deux (Klein, 1993 — RPD).

**Analyse :** C'est vrai expérientiellement. Mais analytiquement, ce sont deux opérations distinctes : l'une sélectionne une réponse (Décision), l'autre l'exécute (Action). La distinction est cliniquement importante — une décision peut être prise et différée, déléguée, ou abandonnée avant l'action. Dans F-009, la décision de déléguer EST la décision — l'action est ensuite exécutée par une collègue.

**Décision :** **Conserver Décision et Action comme phases distinctes.** Mais noter leur fusion expérientielle fréquente chez les experts.

## Phase 8 et 9 — Documentation et Nouvelle situation clinique

**Problème :** "Nouvelle situation clinique" n'est pas une phase cognitive — c'est un état émergent. Elle ne comporte aucune opération cognitive propre.

**Analyse :** La "nouvelle situation clinique" est le résultat de la Documentation et de la Transmission. Elle n'est pas produite par une opération cognitive spécifique — elle émerge de l'ensemble du CCE.

**Décision :** **Supprimer "Nouvelle situation clinique" comme phase.** La remplacer par une note sur la fermeture du cycle : la Documentation & Transmission produit l'input du prochain CCE et enrichit le contexte distribué de l'équipe.

## Résultat de la critique

Le modèle initial à 9 phases est réduit à **7 phases** :

| Phase initiale | Phase retenue | Raison |
|---|---|---|
| Perception | → Situation Intake | Plus précis pour le contexte clinique |
| Reconstruction du contexte + Construction du modèle mental | → Situation Assessment | Même opération cognitive — deux aspects |
| Raisonnement clinique | → Clinical Reasoning | Conservé |
| Projection | → Projection | Conservé — analytiquement distinct |
| Décision | → Decision | Conservé |
| Action | → Action | Conservé |
| Documentation + Nouvelle situation | → Documentation & Transmission | Fusion — la "nouvelle situation" est un état, pas une phase |

---

---

# III. Le modèle retenu — Clinical Cognitive Episode (7 phases)

```
╔═══════════════════════════════════════════════════════════════════╗
║                                                                   ║
║         CLINICAL COGNITIVE EPISODE (CCE)                         ║
║                                                                   ║
╠═══════════════════════════════════════════════════════════════════╣
║                                                                   ║
║  Phase 1    SITUATION INTAKE                                      ║
║             ──────────────────────────────────────────────────   ║
║             Le praticien s'oriente vers ce patient,               ║
║             maintenant. Réception des signaux initiaux.           ║
║                              ↓                                    ║
║  Phase 2    SITUATION ASSESSMENT                                  ║
║             ──────────────────────────────────────────────────   ║
║             Construction du modèle mental exploitable.            ║
║             Mode delta (connu) ou Mode état (nouveau).            ║
║             Sources : mémoire + artefacts + contributions réseau. ║
║                              ↓                                    ║
║  Phase 3    CLINICAL REASONING                                    ║
║             ──────────────────────────────────────────────────   ║
║             Interprétation de la situation actuelle.              ║
║             Génération et évaluation d'hypothèses.                ║
║             S1 (pattern) ou S2 (analyse délibérative).            ║
║                              ↓                                    ║
║  Phase 4    PROJECTION                                            ║
║             ──────────────────────────────────────────────────   ║
║             Simulation mentale des états futurs.                  ║
║             "Si je fais X, que se passe-t-il ?"                   ║
║             Évaluation des options de réponse.                    ║
║                              ↓                                    ║
║  Phase 5    DECISION                                              ║
║             ──────────────────────────────────────────────────   ║
║             Sélection et engagement sur une réponse.              ║
║             Action directe / Orientation / Report / Délégation.   ║
║             Appartient toujours au praticien.                     ║
║                              ↓                                    ║
║  Phase 6    ACTION                                                ║
║             ──────────────────────────────────────────────────   ║
║             Exécution de la décision.                             ║
║             Monitoring de la réponse patient.                     ║
║             Peut déclencher un retour à Assessment ou Reasoning.  ║
║                              ↓                                    ║
║  Phase 7    DOCUMENTATION & TRANSMISSION                          ║
║             ──────────────────────────────────────────────────   ║
║             Enregistrement de l'épisode.                          ║
║             Transmission au réseau de soin.                       ║
║             Fermeture du CCE → Input du prochain CCE.             ║
║                                                                   ║
╚═══════════════════════════════════════════════════════════════════╝

Le CCE est un cycle fermé. La Phase 7 produit le contexte que
la Phase 2 du prochain CCE utilisera pour ce même patient.
```

---

---

# IV. Description formelle de chaque phase

## Phase 1 — Situation Intake

**Définition :**
Le praticien oriente son attention vers ce patient, à ce moment. Il réceptionne les signaux initiaux disponibles : état apparent du patient, environnement immédiat, données et alertes du contexte, informations entrantes. C'est le déclencheur du CCE — le moment où le praticien passe de l'état "entre deux patients" à l'état "engagé avec ce patient".

**Entrée :**
- État du praticien avant l'engagement (charge cognitive résiduelle, disponibilité attentionnelle)
- Signaux du patient (apparence, comportement, appel, urgence signalée)
- Alertes et informations entrantes disponibles (résultats, messages, prescriptions)

**Sortie :**
- Orientation attentionnelle : ce patient, maintenant
- Première image de la situation (provisoire, incomplète)
- Signal d'entrée en Phase 2

**Objectif cognitif :**
Initialiser l'épisode. Sélectionner les signaux pertinents parmi le bruit environnemental. Mettre en route la reconstruction du contexte.

**Corpus :**
> *"Je regarde d'abord mon téléphone pour voir si j'ai eu des appels ou des SMS à gérer."* — F-009
> *"Je vérifie ce qui était planifié et si des imprévus sont apparus."* — F-009
> *"Je me souviens automatiquement dès que je le vois."* — F-001

**Biais et risques :**

*Saturation attentionnelle.* Si la charge cognitive résiduelle est élevée (fin de journée, nombreux patients en parallèle), la sélection des signaux pertinents se dégrade. Des alertes importantes peuvent être manquées.

*Interruption pré-engagement.* Le praticien peut être interrompu avant de compléter l'orientation. Il engage le CCE avec une image initiale incomplète.

*Réactivité aux signaux saillants.* Les signaux émotionnellement chargés (patient angoissé, urgence visible) captent l'attention au détriment de signaux cliniquement plus importants mais moins saillants.

**Relation aux invariants CCF-01 :**
- CI-03 (Charge cognitive) — la qualité du Situation Intake dépend directement de la charge résiduelle
- CI-04 (Cognition distribuée) — les informations entrantes (alertes, appels) sont des signaux du réseau, pas du patient seul

**Critères de falsification :**
Un CCE sans Phase 1 identifiable (le praticien engage le raisonnement clinique sans orienter son attention) réfuterait cette phase. Aucun exemple de ce type dans le corpus actuel.

---

## Phase 2 — Situation Assessment

**Définition :**
Le praticien construit une représentation mentale exploitable de la situation du patient. Il mobilise trois sources de façon simultanée et non linéaire : sa mémoire (si le patient est connu), les artefacts disponibles (notes, dossier, ordonnances, résultats), les contributions d'autres praticiens (transmissions, comptes rendus). Le résultat — le Working Mental Model — est la représentation compressée, rôle-spécifique, suffisante pour initier le raisonnement.

**Deux modes selon le contexte :**

*Mode delta (patient connu) :* La question organisatrice est "qu'est-ce qui a changé depuis la dernière rencontre ?" La reconstruction est partielle — elle met à jour le modèle existant, elle ne le reconstruit pas de zéro. Plus rapide, plus exposée aux biais de persistance.

*Mode état (patient nouveau ou reprise après longue interruption) :* La question organisatrice est "qui est ce patient, quelle est sa situation ?" La reconstruction est complète. Plus longue, plus coûteuse cognitivement.

**Entrée :**
- Première image de la situation (Phase 1)
- Mémoire à long terme (pour patients connus)
- Artefacts disponibles (notes de la dernière séance, dossier, ordonnances)
- Contributions de l'équipe de soin (transmissions, comptes rendus)

**Sortie :**
- Working Mental Model : représentation compressée et exploitable du patient
- Signal d'entrée en Phase 3

**Objectif cognitif :**
Atteindre une représentation de la situation suffisamment précise pour raisonner — sans surcharger la mémoire de travail. Ni trop peu (raisonnement sur information insuffisante), ni trop (saturation cognitive).

**Corpus :**
> *"Avant d'entrer, je relis rapidement mes notes."* — F-002, F-008
> *"En 30 secondes je dois savoir où j'en suis avec ce patient."* — F-003
> *"Je cherche la dernière séance. En quelques lignes, je sais où j'en suis."* — F-002
> *"Je regarde son identité, sa pathologie principale, son traitement."* — F-009
> *"Je me souviens de tout. Je n'ai pas besoin de relire."* — F-001

**Sub-phénomène : le limbo d'intégration**

Lors du Situation Assessment, les informations disponibles ne sont pas toutes intégrées au Working Mental Model. Certaines sont perçues mais non traitées — elles entrent dans un état limbo :

```
Information disponible → [LIMBO] → Intégrée dans le Working Mental Model
```

Ce limbo est documenté dans le corpus (F-007, F-009). Il constitue un risque clinique : une information disponible mais non intégrée ne participe pas au raisonnement.

**Biais et risques :**

*Mode error.* Le praticien applique le Mode delta à un patient dont la situation a fondamentalement changé (hospitalisation, complication). Il met à jour un modèle incorrect plutôt que de le reconstruire. C'est l'un des risques les plus documentés dans le corpus.

*Representativeness bias.* Le praticien construit son modèle mental en sélectionnant inconsciemment les informations qui correspondent à son schéma habituel pour ce type de patient. Les informations discordantes sont sous-représentées.

*Source bias.* Le praticien accorde plus de poids aux informations de sources familières ou proches (ses propres notes) qu'aux contributions d'autres praticiens dont la légitimité ou le contexte de production est moins connu. Lié à CI-05 — si l'attribution est absente, la calibration est défaillante.

*Limbo d'intégration.* Des informations disponibles ne sont pas intégrées au Working Mental Model par manque de temps ou de capacité attentionnelle. Elles manquent au raisonnement.

**Relation aux invariants CCF-01 :**
- CI-01 (Reconstruction de contexte) — cette phase EST l'invariant CI-01 en action
- CI-02 (Raisonnement delta) — le mode delta opère ici
- CI-03 (Charge cognitive) — le filtrage et la compression sont des opérations de gestion de charge
- CI-04 (Cognition distribuée) — les contributions de l'équipe sont intégrées ici
- CI-05 (Attribution) — la calibration des sources se fait pendant cette phase

**Critères de falsification :**
Des praticiens qui prennent des décisions cliniques pertinentes sans avoir construit de Working Mental Model — ni par mémoire, ni par lecture — réfuteraient cette phase. Non observé dans le corpus.

---

## Phase 3 — Clinical Reasoning

**Définition :**
Le praticien interprète la situation telle qu'elle est représentée dans le Working Mental Model. Il génère des hypothèses explicatives (diagnostic, compréhension de l'évolution, identification du problème clinique) et les évalue. Cette phase produit des options de réponse — pas encore une réponse choisie.

**Deux modes selon l'expertise et la situation :**

*System 1 — Reconnaissance de pattern (Kahneman, 2011 ; Klein, 1993) :* Le Working Mental Model active directement un pattern reconnu depuis l'expérience passée. L'interprétation émerge sans délibération consciente. Rapide, économe en ressources, adapté aux situations familières. Risque : insensibilité aux signaux discordants.

*System 2 — Analyse délibérative :* Exploration systématique des hypothèses, pesée des évidences pour et contre, génération d'hypothèses alternatives. Lent, coûteux en ressources cognitives, adapté aux situations nouvelles ou complexes. Risque : abandon prématuré sous pression temporelle.

**Entrée :**
- Working Mental Model (Phase 2)

**Sortie :**
- Une ou plusieurs hypothèses interprétatives
- Une ou plusieurs options de réponse (non choisies)
- Signal d'entrée en Phase 4 (Projection) ou en Phase 5 (Décision si Pattern S1 direct)

**Objectif cognitif :**
Comprendre la situation actuelle du patient et générer les réponses possibles à cette situation.

**Corpus :**
> *"Je sens où c'est bloqué. Je n'ai pas besoin d'analyser."* — F-001 (S1)
> *"Je suis là depuis quand une anomalie existe. C'est toujours la question."* — F-005 (S2)
> *"Où en est ce patient ? Qu'est-ce qui a changé ?"* — F-004 (S1/S2 mixte)

**Note sur la relation avec Phase 4 :**

Dans les cas S1, les Phases 3 et 4 peuvent sembler fusionnées — la reconnaissance du pattern inclut implicitement une projection (Klein appelle cela le "recognize-act" pattern). Analytiquement, elles restent distinctes : la Phase 3 interprète la situation actuelle, la Phase 4 simule les états futurs. Mais leur résolution temporelle peut être inférieure à la seconde pour les experts.

**Biais et risques :**

*Premature closure (Croskerry, 2002).* Le praticien accepte la première hypothèse plausible sans évaluer les alternatives. La fréquence de ce biais augmente sous pression temporelle et charge cognitive. C'est l'erreur diagnostique la plus documentée en médecine d'urgence.

*Anchoring bias.* La première information reçue exerce une influence disproportionnée sur le raisonnement, même si des informations ultérieures la contredisent.

*Availability bias.* Le praticien surpondère les pathologies ou situations qu'il a récemment rencontrées, indépendamment de leur fréquence réelle dans la population.

*Confirmation bias.* Le praticien cherche activement des informations qui confirment son hypothèse initiale plutôt que des informations qui pourraient l'infirmer.

*Forcing function failure.* Le contexte (temps limité, patient nombreux, sollicitations) force le praticien en S1 pour des situations qui nécessiteraient S2.

**Relation aux invariants CCF-01 :**
- CI-02 (Raisonnement delta) — pour les patients en suivi, le raisonnement est organisé autour du delta
- CI-03 (Charge cognitive) — la pression temporelle force vers S1 même quand S2 serait approprié
- CI-04 (Cognition distribuée) — les contributions de l'équipe (transmissions, observations) sont des inputs du raisonnement

**Critères de falsification :**
Des praticiens qui passent directement de la Situation Assessment à la Décision sans aucune opération intermédiaire d'interprétation — même implicite — réfuteraient cette phase. La reconnaissance de pattern S1 doit être distinguée de l'absence de raisonnement.

---

## Phase 4 — Projection

**Définition :**
Le praticien simule mentalement les états futurs de la situation clinique. Il teste une ou plusieurs options de réponse identifiées en Phase 3 en imaginant leur déroulement : "si je fais X, que se passe-t-il ?" Cette simulation est la base de l'évaluation des options avant la Décision.

La Projection est une opération cognitive distincte du Raisonnement : la Phase 3 interprète l'état actuel, la Phase 4 prédit les états futurs. Endsley (1995) nomme cela SA Level 3 — Projection of Future Status. Klein (1993) l'appelle "mental simulation" dans le RPD.

**Entrée :**
- Options de réponse (Phase 3)
- Modèles cognitifs du praticien sur l'évolution probable des pathologies et des situations

**Sortie :**
- Évaluation des options (attendue / risquée / incertaine / inadaptée)
- Option ou ensemble d'options retenu pour la Décision
- Signal d'entrée en Phase 5

**Objectif cognitif :**
Évaluer les options de réponse par simulation de leurs conséquences avant de s'engager. Réduire l'incertitude de la Décision.

**Variabilité selon l'expertise et la situation :**

Pour les experts en situations familières (S1 en Phase 3), la Projection peut être quasi-instantanée et inconsciente — une vérification rapide que la réponse habituelle "semble" fonctionner. Pour les situations nouvelles ou complexes, la Projection devient délibérative, parfois verbalisée ("si je prescris X, il faudra surveiller Y").

**Corpus :**
> *"J'anticipe les prochaines étapes. Ce qui doit être fait avant la prochaine consultation."* — F-006
> *"Je ne laisse jamais repartir un patient sans solution."* — F-005 (projection du résultat de la décision)
> *"Si je ne le note pas maintenant, cette information sera perdue."* — F-007 (projection de la conséquence d'une non-action)
> *"La charge mentale : si je ne traite pas ça maintenant, que se passe-t-il ?"* — F-009

**Biais et risques :**

*Projection neglect.* Le praticien ne simule pas les états futurs — il passe directement de la Phase 3 à la Décision sans évaluer les conséquences. Fréquent sous pression temporelle ou charge cognitive élevée. Risque : décisions dont les conséquences n'ont pas été anticipées.

*Overconfident projection.* Le praticien projette un état futur avec une certitude excessive. Il sous-estime l'incertitude de l'évolution clinique. Risque : absence de plan B.

*Optimism bias.* La projection simule préférentiellement les scénarios positifs. Les scénarios défavorables sont sous-représentés dans la simulation mentale.

*Tunnel vision.* Le praticien ne projette qu'un seul scénario — celui associé à son hypothèse principale (Phase 3). Les hypothèses alternatives ne sont pas projetées.

**Relation aux invariants CCF-01 :**
- CI-02 (Raisonnement delta) — la Projection est une forme de delta inversé : "quel sera le delta au prochain CCE si je fais X ?"
- CI-03 (Charge cognitive) — la Projection est sacrifiée en premier sous pression cognitive élevée
- CI-05 (Attribution) — la qualité de la simulation dépend de la fiabilité des informations sur lesquelles elle s'appuie

**Critères de falsification :**
Un corpus démontrant systématiquement que les praticiens experts prennent leurs décisions sans aucune forme de simulation mentale (même implicite, même instantanée) réfuterait cette phase. La littérature RPD (Klein, 1993, 1999) fournit l'évidence de son existence même chez les experts en S1.

---

## Phase 5 — Decision

**Définition :**
Le praticien sélectionne une réponse parmi les options évaluées et s'y engage. La Décision est l'acte par lequel le praticien assume la responsabilité d'un cours d'action. Elle appartient toujours au praticien — sans exception dans le corpus.

**Quatre types de décision observés dans le corpus :**

| Type | Description | Corpus |
|---|---|---|
| **Action directe** | Le praticien réalise l'acte clinique | F-001 (manipulation), F-005 (échographie) |
| **Orientation** | Transmission à un autre praticien ou spécialiste | F-005 (résultat anormal → médecin), F-009 (relais collègue) |
| **Report délibéré** | Traiter plus tard, avec mécanisme de rappel | F-009 (rappel explicite), F-007 (fin de journée) |
| **Délégation** | Passer à un autre membre du réseau avec contexte transmis | F-009 (collègue), F-006 (maternité) |

**Entrée :**
- Options évaluées (Phase 4)
- Valeurs du praticien (sécurité patient, relation thérapeutique, protocole)
- Contraintes contextuelles (temps, matériel disponible, protocoles institutionnels)

**Sortie :**
- Décision engagée (explicite ou implicite)
- Signal d'entrée en Phase 6 (Action directe, Orientation, Délégation) ou bouclage en Phase 7 (Report délibéré avec documentation)

**Objectif cognitif :**
Réduire l'incertitude résiduelle à un niveau acceptable et s'engager sur une réponse. Assumer la responsabilité clinique de ce cours d'action.

**Corpus :**
> *"Je ne laisse jamais repartir un patient sans solution."* — F-005
> *"Je passe à une collègue si c'est une urgence."* — F-009
> *"Je me mets un rappel. Je la traiterai plus tard."* — F-009
> *"C'est moi qui décide."* — F-001 (implicite dans la description de l'acte)

**Note sur la fusion expérientielle Décision-Action chez les experts :**

En S1, le praticien expert expérimente souvent Décision et Action comme un seul moment. La reconnaissance du pattern déclenche directement l'action sans délibération consciente. Analytiquement, la Décision existe néanmoins — elle est simplement implicite dans la reconnaissance. Cette fusion est un marqueur d'expertise, pas une absence de Décision.

**Biais et risques :**

*Decision paralysis.* Face à une incertitude trop élevée, le praticien ne parvient pas à s'engager. Il reste en boucle entre Reasoning et Projection. Risque : retard de prise en charge.

*Premature decision.* La Décision est prise avant que le raisonnement soit suffisamment fondé (pression temporelle, fatigue). Risque : décision sur base insuffisante.

*Automation bias.* Le praticien déférer à une recommandation externe (algorithme, collègue plus senior) sans exercer son propre jugement. La Décision est nominalement sienne mais cognitivo-ment déléguée. Risque : perte de responsabilité clinique effective.

*Sunk cost escalation.* Le praticien maintient une décision antérieure même face à des informations nouvelles qui la contredisent, parce que les investissements précédents (temps, ressources, relation thérapeutique) créent une résistance au changement.

**Frontière humain / assistable :**

La Décision est irréductiblement humaine. Aucun système ne peut décider à la place du praticien. La Décision implique la responsabilité, les valeurs, et le jugement contextuel — trois dimensions qui ne peuvent pas être délégables à un système dans le contexte clinique actuel.

Ce qui peut être assisté sans décider : la présentation des options issues de la Projection, la mise en évidence des alternatives non considérées, l'alerte sur les risques connus associés à une option.

**Relation aux invariants CCF-01 :**
- CI-05 (Attribution) — la confiance dans les informations qui ont alimenté le raisonnement influence la confiance dans la Décision
- CI-04 (Cognition distribuée) — la Délégation est une décision clinique qui engage le réseau de soin

**Critères de falsification :**
Des praticiens qui n'assument jamais explicitement ni implicitement une responsabilité de réponse — délégant systématiquement à un algorithme ou un supérieur sans exercer de jugement — réfuteraient que la Décision appartient toujours au praticien.

---

## Phase 6 — Action

**Définition :**
Le praticien exécute la décision prise. L'Action peut être un acte corporel direct (manipulation, injection, examen), communicationnel (appel, transmission, prescription verbale), ou informationnelle (rédaction, routage). Pendant l'Action, le praticien monitore simultanément la réponse du patient — ce monitoring peut déclencher un retour à une phase précédente.

**Entrée :**
- Décision engagée (Phase 5)
- Capacités et compétences du praticien
- Ressources disponibles (matériel, temps, présence du patient)

**Sortie :**
- Acte clinique réalisé
- Signaux de réponse du patient (observations pendant et après l'action)
- Données nouvelles produites par l'action (mesures, résultats, réactions observées)
- Signal d'entrée en Phase 7 ou, si la réponse est inattendue, retour en Phase 2 (Situation Assessment)

**Objectif cognitif :**
Exécuter la décision avec précision et monitorer en temps réel la réponse pour détecter les déviations par rapport à la projection.

**Corpus :**
> *"Je sens sous mes mains ce qui se passe. J'ajuste en temps réel."* — F-001
> *"J'observe énormément pendant la séance."* — F-009
> *"Je récupère les données de la pompe pendant la visite."* — F-009
> *"Je ne peux pas écrire devant le patient. Je préfère lui consacrer tout mon temps."* — F-004, F-006

**Le monitoring comme feedback loop :**

Pendant l'Action, le praticien ne cesse pas d'évaluer la situation. Si la réponse du patient diverge significativement de la Projection, le CCE peut revenir à une phase antérieure :

- Réponse légèrement inattendue → retour en Phase 3 (ajuster le raisonnement)
- Réponse radicalement inattendue → retour en Phase 2 (reconstruire le modèle)
- Urgence découverte pendant l'action → interruption du CCE et déclenchement d'un nouveau CCE prioritaire (F-009)

**Biais et risques :**

*Execution error.* L'Action n'est pas conforme à la Décision — erreur de dosage, acte sur le mauvais patient, procédure incorrecte. Ce type d'erreur est souvent dû à la charge cognitive élevée ou à l'interruption pendant l'Action.

*Monitoring failure.* Le praticien exécute l'action sans observer les signaux de réponse du patient. La boucle de feedback est absente ou dégradée. Risque : les déviations par rapport à la projection ne sont pas détectées.

*Interruption pendant l'action.* Un signal externe (appel, urgence, demande collègue) interrompt l'Action. Le CCE en cours est suspendu. Le praticien doit gérer la reprise — risque de context loss.

*Présence/documentation tension.* Le praticien choisit de documenter pendant l'Action (risque : qualité relationnelle dégradée) ou ne documente pas (risque : limbo d'intégration). Cette tension est documentée dans 8/9 profils du corpus.

**Frontière humain / assistable :**

L'Action clinique elle-même — l'acte, le geste, la relation thérapeutique — est irréductiblement humaine dans le contexte actuel. Ce qui peut être assisté sans remplacer : des protocoles de référence accessibles pendant l'action pour les situations inhabituelles, des alertes si des paramètres critiques dévient pendant l'action.

**Relation aux invariants CCF-01 :**
- CI-03 (Charge cognitive) — l'Action sous charge élevée augmente le risque d'erreur d'exécution
- CI-04 (Cognition distribuée) — certaines Actions sont des actes de coordination (appels, transmissions) — elles alimentent directement le réseau

**Critères de falsification :**
Des Actions cliniques efficaces sans aucun monitoring de la réponse patient réfuteraient la composante monitoring de cette phase.

---

## Phase 7 — Documentation & Transmission

**Définition :**
Le praticien enregistre l'épisode clinique — ce qui a été observé, évalué, décidé, fait — et transmet les informations pertinentes aux autres acteurs du réseau de soin. Cette phase est la fermeture du CCE et simultanément la production de l'input du prochain CCE.

**Double rôle de la Documentation :**

*Rôle de clôture :* enregistrer ce qui s'est passé dans ce CCE pour que le praticien lui-même puisse le retrouver lors du prochain CCE avec ce patient.

*Rôle de transmission :* rendre disponibles dans le réseau de soin les informations produites par ce CCE, pour que les autres praticiens puissent les intégrer dans leurs propres CCE avec ce patient (CI-04).

> *"La note post-consultation, c'est la production du prochain Anchor."* — F-004

**Trois types de documentation observés dans le corpus :**

*Documentation immédiate (pendant l'Action) :* rare, et coûteuse pour la relation thérapeutique. Observée principalement pour les données objectives (mesures, données pompe — F-009).

*Documentation différée (après l'Action, pendant le CCE) :* la plus fréquente. Rédigée juste après la rencontre, le contexte encore frais. F-002, F-003, F-008.

*Documentation partitionnée (hors CCE, créneau dédié) :* la documentation se fait dans un créneau cognitif séparé — fin de tournée, fin de journée. F-004, F-006, F-007, F-009. Risque de limbo : les détails s'estompent entre l'Action et le créneau de documentation.

**Entrée :**
- Résultats de l'Action
- Décision prise
- Observations faites pendant le CCE
- Contexte cognitif résiduel (mémoire de travail encore active)

**Sortie :**
- Document clinique (note, compte rendu, ordonnance, transmission)
- Contexte disponible pour le prochain CCE (même praticien)
- Contributions distribuées au réseau de soin (autres praticiens)

**Objectif cognitif :**
Externaliser les informations clés de ce CCE dans un format persistant et transmissible. Fermer la boucle cognitive de l'épisode. Nourrir le réseau de soin distribué.

**Corpus :**
> *"Tant que je n'ai pas eu le temps de l'inscrire, elle n'en fait pas vraiment partie."* — F-007
> *"Je mets tout dans le logiciel après. Pendant, je suis avec le patient."* — F-002, F-008
> *"J'ai davantage le sentiment de terminer ma semaine que ma journée."* — F-009

**Biais et risques :**

*Documentation failure.* L'épisode n'est pas documenté — par manque de temps, par fatigue, par priorité accordée à d'autres CCE. Les informations produites par cet épisode disparaissent. Le prochain CCE devra reconstruire sans elles.

*Incomplete documentation.* La documentation capture les décisions mais pas le raisonnement. Le prochain praticien dispose des conclusions sans les hypothèses — risque d'anchoring bias sur des conclusions non justifiées.

*Documentation lag.* Le créneau de documentation est trop éloigné dans le temps de l'Action. Les détails s'estompent. La note capture une version appauvrie de ce qui s'est réellement passé.

*Transmission failure.* La documentation existe mais ne parvient pas aux bons acteurs du réseau au bon moment. Le compte rendu est rédigé mais non transmis. La contribution au réseau distribué est nulle.

*Limbo de documentation.* Des informations sont connues du praticien mais non encore documentées. Elles sont dans le limbo entre le CCE qui les a produites et le système d'information. Si le praticien est interrompu avant de documenter, elles sont perdues.

**Frontière humain / assistable :**

La documentation est le point où l'assistance est la plus légitime et la moins risquée :
- L'identification de ce qui n'est pas encore documenté (limbo)
- Le routage de la documentation vers les bons destinataires
- La structuration de la note selon un format standard
- Le rappel de documenter si trop de temps s'est écoulé

Ce qui ne peut pas être délégué : le contenu clinique lui-même — ce que le praticien a observé, pensé, décidé.

**Relation aux invariants CCF-01 :**
- CI-01 (Reconstruction de contexte) — cette phase PRODUIT le matériau que CI-01 utilisera dans le prochain CCE
- CI-04 (Cognition distribuée) — la Transmission est l'acte qui rend la cognition individuelle disponible au réseau
- CI-03 (Charge cognitive) — la documentation différée est une stratégie de partitionnement temporel (CI-03)

**Critères de falsification :**
Des praticiens produisant systématiquement des actes cliniques de qualité sans aucune documentation, sans dégradation du soin au fil du temps, réfuteraient le rôle de la Phase 7 comme input du prochain CCE.

---

---

# V. Propriétés transversales du CCE

Ces propriétés s'appliquent au modèle dans son ensemble — elles ne sont pas localisées dans une phase.

## 5.1 Le CCE est un cycle fermé

La Phase 7 (Documentation) produit l'input de la Phase 2 (Situation Assessment) du prochain CCE pour ce même patient. Ce n'est pas une métaphore — c'est structurel : les notes lues lors du prochain CCE sont exactement les notes écrites lors du CCE actuel.

Conséquence clinique : la qualité de la Phase 7 détermine la qualité de la Phase 2 du prochain CCE. Une documentation incomplète dégrade mécaniquement la reconstruction de contexte future.

Conséquence pour le réseau : via CI-04, la Phase 7 alimente aussi les CCE des autres praticiens du réseau. Une documentation de qualité est un bien commun clinique.

## 5.2 Le CCE peut être interrompu à toute phase

Une interruption externe (appel téléphonique, urgence, demande d'un collègue) peut survenir entre toute paire de phases. L'impact de l'interruption varie selon la phase :

- Interruption pendant Phase 2 : le Working Mental Model est incomplet → raisonnement dégradé
- Interruption pendant Phase 3 : la chaîne d'hypothèses est coupée → risque de perte du fil
- Interruption pendant Phase 6 : l'acte peut être mal exécuté ou le monitoring incomplet
- Interruption pendant Phase 7 : documentation incomplète ou reportée → risque de limbo

Pour les profils de coordination (F-009), les interruptions ne sont pas des perturbations du CCE — elles initient de nouveaux CCE en parallèle. Le modèle doit être capable de représenter N CCE simultanés.

## 5.3 Le CCE peut déclencher un retour en arrière

Le monitoring pendant la Phase 6 (Action) peut révéler une déviation par rapport à la Projection (Phase 4). Ce signal peut déclencher un retour à la Phase 3 (ajustement du raisonnement) ou à la Phase 2 (reconstruction du modèle si la déviation est majeure).

Ces boucles de retour ne sont pas des défaillances — elles font partie du processus clinique normal, particulièrement pour les situations complexes ou inattendues.

## 5.4 La durée des phases varie selon l'expertise

Pour un praticien expert dans une situation familière :
- Phases 1-2 : quelques secondes (reconnaissance quasi-instantanée)
- Phase 3 : fraction de seconde (pattern recognition S1)
- Phase 4 : implicite, quasi-instantanée
- Phase 5 : fusionnée avec Phase 3-4
- Phase 6 : durée de l'acte clinique
- Phase 7 : variable (immédiate à différée)

Pour un praticien moins expérimenté ou en situation nouvelle :
- Phases 1-2 : minutes (lecture attentive)
- Phase 3 : minutes (analyse délibérative)
- Phase 4 : explicite, verbalizable
- Phase 5 : distincte, avec délibération consciente
- Phase 6 : plus longue, plus supervisée
- Phase 7 : plus complète (le novice documente plus)

## 5.5 Le CCE peut se déployer en mode N parallèle

Pour les profils de coordination inter-professionnelle (F-009), plusieurs CCE s'exécutent en parallèle sur des patients différents. Le praticien gère simultanément :
- N CCE en Phase 2 (informations en attente d'intégration)
- N CCE en Phase 5 (décisions reportées ou déléguées)
- N CCE en Phase 7 (documentations en attente)

Ce mode parallèle est la source de la charge cognitive multiplicative documentée dans F-009.

---

---

# VI. Ruptures cognitives — cartographie

Une rupture cognitive est un moment du CCE où le processus cognitif est interrompu, dégradé, ou biaised de façon à compromettre la qualité clinique de l'épisode.

| Phase | Rupture | Mécanisme | Conséquence clinique |
|---|---|---|---|
| **P1 — Intake** | Saturation attentionnelle | Charge résiduelle élevée | Signaux importants non perçus |
| **P1 �� Intake** | Saillance bias | Signal émotionnel capte l'attention | Signal clinique important ignoré |
| **P2 — Assessment** | Mode error | Delta mode sur situation changée | Modèle mental incorrect |
| **P2 — Assessment** | Limbo d'intégration | Informations disponibles non intégrées | Raisonnement sur base incomplète |
| **P2 — Assessment** | Source bias | Sous-pondération contributions équipe | Raisonnement individualisé, non distribué |
| **P3 — Reasoning** | Premature closure | Première hypothèse acceptée | Diagnostic ou compréhension incorrect |
| **P3 — Reasoning** | Anchoring bias | Surpondération information initiale | Hypothèses alternatives ignorées |
| **P3 — Reasoning** | S1 forcé | Pression temporelle | Situations complexes traitées sans analyse |
| **P4 — Projection** | Projection neglect | Passage direct P3→P5 | Conséquences non anticipées |
| **P4 — Projection** | Tunnel vision | Un seul scénario simulé | Absence de plan B |
| **P5 — Decision** | Automation bias | Déférence à une recommandation externe | Perte de responsabilité clinique |
| **P5 — Decision** | Decision paralysis | Incertitude non réductible | Retard de prise en charge |
| **P6 — Action** | Monitoring failure | Absence de feedback loop | Déviations non détectées |
| **P6 — Action** | Exécution error | Charge cognitive élevée pendant l'acte | Acte non conforme à la décision |
| **P7 — Documentation** | Documentation failure | Priorité sur d'autres CCE | Informations perdues du cycle |
| **P7 — Documentation** | Documentation lag | Créneau trop tardif | Note appauvrie par estompage mémoriel |
| **P7 — Documentation** | Transmission failure | Document non routé | Réseau non alimenté |

---

---

# VII. Mécanismes compensatoires observés dans le corpus

Les praticiens développent des mécanismes actifs pour prévenir ou corriger les ruptures cognitives. Ces mécanismes sont des adaptations observées dans la pratique réelle — non des prescriptions théoriques.

| Mécanisme | Phase cible | Description | Corpus |
|---|---|---|---|
| **Externalisation préventive** | P2, P7 | Notes, templates, rappels pour étendre la mémoire de travail | F-002, F-004, F-008, F-009 |
| **Partitionnement temporel** | P7 | Créneau cognitif dédié à la documentation hors CCE | F-004, F-006, F-007, F-009 |
| **Relecture systématique** | P2 | Lire les notes AVANT la rencontre, même si le patient est connu | F-002, F-003, F-008 |
| **Vérification sociale** | P3, P5 | Appeler un collègue ou spécialiste quand l'hypothèse est incertaine | F-005, F-009 |
| **Délégation explicite** | P5 | Passer la décision ou l'action à un pair avec transmission du contexte | F-009 |
| **Rituel de clôture** | P7 | Vérifier systématiquement la complétude avant de fermer le CCE | F-007 (3 conditions) |
| **Rappel différé** | P5, P7 | Mécanisme de report explicite pour les informations non traitables maintenant | F-009 |
| **Abstention documentée** | P6 | Ne pas écrire PENDANT la rencontre pour préserver la relation — documenter après | F-004, F-006 |
| **File de triage** | P1, P2 | Trier les informations entrantes avant d'initier les CCE du jour | F-009 |

---

---

# VIII. Frontière humain / assistable

Cette section identifie, phase par phase, ce qui appartient irréductiblement au raisonnement humain et ce qui peut être légitimement assisté par un système externe.

**Principe général :**
L'assistance est légitime lorsqu'elle accélère ou facilite une opération cognitive sans se substituer au jugement. Elle est illégitime lorsqu'elle prend en charge une opération qui nécessite la responsabilité ou les valeurs du praticien.

| Phase | Irréductiblement humain | Assistable sans remplacer |
|---|---|---|
| **P1 — Intake** | L'orientation attentionnelle et la décision de traiter maintenant | Surfacer les alertes et signaux pertinents pour ce patient à ce moment |
| **P2 — Assessment** | Le jugement sur le poids de chaque information | Récupérer et présenter le contexte pertinent ; identifier le delta ; attribuer les sources |
| **P3 — Reasoning** | La génération et l'évaluation d'hypothèses cliniques | Signaler des valeurs statistiquement anormales ; présenter des cas comparables |
| **P4 — Projection** | La simulation des états futurs et leur évaluation | Présenter l'historique des évolutions similaires ; signaler des risques connus |
| **P5 — Decision** | Le choix final et l'engagement de responsabilité | Présenter les options ; signaler les alternatives non envisagées ; alerter sur les risques connus |
| **P6 — Action** | L'acte clinique lui-même et la relation thérapeutique | Protocoles de référence accessibles ; alertes si paramètres critiques dévient |
| **P7 — Documentation** | Le contenu clinique (ce qui a été observé, pensé, décidé) | Structure de la note ; routage vers les destinataires ; alerte si documentation manquante |

**Ligne rouge :** Un système ne doit jamais se substituer à la Phase 5 (Decision). Toute recommandation présentée comme une décision — plutôt que comme une option — franchit cette ligne.

---

---

# IX. Correspondance avec les invariants de CCF-01

| Invariant CCF-01 | Phases du CCE concernées | Nature de la relation |
|---|---|---|
| **CI-01** Reconstruction de contexte | Phase 2 | La Phase 2 IS l'invariant CI-01 en action |
| **CI-02** Raisonnement delta | Phase 2 (mode delta) + Phase 4 | CI-02 gouverne le mode de la Phase 2 et oriente la Projection |
| **CI-03** Limitation cognitive | Toutes phases | CI-03 contraint chaque phase — P3 et P4 sont les premières sacrifiées |
| **CI-04** Cognition distribuée | Phase 2 (sources équipe) + Phase 7 (transmission) | CI-04 est l'invariant qui relie les CCE des différents praticiens |
| **CI-05** Attribution | Phase 2 (calibration des sources) + Phase 5 (confiance dans la décision) | CI-05 gouverne la pondération des informations intégrées dans le Working Mental Model |

**Observations complémentaires :**

Le limbo informationnel (CC-000 H-08) apparaît à deux points du CCE :
- En Phase 2 : informations disponibles non intégrées au Working Mental Model
- En Phase 7 : informations produites par le CCE non encore documentées

Le modèle du CCE confirme que le limbo est structurel — il émerge des contraintes de la Phase 2 (capacité de traitement limitée) et de la Phase 7 (temporalité de la documentation).

---

---

# X. Corpus — Traçabilité par phase

Pour chaque phase, les profils du corpus qui ont fourni l'évidence empirique principale.

| Phase | Profils confirmant | Profils challengers | Qualité de l'évidence |
|---|---|---|---|
| P1 — Situation Intake | F-009, F-003, F-001 | — | ★★★ (indirecte — observée via la description du début de journée) |
| P2 — Situation Assessment | F-001, F-002, F-003, F-007, F-008, F-009 | F-001 (mode mémoire-first — artefacts non nécessaires) | ★★★★★ (9/9 confirmé) |
| P3 — Clinical Reasoning | F-001 (S1), F-004, F-005 (S2), F-009 | — | ★★★★ (tous profils — mais mode difficile à observer directement) |
| P4 — Projection | F-004, F-006, F-009 | F-001 (minimal) | ★★★ (3/9 explicite) |
| P5 — Decision | F-005, F-009 | — | ★★★★ (implicite dans tous — explicite dans F-005, F-009) |
| P6 — Action | F-001, F-007 (monitoring) | — | ★★★★ |
| P7 — Documentation | F-002, F-004, F-007, F-008, F-009 | F-001 (minimal) | ★★★★★ (9/9 — même F-001 a une forme de documentation) |

**Phase la moins bien documentée :** Phase 4 (Projection). La simulation mentale est difficile à observer par entretien — elle se déroule implicitement. L'évidence la plus solide vient de la littérature (Klein, Endsley), corroborée par 3 profils du corpus. **Cette phase est la plus vulnérable à une réfutation partielle** par des observations futures.

---

---

# XI. Limites du modèle et extensions prévues

## Ce que ce modèle ne couvre pas

**Le CCE en contexte d'urgence pure.** Dans un CCE d'urgence (médecin urgentiste, situation critique soudaine), les Phases 1 à 5 peuvent se dérouler en quelques secondes sous pression extrême. Les biais de la Phase 3 (premature closure) sont alors maximisés. Ce modèle décrit le cas nominal — l'urgence est une déviation du cas nominal, avec ses propres propriétés.

**Le CCE en équipe simultanée.** Un staff pluridisciplinaire autour d'un patient est un CCE collectif — plusieurs praticiens en Phases 2 à 5 simultanément, interagissant. Ce modèle décrit le CCE individuel. Le CCE collectif nécessiterait une extension distincte.

**Le CCE du patient.** Le patient lui-même traverse un processus cognitif pendant la rencontre — compréhension de l'information, évaluation des options, décision thérapeutique partagée. Ce CCE patient n'est pas modélisé ici.

**La durée absolue des phases.** Ce modèle est qualitatif — il décrit la structure et l'ordre des phases, pas leur durée absolue. Des études observationnelles directes (eye-tracking, think-aloud protocols) seraient nécessaires pour quantifier les durées.

## Extensions prévues

| Extension | Déclencheur | Impact sur le modèle |
|---|---|---|
| CCE hospitalier / urgence | Corpus hospitalier (à constituer) | Phases 3-5 potentiellement fusionnées sous contrainte temporelle |
| CCE coordinateur (multi-parallèle) | Extension de F-009 | Modélisation du CCE N-parallèle avec file de priorité |
| CCE collectif (staff) | Corpus équipe | Extension de Phase 2 et 7 en mode collectif |
| Quantification des durées | Études observationnelles directes | Ajout de paramètres temporels à chaque phase |

---

---

# Synthèse

> Le Clinical Cognitive Episode est la séquence fondamentale de tout travail clinique.
>
> Il commence quand un praticien oriente son attention vers un patient.
> Il se termine quand l'épisode est documenté et transmis.
> Il se recommence lors de la prochaine rencontre — nourri par la documentation du précédent.
>
> Sept phases stables, observables dans toutes les professions du corpus :
> Situation Intake → Situation Assessment → Clinical Reasoning → Projection
> → Decision → Action → Documentation & Transmission
>
> La Phase 2 est la plus universelle et la plus critique : c'est là que le praticien
> construit ou reconstruit sa représentation du patient. C'est là que le système
> peut apporter le plus de valeur — sans jamais franchir la ligne de la Décision.
>
> La Phase 5 est irréductiblement humaine.
> La Phase 7 est la moins bien valorisée — et pourtant la plus structurante pour le futur.

---

## Références

| Auteur | Œuvre | Lien avec CCF-02 |
|---|---|---|
| Endsley, M. (1988, 1995) | *Toward a Theory of Situation Awareness in Dynamic Systems* | Modèle SA : Phases 1-4 — Perception/Comprehension/Projection |
| Klein, G. (1993) | *A Recognition-Primed Decision Model* | Phase 3-4 : Pattern recognition + Mental simulation |
| Klein, G. (1999) | *Sources of Power* | Phase 3 : Naturalistic Decision Making — S1 vs S2 en conditions réelles |
| Kahneman, D. (2011) | *Thinking, Fast and Slow* | Phase 3 : System 1 / System 2 |
| Croskerry, P. (2002) | *Achieving Quality in Clinical Decision Making* | Phase 3 : Premature closure · Anchoring · Availability bias |
| Croskerry, P. (2009) | *A Universal Model of Diagnostic Reasoning* | Phase 3-5 : Modèle dual process en clinique |
| Tulving, E. (1972) | *Episodic and Semantic Memory* | Terminologie : episode — unité cognitive délimitée |
| Zacks, J.M. et al. (2007) | *Event Perception: A Mind/Brain Perspective* | Segmentation cognitive des événements — fondement de l'Episode |
| Crandall, B., Klein, G., Hoffman, R. (2006) | *Working Minds* | Cognitive Task Analysis — méthode d'identification des phases |
| Sweller, J. (1988) | *Cognitive Load Theory* | Phase 2-3 : Types de charge — rapport à la mémoire de travail |
| Hutchins, E. (1995) | *Cognition in the Wild* | Phase 7 : Documentation comme artefact distribué du réseau |
| Norman, G. (2005) | *Research in clinical reasoning: past history and current trends* | Phase 3 : Clinical reasoning — évolution des modèles |
| Higgs, J., Jones, M. (2000) | *Clinical Reasoning in the Health Professions* | Phase 3-5 : Cadre global du raisonnement clinique |

---

*Ce document est vivant. Il est mis à jour à chaque extension du corpus, invalidation d'une phase, ou apport de la littérature.*
*Version 1.0 — Corpus F-001 → F-009 — Contexte libéral ambulatoire — 2026-07-30*
