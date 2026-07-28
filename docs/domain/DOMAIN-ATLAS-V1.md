# Domain Atlas — V1

**Version :** 1.0
**Statut :** Vérité métier du projet — Document vivant
**Fondé sur :** M-000, M-001, M-002, M-003, P-001, CW-001
**Date :** 2026-07-28

---

## Préambule

Le Domain Atlas est la traduction directe des documents fondateurs en concepts métier utilisables.

Chaque concept de ce document est **déduit**, non inventé. Sa justification cite explicitement le document fondateur qui l'impose. Toute décision d'implémentation qui requiert un concept absent de cet Atlas doit d'abord démontrer son fondement dans les documents de Niveau 1, 2 ou 3 de la chaîne intellectuelle (voir R-000).

**Ce que ce document est :**
- La vérité métier du projet
- La source de vérité pour le nommage des concepts dans le code
- Le pont entre la théorie (M-003) et l'architecture (ADRs)

**Ce que ce document n'est pas :**
- Un modèle de données
- Un schéma de base de données
- Une spécification d'API
- Un document d'architecture

---

## Index des concepts

| # | Concept | Catégorie | Section |
|---|---|---|---|
| 01 | Patient | Acteur | §1 |
| 02 | Professionnel de Santé | Acteur | §2 |
| 03 | Compréhension Clinique | Actif central | §3 |
| 04 | Contribution Clinique | Unité fondamentale | §4 |
| 05 | Situation Clinique | Dimension de la Compréhension | §5 |
| 06 | Raisonnement Clinique | Dimension de la Compréhension | §6 |
| 07 | Hypothèse Clinique | Dimension de la Compréhension | §7 |
| 08 | Incertitude Clinique | Dimension de la Compréhension | §8 |
| 09 | Intention Clinique | Dimension de la Compréhension | §9 |
| 10 | Parcours de Soins | Continuité | §10 |
| 11 | Transition | Événement structurel | §11 |
| 12 | Reprise de Contexte | Processus cognitif | §12 |
| 13 | Modèle de Situation | État cognitif intermédiaire | §13 |
| 14 | Lacune | Manifestation de l'incomplétude | §14 |
| 15 | Perspective | Propriété perspectivale | §15 |

---

## Groupe I — Acteurs

Les acteurs sont les entités humaines qui participent au domaine. Il n'en existe que deux dans le Core Domain : le Patient et le Professionnel de Santé. Leur asymétrie structurelle est le fondement du problème que le domaine résout.

---

### §1 — Patient

#### Définition

Le Patient est l'entité humaine dont la situation clinique est l'objet de la Compréhension Clinique. Il est la seule entité **continue** du domaine : son parcours clinique s'accumule sans interruption de la naissance à la mort.

La continuité du Patient est la propriété qui distingue le domaine de MedLink de tous les systèmes orientés vers les actes ou les épisodes. Un patient n'est pas un épisode de soins. Il est une entité dont l'histoire est permanente.

#### Pourquoi il existe

La continuité du Patient est le fondement de l'asymétrie structurelle qui justifie l'existence du domaine.

Le Patient est continu. Les Professionnels qui le soignent sont transitoires. Cette asymétrie n'est pas un défaut du système de santé — c'est sa propriété constitutive. Elle crée mécaniquement le besoin de préserver et transmettre la compréhension entre Professionnels successifs.

Sans continuité du Patient, il n'y aurait pas de problème de reprise de contexte. Le Patient est donc la raison d'être première du domaine.

#### Responsabilités

Le Patient n'a pas de responsabilités dans le domaine au sens actif du terme. Il est l'**objet** de la Compréhension Clinique, pas son sujet. Il est le bénéficiaire final de la continuité que le domaine cherche à assurer.

#### Relations

- A exactement un Parcours de Soins (`1:1` — composition)
- Est l'objet de Contributions Cliniques produites par des Professionnels (`1:N`)
- A une Compréhension Clinique qui lui est propre, constituée de ses Contributions (`1:1`)
- Traverse des Transitions entre Professionnels

#### Invariants

**I.P-01** — Un Patient est toujours continu. Son histoire clinique ne s'interrompt pas entre deux contacts professionnels.

**I.P-02** — La Compréhension Clinique d'un Patient n'est jamais définitivement complète. Elle est toujours partielle et enrichissable.

**I.P-03** — Un Patient a un seul Parcours de Soins. Plusieurs systèmes peuvent en enregistrer des fragments, mais il n'existe qu'une seule trajectoire clinique.

#### Exemples

Tout individu pris en charge par un Professionnel de Santé, quelle que soit la spécialité, l'établissement, ou le stade de la prise en charge.

#### Ce qu'il n'est pas

Le Patient n'est pas un dossier médical. Il n'est pas une liste de données. Il n'est pas un "utilisateur" au sens applicatif. Il n'est pas interchangeable avec ses représentations numériques dans des systèmes tiers.

#### Justification

- `P-001 §2.1` — Continuité du patient : "La situation clinique d'un patient évolue sans interruption dans le temps."
- `M-000 Invariant I` — "Le patient est continu ; les professionnels sont transitoires."
- `M-003 §12.2 Prémisse 1` — "Le patient est une entité continue."

---

### §2 — Professionnel de Santé

#### Définition

Le Professionnel de Santé est l'acteur humain qui produit de la Compréhension Clinique. Il intervient de façon **intermittente** dans le Parcours de Soins d'un Patient. Il est l'auteur de toute Contribution Clinique.

Sa transitorité — le fait qu'il ne soit jamais en contact continu avec un Patient — est la source structurelle du problème de la reprise de contexte.

#### Pourquoi il existe

La Compréhension Clinique est toujours produite par un sujet. Elle n'existe pas indépendamment d'un auteur. Le Professionnel de Santé est ce sujet. Sans lui, il n'y a pas de compréhension — seulement des données.

