# DA-010 — Clinical Activity

**Version :** 1.0
**Statut :** Accepted
**Date :** 2026-07-28
**Position dans la chaîne documentaire :** Extension du Domain Atlas V1 — concept formalisé, non ajouté
**Référence :** Domain Atlas V1 · ADR-0007 · ADR-0008 · ADR-0009 · CAL-001 · M-003

---

## Objet de ce document

Ce document répond à une seule question :

**Pourquoi le domaine a-t-il besoin du concept de Clinical Activity ?**

La définition viendra après la démonstration. Un concept que l'on ne peut pas démontrer nécessaire n'a pas sa place dans le modèle.

---

## Proposition I — La Contribution Clinique ne peut pas exister sans contexte opérationnel

### Le phénomène non exprimé

Le Domain Atlas V1 définit quinze concepts. Parmi eux, aucun ne désigne le moment dans lequel un Professionnel de Santé est activement engagé avec la situation d'un Patient.

Le Patient est l'entité continue (§1). Le Professionnel est l'auteur transitoire (§2). La Contribution Clinique est l'externalisation de leur rencontre cognitive (§4). Mais la rencontre elle-même — l'acte par lequel le Professionnel s'engage activement avec la situation du Patient — n'est désignée par aucun concept.

Ce phénomène existe. Il précède toute Contribution. Il est la condition dans laquelle une Contribution naît. Et pourtant, le modèle actuel ne lui donne pas de nom.

C'est l'écart que ce document comble.

### Ce que la Contribution Clinique ne peut pas exprimer seule

La Contribution Clinique (§4) est l'externalisation de la Compréhension Clinique à un instant donné. Elle porte : un auteur, un moment, un Patient, et les quatre dimensions cliniques.

Mais elle ne porte pas ce qui lui a donné naissance.

Elle sait *quand* elle a été produite. Elle ne sait pas *dans quel contexte opérationnel* elle a été produite.

Or M-003 Invariant I établit que toute Compréhension Clinique est **située** — produite depuis un lieu cognitif, un moment, et un contexte d'action. Si la Compréhension est située, son externalisation — la Contribution — l'est aussi nécessairement.

Être située ne signifie pas seulement porter un timestamp. Cela signifie être produite dans le cadre d'une activité orientée, avec une intention, un Patient spécifique, et un Professionnel engagé.

Ce cadre d'activité est précisément ce que le Domain Atlas V1 ne nomme pas encore.

### La question révélatrice

Posons une question simple : *que faisait le Professionnel lorsqu'il a produit cette Contribution ?*

Il était en train d'exercer un travail clinique — examiner, évaluer, décider, transmettre. Ce travail est identifiable, temporellement délimité, et intentionnellement orienté. Il précède la Contribution et lui donne son sens.

Si ce travail disparaissait conceptuellement du modèle, les Contributions deviendraient des textes datés, sans ancrage dans l'activité qui les a rendues nécessaires.

---

## Proposition II — Aucun concept existant ne peut jouer ce rôle

### Pourquoi pas Encounter

ADR-0009 a explicitement retiré Encounter du domaine clinique. La raison était précisément que ce terme est trop lié à un modèle particulier de soin — la consultation face-à-face en cabinet ou à l'hôpital. Il exclut structurellement les soins infirmiers à domicile, les revues médicamenteuses, la chirurgie, la téléconsultation, et toutes les formes d'intervention clinique qui ne correspondent pas à un "rendez-vous".

Un concept qui exclut une grande partie des pratiques cliniques réelles ne peut pas être le contexte opérationnel universel de la Contribution Clinique.

### Pourquoi pas Consultation

Consultation désigne un type spécifique d'interaction — le médecin qui reçoit un patient pour un avis. Il exclut : l'intervention chirurgicale, la visite infirmière, la revue pharmaceutique, la séance de kinésithérapie, la réunion de concertation pluridisciplinaire.

