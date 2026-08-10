# UX-000 — Product Experience Principles

**Type :** Product Architecture Foundation
**Statut :** Accepted
**Date :** 2026-07-29
**Autorité :** Ce document gouverne toutes les décisions UX, UI et Design System de MedLink. Il est l'équivalent d'ADR-SA-000 pour l'expérience utilisateur. Tout document UX ou décision d'interface qui contredit un principe de ce document doit explicitement le superséder avec justification.

---

## Objet

Le domaine de MedLink est gelé (Architecture Freeze v1.0 — 2026-07-28).

Ce document établit les principes d'expérience produit qui s'appliquent à toute décision d'interface, de parcours, et de Design System. Ces principes sont indépendants des outils de design, des frameworks front-end, et des choix de composants. Ils protègent le praticien contre un logiciel qui travaillerait contre lui.

Toute décision UX qui propose une exception à ces principes doit démontrer que l'exception ne compromet pas l'invariant protégé.

---

## Fondation

Ces principes dérivent de trois sources convergentes :

| Source | Apport |
|---|---|
| CLAUDE.md — Mission | *Réduire l'effort cognitif nécessaire pour comprendre une situation clinique* — objectif fondateur |
| UXP-001 — UX Principles | 26 principes empiriques dérivés de CW-001, observation du travail clinique réel |
| ADR-SA-000 — Software Constitution | Les Workspaces sont des Projections calculées — jamais construites manuellement |

Ces principes ne viennent pas de préférences esthétiques ou de tendances de design. Ils viennent de l'observation que le soin a une structure cognitive propre — et que le logiciel doit la respecter.

---

## Note fondatrice

> Les principes de ce document protègent des **invariants d'expérience**, non des choix d'implémentation UI.
>
> Un composant, une disposition, une palette de couleurs, une bibliothèque — ce sont des implémentations. Elles peuvent changer. Les invariants d'expérience ne changent pas.
>
> Lorsqu'une décision de design modifie un pattern UI, elle doit démontrer que l'invariant protégé est toujours satisfait — pas qu'elle utilise le même composant.

---

## Principes

### UX-P01 — Le soin est le centre de gravité

**MedLink n'est pas organisé autour des fonctionnalités mais autour du parcours de soin.**

La navigation, les espaces de travail et les informations doivent toujours refléter l'activité clinique réelle.

**Invariant protégé :** Le logiciel s'adapte au métier, jamais l'inverse.

*Pourquoi :* un logiciel organisé autour de ses propres features impose au praticien de traduire son intention clinique en geste logiciel. Cette traduction est un effort cognitif supplémentaire que MedLink a pour mission de supprimer.

---

### UX-P02 — Le contexte précède toujours l'action

**Avant de demander une décision au praticien, MedLink fournit le contexte nécessaire.**

Chaque action doit être précédée des informations permettant de la comprendre.

**Invariant protégé :** Aucune décision clinique ne doit être prise sans contexte.

*Pourquoi :* une décision sans contexte est un jugement en aveugle. Dans un contexte clinique, cela génère des erreurs. Le logiciel qui demande une action avant de fournir le contexte transfère sa propre lacune au praticien. (Voir UXP-001 — UXP-02, UXP-07)

---

### UX-P03 — Le praticien travaille, il ne navigue pas

**Le logiciel doit minimiser les changements d'écran.**

Le travail doit s'effectuer dans un espace cohérent où les informations et les actions restent accessibles.

**Invariant protégé :** Le coût cognitif de la navigation reste minimal.

*Pourquoi :* chaque changement d'écran est une interruption. Chaque interruption impose un coût de reprise (UXP-001 — UXP-15). Naviguer pour travailler signifie reconstruire mentalement le contexte à chaque retour. MedLink doit porter le contexte — pas le praticien.

---

### UX-P04 — Une seule intention principale par Workspace

**Chaque espace de travail possède une mission claire.**

Il peut contenir plusieurs actions secondaires, mais une seule intention principale.

**Invariant protégé :** Le praticien sait immédiatement pourquoi il est dans cet espace.