Son caractère transitoire est également nécessaire au domaine : si un seul et même Professionnel suivait chaque Patient en continu et indéfiniment, il n'y aurait pas de problème de transmission. C'est précisément parce que les Professionnels se succèdent que le domaine existe.

#### Responsabilités

- Produire des Contributions Cliniques lors de chaque prise en charge significative
- Porter la responsabilité clinique de ses contributions — elles lui appartiennent et ne peuvent pas être réattribuées
- Former sa propre Compréhension lors de chaque Reprise de Contexte

#### Relations

- Est l'auteur de Contributions Cliniques (`1:N`)
- Intervient dans le cadre de Transitions (entrant ou sortant)
- Effectue des Reprises de Contexte au début de chaque prise en charge d'un Patient qu'il n'a pas suivi récemment
- Porte une Perspective qui colore ses Contributions

#### Invariants

**I.PS-01** — Toute Contribution Clinique a exactement un auteur identifié.

**I.PS-02** — Le Professionnel de Santé ne peut pas transférer sa responsabilité clinique à un système. Il est l'auteur de ce qu'il comprend et de ce qu'il décide.

**I.PS-03** — La Compréhension Clinique d'un Professionnel est toujours perspectivale : elle est formée depuis son point de vue, avec son expertise, dans son contexte.

**I.PS-04** — La spécialité médicale du Professionnel n'est pas un concept du Core Domain. Elle appartient à des domaines spécialisés. Le Core Domain traite tous les Professionnels comme des acteurs équivalents en termes de leur capacité à contribuer à la compréhension d'un Patient.

#### Exemples

Médecin généraliste, spécialiste (cardiologue, néphrologue, psychiatre), infirmier, kinésithérapeute, sage-femme, pharmacien clinicien, psychologue.

#### Ce qu'il n'est pas

Le Professionnel de Santé n'est pas "l'utilisateur" au sens applicatif — cette confusion réduit le concept à sa dimension d'interaction avec une interface. Il n'est pas défini par sa spécialité dans le Core Domain. Il n'est pas le seul bén��ficiaire du domaine : le Patient en est le bénéficiaire final.

#### Justification

- `P-001 §2.2` — Discontinuité des professionnels.
- `M-003 Invariant I` — "La Compréhension Clinique est toujours située" — implique un sujet.
- `M-003 Invariant II` — "La Compréhension Clinique est toujours partielle."
- `M-000 Invariant III` — "Une contribution clinique appartient toujours à son auteur et à son contexte."

---

## Groupe II — L'actif central

---

### §3 — Compréhension Clinique

#### Définition

La Compréhension Clinique est la représentation synthétique de la situation d'un Patient, construite par un Professionnel de Santé à un moment donné, qui rend cette situation suffisamment cohérente et intelligible pour guider l'action clinique — et pour permettre à un successeur de reprendre la prise en charge sans reconstruire depuis zéro.

C'est le concept central du domaine. C'est l'actif que le Core Domain cherche à préserver et transmettre.

Elle comprend quatre dimensions dans cet ordre logique :

1. **Situation Clinique** — l'état actuel du Patient tel que perçu
2. **Raisonnement Clinique** — l'explication de cet état
3. **Incertitudes Cliniques** — ce qui n'est pas encore établi
4. **Intentions Cliniques** — ce qui doit encore être fait

#### Pourquoi elle existe

Les données brutes ne suffisent pas à guider l'action clinique. Un résultat d'examen, une liste de médicaments, une série de notes factuelles sont nécessaires mais insuffisants. Ce qui manque est la couche interprétative : la signification que ces données ont pour ce Patient particulier, dans ce contexte particulier, à ce moment particulier.

La Compréhension Clinique est cette couche interprétative. Elle ne remplace pas les données — elle les synthétise en quelque chose d'actionnable.

#### Responsabilités

- Représenter l'état de compréhension d'un Patient à un instant donné
- Servir de base à la Reprise de Contexte pour le Professionnel entrant
- S'enrichir de façon cumulative à chaque nouvelle Contribution Clinique

La Compréhension Clinique ne prend pas de décisions. Elle ne diagnostique pas. Elle ne prescrit pas. Elle organise la connaissance disponible pour que le Professionnel puisse décider.

#### Relations

- Appartient à un Patient (`1:1`)
- Est constituée de Contributions Cliniques (`1:N`)
- Comprend des Situations Cliniques, Raisonnements, Incertitudes et Intentions comme dimensions
- Est l'objet d'une Reprise de Contexte lors de chaque Transition
- Est enrichie par chaque nouvelle Contribution

#### Invariants

**I.CC-01** — La Compréhension Clinique d'un Patient est toujours partielle. Nulle compréhension n'est complète.

**I.CC-02** — Elle est cumulative : aucune Contribution ne peut effacer les précédentes. La compréhension s'accumule, elle ne se réécrit pas.

**I.CC-03** — Elle est perspectivale : il n'existe pas une seule "vraie" Compréhension d'un Patient. Chaque Professionnel forme la sienne depuis son point de vue.

**I.CC-04** — Elle est temporellement bornée : une Compréhension est valide à un instant donné et se déprécie si la situation du Patient évolue sans mise à jour.

**I.CC-05** — Elle est irréductible à ses sources : elle ne peut pas être déduite automatiquement des données disponibles. La synthèse interprétative requiert un sujet connaissant.

#### Exemples

"Ce patient présente une insuffisance cardiaque décompensée dans un contexte probable de non-observance. L'hypothèse principale est une surcharge hydrique ; une ischémie reste à écarter. La troponine est en attente. Le traitement diurétique a été renforcé hier soir. Réévaluation attendue ce matin."

Cette formulation n'est pas un compte rendu. C'est une compréhension : elle dit l'état, le raisonnement, l'incertitude, et ce qui reste à faire.

#### Ce qu'elle n'est pas