La Consultation échoue au test CPP-001 : elle ne représente pas la réalité de tous les professionnels de santé.

### Pourquoi pas Acte

Acte est un terme du registre administratif et juridique. Un acte, en droit français de la santé, est une unité de facturation. Il est défini par la nomenclature, pas par le travail clinique réel. Un Professionnel peut effectuer un travail clinique complet sans produire d'"acte" au sens administratif. Et il peut produire des "actes" sans qu'aucune Compréhension Clinique ne soit réellement construite.

L'Acte est ce que le domaine administratif fait de l'activité clinique. Ce n'est pas le domaine clinique lui-même.

### Pourquoi pas la Transition

La Transition (§11) est l'événement structurel du passage de responsabilité. Elle est un fait ponctuel — le moment où un Professionnel cesse d'être référent et un autre commence. Elle ne désigne pas le travail en cours ; elle désigne la rupture entre deux séquences de travail.

### Pourquoi pas la Reprise de Contexte

La Reprise de Contexte (§12) est l'acte cognitif de reconstruction qui précède le travail clinique. Elle est la phase préparatoire — ce que le Professionnel fait avant d'agir. Elle peut conduire à une Clinical Activity, mais elle n'en est pas une.

### Conclusion de la Proposition II

Aucun concept du Domain Atlas V1 — ni aucun concept explicitement écarté par les ADRs existants — ne peut désigner le contexte opérationnel dans lequel une Contribution Clinique naît. Ce contexte existe. Il est nécessaire. Il lui faut un nom.

---

## Proposition III — Clinical Activity est le concept nécessaire et suffisant

### Ce qui qualifie un concept de domaine

Un concept entre dans le modèle s'il est :

1. **Non réductible** — il ne peut pas être exprimé par la composition d'autres concepts existants.
2. **Universel** — il s'applique à tous les professionnels de santé, indépendamment de la spécialité et du mode d'exercice.
3. **Déjà présent en filigrane** — il est utilisé implicitement dans les documents fondateurs sans avoir été formalisé.

Clinical Activity satisfait les trois critères.

### Universalité — Le test CPP-001

Une Clinical Activity se produit :

- quand un chirurgien opère,
- quand une infirmière effectue une visite de surveillance,
- quand un pharmacien conduit une révision médicamenteuse,
- quand un kiné réalise une séance de rééducation,
- quand un médecin relit un dossier avant de rappeler un patient,
- quand un gériatre anime une réunion de concertation pluridisciplinaire,
- quand un psychiatre conduit un entretien en téléconsultation.

Dans chaque cas : un Professionnel, un Patient, une intention clinique, un travail cognitif engagé.

Aucune spécificité de métier, de lieu, de durée, ou de mode n'entre dans la définition.

### Présence implicite dans les documents fondateurs

Clinical Activity apparaît dans trois documents antérieurs sans avoir été formellement défini :

**ADR-0007** — "The role of a contribution is a property of the *relationship between a Clinical Activity and a Clinical Contribution*." Le concept est présupposé, non défini.

**ADR-0008** — Clinical Activity est désigné comme sous-domaine entier. Son cycle de vie (lifecycle management, responsibility model) est décrit. Mais sa définition de domaine reste absente.

**CAL-001** — Le cycle de vie d'une Clinical Activity en 7 phases est documenté. Ce document suppose que le lecteur sait ce qu'est une Clinical Activity. Il ne le définit pas.

DA-010 ne crée pas un concept. Il formalise ce qui était déjà nécessaire.

---

## Proposition IV — Les invariants qui découlent du concept

### Invariant 1 — Toute Contribution Clinique est produite dans le contexte d'une Clinical Activity

*Formulation :* "dans le contexte de" — non "lors de".

La distinction est importante. "Lors de" suggère une co-occurrence temporelle : la Contribution est produite pendant que la Clinical Activity se déroule. C'est vrai mais insuffisant.