*Pourquoi :* un Workspace sans intention claire est un écran généraliste. Le praticien doit inférer ce qu'il est censé y faire — ajoutant une charge cognitive qui n'appartient pas au soin. (Voir WSP-001 — Workspace Definition)

---

### UX-P05 — La Timeline est la mémoire clinique

**Toutes les informations temporelles convergent vers une seule représentation chronologique.**

Aucun historique parallèle ne doit exister.

**Invariant protégé :** Le passé clinique est unique et cohérent.

*Pourquoi :* des historiques multiples créent des divergences. Un praticien qui ne sait pas où chercher l'historique complet ne peut pas faire confiance à ce qu'il trouve. L'unicité de la Timeline est un invariant de confiance, pas d'ergonomie. (Voir UXP-001 — UXP-05, UXP-17, UXP-18)

---

### UX-P06 — L'information est progressive

**L'interface révèle d'abord l'essentiel puis permet d'accéder naturellement au détail.**

Le logiciel ne surcharge jamais l'utilisateur lors du premier regard.

**Invariant protégé :** La charge cognitive reste maîtrisée.

*Pourquoi :* la charge cognitive est une ressource limitée. Un premier écran surchargé consomme de l'attention avant que le soin commence. La progressivité est une décision d'architecture de l'information, pas un choix esthétique. (Voir UXP-001 — UXP-06, UXP-13)

---

### UX-P07 — Chaque information possède un propriétaire

**Toute donnée affichée indique clairement : son auteur, son origine, sa date, son contexte clinique.**

**Invariant protégé :** Le praticien peut toujours évaluer la confiance qu'il accorde à une information.

*Pourquoi :* une information sans source est une information sans responsabilité. Dans un contexte clinique, l'auteur et le contexte de production d'une information déterminent son crédit. Afficher une information sans attributer sa source supprime la capacité du praticien à l'évaluer. (Voir UXP-001 — UXP-22, UXP-23 · ADR-0007 — Rôles sur Relations)

---

### UX-P08 — La collaboration est visible

**Le travail collectif ne doit jamais être caché.**

Le praticien comprend immédiatement : qui est intervenu, ce qui a changé, pourquoi.

**Invariant protégé :** La coordination des soins reste explicite.

*Pourquoi :* le travail clinique est rarement solitaire. Une interface qui cache les contributions des autres intervenants crée des doublons, des contradictions, et des lacunes de coordination. La visibilité du collectif n'est pas une feature sociale — c'est une condition de sécurité clinique. (Voir UXP-001 — UXP-24 · ADR-0008 — Clinical Work & Clinical Knowledge)

---

### UX-P09 — Les recommandations sont explicables

**Toute recommandation, alerte ou assistance doit être accompagnée d'une justification compréhensible.**

L'utilisateur garde toujours la maîtrise de sa décision.

**Invariant protégé :** La confiance repose sur la transparence, jamais sur une boîte noire.

*Pourquoi :* une recommandation sans justification est une injonction. Un praticien qui ne comprend pas pourquoi une alerte est déclenchée ne peut pas l'évaluer — il ne peut que l'accepter ou la rejeter en aveugle. La transparence des recommandations est une condition de la responsabilité professionnelle. (Voir CLAUDE.md — AI Principles : "AI never owns clinical decisions")

---

### UX-P10 — Le logiciel s'efface devant le soin

**Le praticien ne doit jamais avoir le sentiment d'utiliser une interface complexe.**

Son attention reste concentrée sur le patient.

**Invariant protégé :** L'expérience utilisateur favorise la relation de soin plutôt que l'utilisation du logiciel.

*Pourquoi :* la relation entre le praticien et son patient est la finalité. Le logiciel est un intermédiaire. Un intermédiaire qui se rend visible par sa complexité détourne l'attention de sa propre finalité. Le signe d'un bon logiciel clinique est qu'il disparaît. (Voir CLAUDE.md — Mission : *"que les praticiens puissent consacrer leur énergie au raisonnement, à la décision et à la relation avec leurs patients"*)

---

## Hiérarchie normative

```
CLAUDE.md (Mission)
        │
        ▼
UX-000 (Constitution UX — ce document)
        │
        ├──▶ UXP-001 (Principes UX cliniques — 26 principes empiriques CW-001)
        │
        └──▶ UX-xxx (Décisions d'interface spécifiques)
```