La Compréhension Clinique n'est pas un dossier patient. Elle n'est pas une liste d'antécédents. Elle n'est pas un résultat d'examen. Elle n'est pas une prescription. Elle n'est pas la somme des données disponibles sur un Patient.

**La différence cruciale :** les données répondent à "Que sait-on ?". La Compréhension répond à "Que signifie ce que nous savons, et pourquoi est-ce important maintenant ?" (voir M-002 §3).

#### Justification

- `M-003 §2.7` — Définition de la Compréhension Clinique.
- `M-003 §3` — Composants.
- `M-003 §4` — Propriétés dynamiques (cumulation, révision, contextualité, temporalité, distribution).
- `M-003 §8` — Statut d'actif.
- `M-003 §9` — Invariants I à VII.
- `M-000 §4` — Définition constitutionnelle et quatre dimensions.
- `P-001 §4` — Distinction données / compréhension.

---

## Groupe III — Unité fondamentale

---

### §4 — Contribution Clinique

#### Définition

La Contribution Clinique est l'**unité fondamentale** de la Compréhension Clinique externalisée. C'est ce qu'un Professionnel de Santé produit lors d'une prise en charge : une représentation datée, attribuée, contextualisée, de sa compréhension de la situation du Patient à ce moment.

Elle est l'objet du domaine le plus concret : c'est ce qui peut être stocké, transmis, et utilisé lors d'une Reprise de Contexte.

Toute Compréhension Clinique d'un Patient est constituée de l'ensemble de ses Contributions Cliniques.

#### Pourquoi elle existe

La Compréhension Clinique est mentale et localisée dans l'esprit du Professionnel. Pour qu'elle puisse survivre à une Transition, elle doit être externalisée. La Contribution Clinique est cette externalisation.

Elle n'est pas une copie exacte de la compréhension mentale du Professionnel — une partie de cette compréhension reste tacite et irréductible. Elle est la **partie externalisable** de cette compréhension, structurée de façon à être utile à un successeur.

#### Responsabilités

- Porter la compréhension d'un Professionnel à un moment donné
- Être attribuable sans ambiguïté à son auteur
- Être datée de son moment de production
- Être contextualisée dans le cadre de soin qui l'a produite
- Enrichir la Compréhension Clinique du Patient de façon cumulative
- Être **non-destructive** — ne jamais effacer les Contributions précédentes

#### Attributs fondamentaux

Ces attributs ne sont pas arbitraires. Chacun est la traduction directe d'une propriété théorique.

| Attribut | Propriété théorique | Source |
|---|---|---|
| `auteur` | Compréhension toujours située et personnelle | M-003 §3.7, Invariant I |
| `produitLe` | Temporalité : la compréhension est datée | M-003 §4.4, Invariant VI |
| `contexte` | Contextualité : dépend du cadre de soin | M-003 §3.7, §4.3 |
| `situationPerçue` | Dimension 1 de la Compréhension Clinique | M-003 §3.1, M-000 §4 |
| `raisonnement` | Dimension 2 — couche interprétative | M-003 §3.2, M-000 §4 |
| `hypothèses` | Structure des possibles non encore tranchés | M-003 §3.3 |
| `incertitudes` | Ce qui n'est pas encore établi | M-003 §3.4, M-000 §4 |
| `décisions` | Décisions prises et leur justification | M-003 §3.5 |
| `intentions` | Projections vers l'action future | M-003 §3.6, M-000 §4 |

#### Relations

- Est produite par un Professionnel de Santé (`N:1`)
- Porte sur un Patient (`N:1`)
- Contribue à la Compréhension Clinique de ce Patient (`N:1`)
- S'inscrit dans le Parcours de Soins du Patient
- Peut être motivée par une Transition (reprise de contexte qui débouche sur une nouvelle contribution)

#### Invariants

**I.CLC-01** — Une Contribution Clinique a toujours exactement un auteur.

**I.CLC-02** — Une Contribution Clinique est toujours datée à son moment de production.

**I.CLC-03** — Une Contribution Clinique ne peut pas être effacée après sa production. Elle peut être amendée par une nouvelle Contribution, mais l'original demeure.

**I.CLC-04** — Une Contribution Clinique appartient à son auteur et à son contexte. Elle ne peut pas être réattribuée.

**I.CLC-05** — Une Contribution Clinique représente une compréhension à un instant donné. Elle ne prétend pas à la permanence.

**I.CLC-06** — Une Contribution Clinique ne peut pas être approuvée ou validée par son propre auteur au nom d'une autre perspective. La validation perspectivale requiert un auteur différent.

#### Exemples

- Une note de consultation d'un médecin généraliste incluant son interprétation des symptômes, les hypothèses envisagées, les examens prescrits et ce qu'il attend.
- Une note de relève infirmière décrivant l'état du Patient en fin de garde, avec observations, préoccupations, et actions prévues pour l'équipe suivante.
- Un commentaire interprétatif d'un spécialiste sur la signification clinique d'un résultat anormal, dans le contexte de ce Patient.

#### Ce qu'elle n'est pas