"Dans le contexte de" affirme quelque chose de plus fort : la Contribution est rendue possible, orientée, et signifiante par la Clinical Activity dans laquelle elle s'inscrit. Une Contribution sans Clinical Activity serait un texte daté sans ancrage opérationnel — un fait sans auteur actif.

*Conséquence :* Il n'existe pas de Contribution orpheline. Toute Contribution hérite du contexte opérationnel de sa Clinical Activity.

### Invariant 2 — Une Clinical Activity peut produire zéro Contributions

*Formulation :* Clinical Activity → 0..n Contributions Cliniques

Non 1..n. Non toujours.

Un Professionnel peut ouvrir le dossier d'un Patient, lire, évaluer, réfléchir, et conclure qu'il n'y a rien à externaliser. La situation est stable. La Compréhension du Professionnel précédent est juste et complète. Aucune nouvelle Contribution n'est nécessaire.

Cette Clinical Activity a bien eu lieu. Elle a bien engagé un Professionnel avec la situation d'un Patient. Et elle n'a produit aucune Contribution.

Forcer la production d'une Contribution pour satisfaire le modèle serait faux du point de vue du domaine. Ce serait créer de la documentation administrative là où le soin n'en a pas besoin.

*Conséquence :* La Clinical Activity est le contexte nécessaire d'une Contribution — pas sa cause automatique.

### Invariant 3 — Un amendement est produit dans le contexte d'une nouvelle Clinical Activity

*Position A — sans exception.*

Un amendement est une nouvelle externalisation de Compréhension Clinique. Si l'on accepte que toute Compréhension est situated (M-003 Invariant I), et que l'externalisation de cette Compréhension est une Contribution, alors l'amendement est une Contribution produite dans un nouveau contexte opérationnel — une nouvelle Clinical Activity.

```
Clinical Activity #1 (Évaluation initiale)
    └── Contribution Clinique #1

Clinical Activity #2 (Révision après résultats)
    └── Contribution Clinique #2  ← amende #1
```

Cette structure est propre. Elle maintient l'invariant "toute Contribution a une Clinical Activity" sans exception. Elle évite le cas spécial qui complexifierait le modèle.

*Conséquence :* Il n'y a pas deux types de Contributions — primaires et amendements. Il n'y a que des Contributions, chacune produite dans le contexte d'une Clinical Activity.

### Invariant 4 — Une Clinical Activity est indépendante de sa forme

Une Clinical Activity n'est pas définie par :
- sa durée (quelques minutes ou plusieurs heures),
- son lieu (cabinet, hôpital, domicile, téléconsultation),
- son format (face-à-face, téléphonique, réunion),
- son résultat (avec ou sans Contribution).

Elle est définie par son **intention** : le Professionnel s'engage activement avec la situation clinique d'un Patient pour construire, réviser, ou transmettre une Compréhension.

---

## Définition formelle

*Énoncée après démonstration, conformément à la méthode de ce document.*

---

> **Clinical Activity** est l'unité de travail clinique au cours de laquelle un Professionnel de Santé construit, révise, ou transmet une Compréhension Clinique concernant un Patient spécifique.

---

Elle est l'unique contexte opérationnel dans lequel une Contribution Clinique peut être produite.

Elle peut produire zéro Contributions si aucune nouvelle compréhension externalisable n'émerge du travail.

Elle ne présuppose aucune forme, aucune durée, aucun lieu, aucune spécialité.

### Les trois modes d'une Clinical Activity

La définition contient trois verbes. Ils correspondent à trois modes distincts d'engagement :

| Mode | Description | Produit typiquement |
|---|---|---|
| **Construction** | Le Professionnel forme une compréhension initiale ou approfondie | Contribution Clinique principale |
| **Révision** | Le Professionnel amende une compréhension antérieure à la lumière de nouvelles informations | Contribution Clinique qui amende une précédente |
| **Transmission** | Le Professionnel prépare explicitement sa Compréhension pour un successeur (avant une Transition) | Contribution Clinique de transmission |