Un document UX-xxx ne peut pas contredire UX-000 sans le superséder explicitement.

UX-000 ne peut pas contredire CLAUDE.md.

### Relation avec ADR-SA-000

UX-000 et ADR-SA-000 sont de même rang dans leurs domaines respectifs. Ils sont tous deux subordonnés à CLAUDE.md.

| Document | Domaine |
|---|---|
| ADR-SA-000 | Architecture logicielle — comment le système est construit |
| UX-000 | Architecture produit — comment le système est vécu |

Quand une décision technique (ADR-SA-xxx) a un impact sur l'expérience (ex. : délai de cohérence éventuelle visible par l'utilisateur), UX-000 et ADR-SA-000 sont tous deux concernés. La décision est validée aux deux niveaux.

---

## Violation et exception

Une violation d'un principe est acceptable uniquement si :

1. La violation est documentée dans un document UX dédié qui cite le principe concerné.
2. La justification démontre que l'invariant protégé par le principe reste garanti par un mécanisme alternatif.
3. La violation est limitée dans son périmètre (un Workspace, un contexte, une version).

Une violation non documentée est un choix de design non gouverné.

---

## Bloc de conformité — Template pour les documents UX

Tout document UX qui définit un Workspace, un parcours, ou un composant doit inclure un bloc de conformité :

```
## Conformité UX-000

| Principe | Statut | Note |
|---|---|---|
| UX-P01 — Soin au centre       | ✅ Conforme / ⚠️ Exception documentée §X | ... |
| UX-P02 — Contexte avant action | ✅ Conforme / ⚠️ Exception documentée §X | ... |
| UX-P03 — Travail sans navigation | ✅ Conforme / ⚠️ Sans objet            | ... |
| UX-P04 — Une intention par Workspace | ✅ Conforme / ⚠️ Sans objet       | ... |
| UX-P05 — Timeline unique       | ✅ Conforme / ⚠️ Sans objet            | ... |
| UX-P06 — Information progressive | ✅ Conforme / ⚠️ Exception documentée §X | ... |
| UX-P07 — Propriétaire visible  | ✅ Conforme / ⚠️ Exception documentée §X | ... |
| UX-P08 — Collaboration visible | ✅ Conforme / ⚠️ Sans objet            | ... |
| UX-P09 — Recommandations explicables | ✅ Conforme / ⚠️ Sans objet     | ... |
| UX-P10 — Logiciel effacé       | ✅ Conforme / ⚠️ Exception documentée §X | ... |
```

---

## Invariants protégés

| Invariant | Protégé par |
|---|---|
| Le logiciel s'adapte au métier, jamais l'inverse | UX-P01 — Soin au centre |
| Aucune décision clinique sans contexte | UX-P02 — Contexte avant action |
| Le coût cognitif de la navigation reste minimal | UX-P03 — Travail sans navigation |
| Le praticien sait immédiatement pourquoi il est dans cet espace | UX-P04 — Une intention par Workspace |
| Le passé clinique est unique et cohérent | UX-P05 — Timeline unique |
| La charge cognitive reste maîtrisée | UX-P06 — Information progressive |
| Le praticien peut évaluer la confiance qu'il accorde à une information | UX-P07 — Propriétaire visible |
| La coordination des soins reste explicite | UX-P08 — Collaboration visible |
| La confiance repose sur la transparence | UX-P09 — Recommandations explicables |
| L'expérience favorise la relation de soin | UX-P10 — Logiciel effacé |

---

## Références

| Document | Relation |
|---|---|
| CLAUDE.md | Mission — autorité supérieure |
| ADR-SA-000 | Constitution logicielle — même rang, domaine technique |
| UXP-001 | Principes UX cliniques — 26 principes empiriques subordonnés à UX-000 |
| WSP-001 | Workspace Definition — UX-P04 s'applique à chaque Workspace défini ici |
| ADR-0007 | Roles on Relations — fondement de UX-P07 (propriétaire visible) |
| ADR-0008 | Clinical Work & Knowledge — fondement de UX-P08 (collaboration visible) |
| CW-001 | Source empirique primaire — travail clinique observé |