La Contribution Clinique n'est pas un résultat d'examen (le résultat est une donnée brute ; la Contribution est l'interprétation). Elle n'est pas une ordonnance (l'ordonnance est un acte normatif ; la Contribution inclut le raisonnement qui y conduit). Elle n'est pas un compte rendu standardisé (un compte rendu peut *contenir* une Contribution, mais il n'en est pas une en soi — sauf s'il inclut explicitement le raisonnement et les incertitudes).

#### Justification

- `M-000 §4` — Quatre dimensions de la Compréhension Clinique.
- `M-000 Invariant III` — "Une contribution clinique appartient toujours à son auteur et à son contexte."
- `M-003 §3` — Sept composants de la Compréhension Clinique (tous attributs de la Contribution).
- `M-003 §7` — Sept propriétés d'une représentation valide (toutes imposées à la Contribution).
- `M-003 Invariant IV` — Non-destructivité.
- `CW-001 §9.1` — Ce qui constitue un signal lors d'une Reprise : exactement ce qu'une Contribution bien formée doit contenir.

---

## Groupe IV — Dimensions de la Compréhension

Les cinq concepts suivants sont les **dimensions internes** de la Compréhension Clinique. Ils sont présents dans chaque Contribution Clinique. Ils ne sont pas autonomes — ils n'existent qu'à l'intérieur d'une Contribution.

---

### §5 — Situation Clinique

#### Définition

La Situation Clinique est la représentation de l'état actuel d'un Patient tel que **perçu** par un Professionnel de Santé à un moment donné. Elle organise les observations, les mesures, et les constats en une image cohérente de ce qui est présent.

C'est la première dimension de la Compréhension Clinique : avant de raisonner, le Professionnel doit percevoir.

#### Pourquoi elle existe

Savoir que le Patient est dans un état particulier est le point de départ de toute compréhension. Sans Situation Clinique perçue, il n'y a pas de substrat pour le Raisonnement. La Situation Clinique est la base sur laquelle tout le reste s'appuie.

#### Responsabilités

- Représenter l'état perçu du Patient à un instant donné
- Organiser les observations en tableau cohérent
- Servir de point d'ancrage au Raisonnement Clinique

#### Relations

- Est la première dimension de la Compréhension Clinique
- Est une composante de la Contribution Clinique (`1:1` par Contribution)
- Constitue le substrat du Raisonnement Clinique
- Se distingue de la simple observation brute par son organisation interprétative

#### Invariants

**I.SC-01** — La Situation Clinique est toujours perçue depuis un point de vue. Elle n'est pas la réalité objective du Patient, mais la réalité telle que perçue par le Professionnel.

**I.SC-02** — Elle est datée : elle représente l'état perçu à un moment précis.

**I.SC-03** — Elle évolue : la Situation Clinique d'un Patient à T peut différer de celle à T+1 sans que la précédente soit fausse.

#### Exemples

"Patient présentant une dyspnée d'effort, des œdèmes des membres inférieurs bilatéraux, et une saturation en oxygène à 93% en air ambiant."

Ce n'est pas une liste de données. C'est une image organisée : la dyspnée, les œdèmes, et la saturation forment ensemble un tableau cohérent.

#### Ce qu'elle n'est pas

La Situation Clinique n'est pas un résultat d'examen brut. Elle n'est pas une liste de symptômes. Elle est l'organisation interprétée de ces éléments en une image cohérente. Elle ne contient pas encore le *pourquoi* — c'est le rôle du Raisonnement.

#### Justification

- `M-003 §3.1` — "l'image organisée de l'état du patient."
- `M-000 §4 dimension 1` — "L'état du patient au moment de la prise en charge — ce qui est observé, mesuré, constaté."
- `CW-001 §5.1` — Première dimension du Modèle de Situation.

---

### §6 — Raisonnement Clinique

#### Définition

Le Raisonnement Clinique est l'**explication** que le Professionnel de Santé donne de la Situation Clinique perçue : pourquoi le Patient est dans cet état, selon quelle logique, à partir de quelles hypothèses. Il est la deuxième dimension de la Compréhension Clinique.

#### Pourquoi il existe

Savoir que le Patient est dans un état particulier ne suffit pas. Il faut comprendre pourquoi. Le Raisonnement Clinique est la réponse à cette question. C'est la valeur que le Professionnel ajoute à la Situation — la couche interprétative qui transforme une observation en compréhension.

C'est la dimension la plus souvent absente des systèmes d'information actuels. Les systèmes stockent ce qui a été fait, rarement pourquoi.

#### Responsabilités

- Expliquer la Situation Clinique perçue
- Articuler les hypothèses retenues et les raisons pour lesquelles d'autres ont été écartées
- Justifier les décisions prises

#### Relations

- S'appuie sur la Situation Clinique
- Génère des Hypothèses Cliniques à partir des possibles explorés
- Oriente les Intentions Cliniques
- Est une composante de la Contribution Clinique

#### Invariants

**I.RC-01** — Le Raisonnement Clinique est toujours perspectival : il est celui d'un auteur particulier depuis sa position.

**I.RC-02** — Il peut être incorrect. Sa valeur pour la Reprise de Contexte est indépendante de son exactitude : même un raisonnement partiellement erroné transmet la logique suivie, ce qui est plus utile qu'aucun raisonnement documenté.

**I.RC-03** — Il est irréductible aux données : des données identiques peuvent conduire deux Professionnels à des raisonnements différents.

#### Exemples

"La dyspnée et les œdèmes, dans le contexte d'une cardiopathie connue et d'une prise de sel excessive cette semaine, orientent vers une décompensation cardiaque par surcharge hydrique plutôt qu'une infection pulmonaire (absence de fièvre, auscultation sans foyer)."

#### Ce qu'il n'est pas

Le Raisonnement Clinique n'est pas un diagnostic (le diagnostic est une conclusion ; le raisonnement est le chemin). Il n'est pas une prescription. Il n'est pas algorithmique — il ne peut pas être produit automatiquement à partir des données.

#### Justification

- `M-003 §3.2` — Raisonnement interprétatif comme composant de la Compréhension.
- `M-000 §4 dimension 2` — "Comment cette situation a été comprise — les hypothèses explorées, les éléments qui les ont orientées, les décisions qui en ont découlé."
- `CW-001 §9.1` — Le raisonnement documenté est identifié comme le signal le plus précieux lors d'une reprise.
- `P-001 §4.2` — Ce que les systèmes ne conservent pas : "la compréhension que le professionnel a formée à partir des données."

---

### §7 — Hypothèse Clinique

#### Définition

L'Hypothèse Clinique est une **explication candidate** de la Situation Clinique, formulée par un Professionnel et non encore confirmée ou écartée. Elle représente les possibles que le Professionnel maintient actifs dans son raisonnement.

#### Pourquoi elle existe

La Compréhension Clinique inclut structurellement l'incertitude. L'Hypothèse Clinique est l'expression de cette incertitude sous forme de possibilités maintenues ouvertes. Elle distingue ce qui est établi (le Raisonnement retenu) de ce qui est envisagé mais non tranché.

#### Responsabilités

- Maintenir les explications alternatives plausibles
- Orienter les investigations nécessaires pour la confirmer ou l'écarter
- Informer le Professionnel suivant des possibilités non encore tranchées

#### Relations

- Découle du Raisonnement Clinique
- Alimente les Incertitudes Cliniques (une hypothèse non tranchée est une Incertitude)
- Peut devenir certitude (hypothèse confirmée) ou être écartée (hypothèse réfutée)
- Est une composante de la Contribution Clinique

#### Invariants

**I.HC-01** — Une Hypothèse Clinique est toujours provisoire.

**I.HC-02** — Elle est toujours datée et attribuée à un auteur.

**I.HC-03** — Une hypothèse écartée reste historiquement visible. Sa réfutation est une information clinique : elle informe le Professionnel suivant de ce qui a été exploré et exclu.

#### Exemples

"Hypothèse principale : décompensation cardiaque. Hypothèse alternative à ne pas écarter : embolie pulmonaire (la saturation basse sans foyer auscultatoire y incite). Hypothèse écartée : pneumopathie infectieuse (absence de fièvre, pas d'expectorations)."

#### Ce qu'elle n'est pas

L'Hypothèse Clinique n'est pas un diagnostic (le diagnostic est une conclusion retenue ; l'hypothèse est un candidat en évaluation). Elle n'est pas une certitude. Une liste de diagnostics différentiels non contextualisée n'est pas une liste d'Hypothèses Cliniques.

#### Justification

- `M-003 §3.3` — "La structure des possibles : les hypothèses non écartées, les diagnostics différentiels en jeu."
- `CW-001 §3.2` — Le cadre initial du Professionnel inclut des hypothèses implicites.

---

### §8 — Incertitude Clinique

#### Définition

L'Incertitude Clinique est la **représentation explicite** de ce que le Professionnel de Santé ne sait pas encore à un moment donné, et qui est cliniquement significatif. Elle est la troisième dimension de la Compréhension Clinique.

#### Pourquoi elle existe

La Compréhension Clinique est toujours partielle. Masquer cette partialité produit une représentation trompeuse et potentiellement dangereuse. L'Incertitude Clinique est la formalisation honnête des limites de la compréhension à un instant donné.

Sa documentation est cliniquement critique : les incertitudes non transmises lors d'une Transition sont une source documentée de risque pour le Patient.

#### Responsabilités

- Exprimer ce qui n'est pas encore établi
- Identifier les résultats attendus ou les questions en suspens
- Alerter le Professionnel suivant sur ce qui demande encore attention

#### Relations

- Découle des Hypothèses Cliniques non encore tranchées
- Oriente les Intentions Cliniques (les actions nécessaires pour lever l'incertitude)
- Est une composante de la Contribution Clinique
- Est particulièrement critique lors d'une Transition

#### Invariants

**I.IC-01** — Toute Compréhension Clinique contient des Incertitudes Cliniques. Une compréhension qui n'en contient aucune est épistémiquement suspecte.

**I.IC-02** — L'Incertitude Clinique est datée : elle peut être levée par de nouvelles informations.

**I.IC-03** — Une Incertitude levée reste tracée : la question et sa résolution font partie de l'histoire clinique.

#### Exemples

"Résultat de troponine en attente — la composante ischémique reste à préciser." / "La cause déclenchante de la décompensation (ischémique ou fonctionnelle) n'est pas encore établie."

#### Ce qu'elle n'est pas

L'Incertitude Clinique n'est pas un aveu d'incompétence. Elle n'est pas synonyme d'ignorance générale. Elle est la délimitation précise de ce qui reste à établir dans une compréhension par ailleurs structurée.

#### Justification

- `M-003 §3.4` — "La cartographie explicite de ce que le praticien ne sait pas encore."
- `M-003 §7.4` — Explicitation de l'incertitude comme propriété d'une représentation valide.
- `M-003 Invariant VII` — "La compréhension inclut l'incertitude."
- `M-000 §4 dimension 3` — "Ce qui n'est pas encore résolu — les questions sans réponse, les résultats attendus, les hypothèses non confirmées."
- `CW-001 §9.1` — Les incertitudes explicitement formulées constituent un signal lors d'une reprise.

---

### §9 — Intention Clinique

#### Définition

L'Intention Clinique est la représentation de ce qui a été **décidé et doit encore être réalisé** : les actions planifiées, les suivis prévus, les transmissions attendues. Elle est la quatrième dimension de la Compréhension Clinique.

#### Pourquoi elle existe

La Compréhension Clinique est orientée vers l'action. Une compréhension qui ne dit pas ce qui doit encore être fait est incomplète pour le Professionnel suivant. L'Intention Clinique assure la continuité entre ce qui a été décidé et ce qui sera exécuté, même en cas de Transition.

Sans les Intentions documentées, le Professionnel entrant ignore ce qui est en cours et risque de redécouvrir, redécider, ou contredire des actions déjà engagées.

#### Responsabilités

- Représenter les décisions prises mais non encore exécutées
- Informer le Professionnel suivant de ce qui reste à faire
- Assurer la continuité des soins à travers les Transitions

#### Relations

- Découle du Raisonnement Clinique et des décisions arrêtées
- Est conditionnée par les Incertitudes Cliniques (certaines intentions sont conditionnelles à la levée d'une incertitude)
- Est une composante de la Contribution Clinique
- Est la cible principale de la Reprise de Contexte lors d'une Transition

#### Invariants

**I.ICC-01** — Une Intention Clinique est toujours attribuée à un auteur : qui a décidé de faire quoi, et pourquoi.

**I.ICC-02** — Elle est datée : une intention ancienne peut être caduque si la situation a évolué.

**I.ICC-03** — Elle peut devenir caduque sans avoir été exécutée, si la situation clinique la rend inappropriée. Sa caducité doit être documentée.

#### Exemples

"Contrôle de l'ionogramme demain matin. Appel du cardiologue si la troponine est positive. Réévaluation de la diurèse à 48h avant décision sur la sortie."

#### Ce qu'elle n'est pas

L'Intention Clinique n'est pas une ordonnance (l'ordonnance est un acte formel exécutable ; l'Intention est la trace de la décision qui y conduit et qui l'explique). Elle n'est pas un calendrier de soins standardisé. Elle n'est pas un protocole.

#### Justification

- `M-003 §3.6` — "La projection vers l'avenir : ce qui a été décidé mais non encore fait."
- `M-000 §4 dimension 4` — "Ce qui doit encore être fait — les décisions prises mais non encore exécutées, les suivis prévus, les transmissions attendues."
- `CW-001 §9.1` — "Les actions en suspens" identifiées comme signal clé lors d'une reprise.

---

## Groupe V — Continuité et transitions

---

### §10 — Parcours de Soins

#### Définition

Le Parcours de Soins est la **trajectoire clinique longitudinale** d'un Patient, constituée de l'ensemble de ses Contributions Cliniques ordonnées chronologiquement. Il est la mémoire cumulative de la Compréhension Clinique du Patient.

#### Pourquoi il existe

La continuité du Patient exige une représentation de sa continuité clinique. Le Parcours de Soins est cette représentation. Il n'est pas un dossier administratif — il est l'accumulation ordonnée et non-destructive des compréhensions successives que les différents Professionnels ont produites.

#### Responsabilités

- Accumuler les Contributions Cliniques dans leur ordre chronologique
- Préserver l'histoire complète sans destruction des Contributions passées
- Permettre la Reprise de Contexte à tout moment de la trajectoire

#### Relations

- Appartient à un Patient (`1:1`)
- Est constitué de Contributions Cliniques (`1:N`)
- Est traversé par des Transitions
- Est la source principale d'information lors d'une Reprise de Contexte

#### Invariants

**I.PS-01** — Le Parcours de Soins est non-destructif : aucune Contribution Clinique ne peut être effacée.

**I.PS-02** — Il est chronologiquement ordonné.

**I.PS-03** — Il appartient au Patient — pas à un Professionnel ou à un établissement particulier.

**I.PS-04** — Il ne peut pas être complet : il ne reflète que les interactions qui ont donné lieu à une Contribution externalisée.

#### Exemples

L'ensemble des Contributions Cliniques d'un patient diabétique suivi sur quinze ans par son médecin traitant, plusieurs spécialistes, et plusieurs établissements — organisées chronologiquement, incluant les raisonnements documentés à chaque étape significative.

#### Ce qu'il n'est pas

Le Parcours de Soins n'est pas un Dossier Patient Informatisé (DPI). Il n'est pas une liste d'actes médicaux. Il n'est pas un historique administratif. Il est spécifiquement la trace des Compréhensions Cliniques successives, pas de tous les faits administratifs ou réglementaires associés au Patient.

#### Justification

- `P-001 §2.1` — Continuité du patient.
- `M-000 Invariant II` — "La compréhension clinique est cumulative — jamais effacée."
- `M-003 Invariant IV` — Non-destructivité.
- `M-003 §4.1` — Cumulation comme propriété dynamique.

---

### §11 — Transition

#### Définition

La Transition est l'**événement structurel** où un Professionnel de Santé cesse d'être le référent d'un Patient et un autre prend le relais. Elle crée mécaniquement un vide de compréhension : la compréhension du Professionnel sortant n'est plus disponible ; le Professionnel entrant n'en a pas encore.

#### Pourquoi elle existe

La Transition est la conséquence directe de l'asymétrie entre la continuité du Patient et la discontinuité des Professionnels. Elle est **inévitable** dans tout système de santé réel. C'est à ce moment précis que la Compréhension Clinique est la plus menacée.

Le Théorème central (M-003 §12) établit que toute organisation dans laquelle des Transitions surviennent nécessite un mécanisme explicite de préservation et transmission de la compréhension.

#### Responsabilités

La Transition n'a pas de responsabilités propres : c'est un événement, pas un agent. Mais elle crée des obligations :
- Pour le Professionnel sortant : responsabilité de produire une Contribution Clinique transmissible
- Pour le Professionnel entrant : responsabilité d'effectuer une Reprise de Contexte

#### Relations

- Intervient dans le Parcours de Soins d'un Patient
- Crée le besoin d'une Reprise de Contexte
- Est le moment de risque principal pour la Compréhension Clinique

#### Invariants

**I.T-01** — Toute Transition crée un vide de compréhension, même si elle s'accompagne d'une transmission explicite.

**I.T-02** — La Transition ne peut pas être éliminée — elle peut seulement être mieux gérée par une meilleure préservation de la Compréhension.

**I.T-03** — La fréquence des Transitions est corrélée au risque cumulatif de perte de compréhension.

#### Exemples

Fin de garde d'un médecin hospitalier ; absence d'un médecin généraliste remplacé par un confrère ; transfert d'un Patient d'un service à un autre ; retour d'un Patient après une longue absence ; consultation spécialisée pour un Patient adressé par son médecin traitant.

#### Ce qu'elle n'est pas

La Transition n'est pas une défaillance. Elle n'est pas accidentelle. Elle est un événement structurel normal du système de santé, conséquence de la nature humaine des soignants et de la complexité des soins distribués.

#### Justification

- `P-001 §2.3` — "Point de rupture" comme concept structurel.
- `M-003 §12.2` — Prémisses 1 et 2 du Théorème central.
- `P-001 §7` — Conséquences organisationnelles des transitions.

---

### §12 — Reprise de Contexte

#### Définition

La Reprise de Contexte est l'**acte cognitif** par lequel un Professionnel de Santé reconstruit sa Compréhension de la situation d'un Patient au moment d'une prise en charge, en s'appuyant sur les Contributions Cliniques disponibles dans le Parcours de Soins.

Ce n'est pas une lecture. C'est une reconstruction — un acte de synthèse interprétative à partir de matériaux existants.

#### Pourquoi elle existe

Chaque Transition crée un vide de compréhension. La Reprise de Contexte est la réponse nécessaire de tout Professionnel entrant à ce vide. Elle existe parce que la Compréhension Clinique est irréductible aux données brutes : le Professionnel ne peut pas simplement lire le dossier — il doit construire une compréhension.

Son coût est directement influencé par la qualité des Contributions Cliniques disponibles : de meilleures Contributions réduisent le coût et le risque de reconstruction.

#### Responsabilités

- Reconstruire le Modèle de Situation du Patient
- Identifier les Lacunes de compréhension
- Atteindre un seuil de compréhension suffisant pour agir

#### Relations

- Est déclenchée par une Transition
- Porte sur la Compréhension Clinique d'un Patient
- S'appuie sur le Parcours de Soins et ses Contributions Cliniques
- Produit un Modèle de Situation chez le Professionnel entrant
- Révèle des Lacunes

#### Invariants

**I.RC-01** — La Reprise de Contexte ne peut pas être complète : la Compréhension Clinique originale du Professionnel sortant ne peut pas être transférée intégralement.

**I.RC-02** — Son coût est une fonction de la qualité des Contributions Cliniques disponibles.

**I.RC-03** — Elle comporte des risques d'erreur documentés (clôture prématurée, biais d'ancrage, confirmation) qui sont amplifiés par des sources pauvres en interprétation.

**I.RC-04** — Elle est toujours effectuée par le Professionnel lui-même. Elle ne peut pas être déléguée à un système. Un système peut la préparer et la faciliter — pas la remplacer.

#### Exemples

Voir CW-001 — description complète des six phases du travail cognitif réel : orientation, acquisition sélective, construction du modèle, identification des lacunes, priorisation, clôture.

#### Ce qu'elle n'est pas

La Reprise de Contexte n'est pas une lecture de dossier (acte passif vs. acte cognitif actif). Elle n'est pas une procédure formelle avec un début et une fin explicites — c'est un processus cognitif continu avec un critère de clôture subjectif. Elle n'est pas automatisable dans sa totalité.

#### Justification

- `CW-001` — Document entier.
- `P-001 §3` — Coût cognitif de la reprise.
- `M-003 §10.4` — Implications pour la reprise de contexte.
- `M-003 §12.3` — Démonstration du Théorème central.

---

### §13 — Modèle de Situation

#### Définition

Le Modèle de Situation est la **représentation mentale dynamique** que le Professionnel de Santé construit lors d'une Reprise de Contexte. C'est le résultat cognitif intermédiaire de la reprise : une image organisée et suffisamment cohérente de la situation du Patient pour guider l'action immédiate.

Le Modèle de Situation n'est pas stocké. Il est un état transitoire du raisonnement du Professionnel.

#### Pourquoi il existe

La Compréhension Clinique vise la durabilité et la transmissibilité. Le Modèle de Situation est son équivalent momentané et interne, produit lors de chaque Reprise de Contexte. Il est l'état cognitif que le Professionnel atteint avant de passer à l'action.

#### Responsabilités

- Synthétiser les informations issues du Parcours de Soins en une image cohérente
- Identifier les Lacunes à résoudre
- Atteindre un seuil de complétude suffisant pour l'action

#### Relations

- Est produit lors d'une Reprise de Contexte
- S'appuie sur les Contributions Cliniques du Parcours de Soins
- Contient les mêmes dimensions que la Compréhension Clinique (Situation, Raisonnement, Incertitudes, Intentions)
- Révèle les Lacunes de compréhension

#### Invariants

**I.MS-01** — Le Modèle de Situation est toujours partiel.

**I.MS-02** — Il est subjectif : le même dossier peut produire des Modèles de Situation différents chez des Professionnels différents.

**I.MS-03** — Son niveau de complétude est évalué par le Professionnel lui-même, selon un seuil subjectif qui varie selon le contexte, la pression temporelle, et l'enjeu clinique.

#### Exemples

La représentation mentale qu'un médecin a construite d'un patient après dix minutes de lecture : une image partielle, organisée autour des éléments les plus saillants, avec des questions encore ouvertes.

#### Ce qu'il n'est pas

Le Modèle de Situation n'est pas stocké — il vit dans l'esprit du Professionnel pendant la reprise. Il n'est pas la Contribution Clinique (qui est l'externalisation de la compréhension, pas le processus de construction). Il n'est pas un document.

#### Justification

- `CW-001 §5.1` — "Représentation mentale dynamique de l'état présent du monde pertinent pour la tâche en cours."
- `CW-001 §5.2` — La construction du modèle comme narration.

---

### §14 — Lacune

#### Définition

Une Lacune est une **information manquante identifiée** lors d'une Reprise de Contexte, dont l'absence crée une incertitude non résolue dans le Modèle de Situation du Professionnel.

#### Pourquoi elle existe

La Reprise de Contexte ne produit jamais un Modèle de Situation complet. Les Lacunes sont les manifestations de cette incomplétude : elles marquent les endroits où la compréhension est insuffisante pour une action sécurisée. Leur identification est une étape cognitive clé de la reprise.

#### Responsabilités

- Marquer les zones d'incertitude non résolue dans le Modèle de Situation
- Orienter les investigations complémentaires du Professionnel entrant

#### Relations

- Émerge lors d'une Reprise de Contexte
- Correspond à une Incertitude Clinique non documentée ou à une information attendue et non disponible
- Peut être récupérable immédiatement, récupérable avec effort, ou irréductible

#### Invariants

**I.L-01** — Toute Reprise de Contexte produit des Lacunes : il n'existe pas de reprise sans lacunes.

**I.L-02** — Une Lacune est d'autant plus fréquente et coûteuse que les Contributions Cliniques disponibles sont pauvres en contenu interprétatif.

**I.L-03** — Certaines Lacunes sont irréductibles : l'information manquante n'existe nulle part et ne peut être reconstituée. Ces Lacunes sont une forme de perte permanente de compréhension.

#### Exemples

"Le résultat de l'IRM demandée la semaine dernière n'apparaît pas dans le dossier." / "La raison de l'arrêt de l'anticoagulant n'est pas documentée." / "Le compte rendu de la concertation pluridisciplinaire est absent."

#### Ce qu'elle n'est pas

Une Lacune n'est pas une erreur médicale. Elle n'est pas un bug du système d'information. Elle est une conséquence structurelle de la partialité de toute Compréhension Clinique.

#### Justification

- `CW-001 §6` — Phase 4 : Identification des lacunes.
- `M-003 Invariant II` — "La Compréhension Clinique est toujours partielle."
- `P-001 §3.1` — "La reconstruction n'est pas un acte de récupération — c'est un acte de synthèse."

---

## Groupe VI — Structure perspectivale

---

### §15 — Perspective

#### Définition

La Perspective est le **point de vue situé** depuis lequel un Professionnel de Santé forme sa Compréhension Clinique. Elle est déterminée par son expertise, sa spécialité, sa position dans la chaîne de soins, et le contexte de la prise en charge.

La Perspective n'est pas un attribut optionnel — elle est structurellement inévitable. Toute Contribution Clinique est perspectivale.

#### Pourquoi elle existe

La Compréhension Clinique est perspectivale par nature — il n'existe pas de compréhension "depuis nulle part". Deux Professionnels compétents peuvent former des compréhensions légitimement différentes du même Patient, en raison de leurs perspectives différentes. Sans ce concept, ces divergences apparaissent comme des erreurs à corriger. Avec ce concept, elles apparaissent comme des contributions complémentaires à une compréhension distribuée.

La Perspective justifie directement l'attribution des Contributions Cliniques : savoir *qui* a produit une compréhension est une partie de ce que cette compréhension signifie.

#### Responsabilités

- Expliquer pourquoi plusieurs Contributions Cliniques d'un même Patient peuvent diverger sans se contredire
- Justifier que la provenance d'une Contribution fait partie de sa signification

#### Relations

- Appartient à un Professionnel de Santé
- Détermine la nature et le focus de chaque Contribution Clinique
- Est une dimension du contexte de production d'une Contribution

#### Invariants

**I.P-01** — Toute Contribution Clinique est perspectivale. Il n'en existe pas sans perspective.

**I.P-02** — Des Perspectives différentes sur un même Patient sont complémentaires et non contradictoires, sauf si elles portent sur les mêmes faits objectifs.

**I.P-03** — Une Perspective ne peut pas être neutre ou universelle.

**I.P-04** — La coexistence de Perspectives différentes sur un même Patient est une richesse, pas un problème à résoudre.

#### Exemples

La perspective cardiologique vs. la perspective néphrologiste sur un même patient en insuffisance cardiorénale. La perspective d'urgence vs. la perspective de suivi long terme sur un même tableau clinique. La perspective infirmière vs. la perspective médicale sur la tolérance d'un traitement.

#### Ce qu'elle n'est pas

La Perspective n'est pas un biais à corriger. Elle n'est pas un défaut de la Compréhension Clinique. Elle n'est pas la spécialité médicale du Professionnel (bien qu'elle soit influencée par elle). Elle est la propriété structurelle qui rend la compréhension distribuée possible et légitime.

#### Justification

- `M-003 §5` — Perspectivisme clinique.
- `M-003 §5.1` — "Des praticiens différents comprennent légitimement la même situation de façons différentes."
- `M-003 Invariant V` — "La Compréhension Clinique est perspectivale."

---

## Règles du Domain Atlas

### R-DA-01 — Aucun concept sans fondement

Tout concept présent dans ce Domain Atlas doit citer explicitement le document fondateur qui le justifie. Un concept sans justification est un concept non validé.

### R-DA-02 — Les dimensions ne sont pas autonomes

Les cinq dimensions de la Compréhension Clinique (Situation, Raisonnement, Hypothèse, Incertitude, Intention) n'existent qu'à l'intérieur d'une Contribution Clinique. Elles ne sont pas des entités indépendantes du Core Domain.

### R-DA-03 — L'implémentation ne crée pas de concepts

Un concept d'implémentation (classe, table, API) ne peut pas être élevé au rang de concept métier. Le Domain Atlas précède l'implémentation et la contraint.

### R-DA-04 — Toute évolution est justifiée

L'ajout d'un concept au Domain Atlas requiert une justification dans un document fondateur existant. Si le fondement n'existe pas, il faut d'abord produire le document de recherche ou théorique qui l'établit.

### R-DA-05 — Les invariants ne sont pas des règles de validation

Les invariants exprimés dans ce document sont des propriétés fondamentales du domaine, pas des règles de validation d'interface. Leur violation n'est pas une erreur utilisateur — c'est une corruption du modèle.

---

*Ce document est la vérité métier du projet. Toute décision d'implémentation, d'architecture, ou de produit qui introduit un concept absent de cet Atlas, ou qui viole un invariant défini ici, doit être soumise à révision avant d'être appliquée.*