Ces modes ne s'excluent pas. Une même Clinical Activity peut simultanément réviser et transmettre.

---

## Relations avec le Domain Atlas V1

| Relation | Nature |
|---|---|
| → Contribution Clinique (§4) | La Clinical Activity est le contexte opérationnel de la Contribution. Une Contribution est produite dans le contexte d'une Clinical Activity. |
| → Professionnel de Santé (§2) | La Clinical Activity est conduite par un Professionnel. Elle porte sa Perspective. |
| → Patient (§1) | La Clinical Activity concerne un Patient spécifique. |
| → Parcours de Soins (§10) | Les Contributions produites dans une Clinical Activity s'intègrent dans le Parcours du Patient. |
| → Transition (§11) | Le mode Transmission de la Clinical Activity précède une Transition. |
| → Reprise de Contexte (§12) | La Reprise de Contexte précède une Clinical Activity — elle en est la phase préparatoire, non une Clinical Activity en elle-même. |
| → CAL-001 | CAL-001 décrit le cycle de vie en 7 phases d'une Clinical Activity. DA-010 définit ce qu'elle est. Ces deux documents sont complémentaires et non redondants. |

---

## Ce que la Clinical Activity n'est pas

**Elle n'est pas une Consultation.**
La Consultation est un type de contact spécifique à certaines spécialités et certains modes d'exercice. La Clinical Activity est indépendante du type de contact.

**Elle n'est pas un Encounter.**
ADR-0009 a retiré Encounter du domaine pour les mêmes raisons. La Clinical Activity ne le réintroduit pas sous un autre nom — elle répond à une question différente : le contexte opérationnel, non le type de contact.

**Elle n'est pas un Acte.**
L'Acte est une unité administrative et juridique. La Clinical Activity est une unité du travail clinique réel.

**Elle n'est pas un événement.**
Un événement est ponctuel et instantané. La Clinical Activity a une durée, une intention, et peut contenir plusieurs moments cognitifs distincts.

**Elle n'est pas la Reprise de Contexte.**
La Reprise de Contexte est la phase préparatoire qui précède l'engagement clinique. La Clinical Activity commence là où la Reprise se termine — quand le Professionnel agit.

**Elle n'est pas définie par son résultat.**
Une Clinical Activity sans Contribution Clinique est une Clinical Activity complète. L'absence de Contribution ne signifie pas que l'activité n'a pas eu lieu.

---

## Connexion avec M-003

M-003 §12 — Théorème Central : *"Toute organisation dans laquelle plusieurs professionnels interviennent successivement sur un même patient nécessite un mécanisme explicite de préservation et de transmission de la Compréhension Clinique."*

La Clinical Activity est l'unité élémentaire de ce mécanisme.

C'est dans la Clinical Activity que la Compréhension Clinique est construite (mode Construction). C'est dans la Clinical Activity que les Compréhensions antérieures sont révisées (mode Révision). C'est dans la Clinical Activity que la Compréhension est préparée pour transmission (mode Transmission).

M-003 décrit la nécessité du mécanisme. DA-010 nomme l'unité opérationnelle dans laquelle ce mécanisme s'accomplit.

---

## Relation avec le Domain Atlas V1

Ce document est indépendant du Domain Atlas V1. Il n'en modifie aucun des quinze concepts.

Il démontre que Clinical Activity était déjà présente en filigrane dans le modèle — notamment à travers ADR-0007, ADR-0008, et CAL-001 — et que sa formalisation explicite renforce le modèle sans l'alourdir.

Une prochaine révision du Domain Atlas (V2) intégrera Clinical Activity comme seizième concept, avec ce document comme justification.

---

*Ce document démontre la nécessité d'un concept avant de le définir. C'est la méthode inverse de la plupart des documents de modélisation — et c'est volontaire. Un concept que l'on ne peut pas démontrer nécessaire ne doit pas entrer dans le modèle.*
