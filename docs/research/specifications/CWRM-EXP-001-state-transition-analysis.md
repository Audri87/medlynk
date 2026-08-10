# CWRM-EXP-001 — State Transition Analysis

**Document ID :** CWRM-EXP-001
**Titre :** State Transition Analysis — Protocole expérimental
**Version :** 1.0
**Statut :** **Accepted (Experimental Protocol)** — non intégré au core CWRM

> **Distinction à ne jamais fondre en une seule ligne (ADR-0016/ADR-0017).** Ce document — le
> protocole lui-même — est `Accepted` : c'est une méthode explicite, reproductible, qui expose ses
> biais et ses conditions de réfutation, prête à être appliquée. **L'hypothèse qu'il teste** (§0 —
> transformation d'état vs action comme primitive) reste `Experimental` : accepter la méthode
> n'accepte pas sa conclusion. `Accepted` ici ne signifie pas non plus intégré au pipeline canonique
> CWRM — cette promotion suivrait le protocole d'évolution de CWRM-AF-001, non déclenché par ce
> verdict.
**Date :** 2026-08-06
**Depends on :** CWRM-000 (définitions ACT/OBS), CWRM-001 (ACT en tant qu'unité rapportée)
**N'est requis par :** rien — ce document ne fait partie d'aucune chaîne existante

---

## 0. Statut de ce document

Ce protocole existe pour tester une hypothèse, pas pour l'appliquer comme si elle était acquise :

> Les primitives cognitives du travail clinique sont peut-être plus correctement décrites comme des
> **transformations d'état** que comme des **actions**.

Cette hypothèse n'est pas acceptée. Ce document ne cherche pas à la démontrer. Il construit
uniquement l'instrument qui permettrait de la réfuter ou de la corroborer.

Conformément à CWRM-AF-001 (*"aucun nouveau concept fondamental n'est ajouté [au core] sans
justification empirique"*), ce protocole reste **hors du pipeline canonique** (ADR-0015, hors du
périmètre de ce document par ailleurs) tant qu'il n'a pas produit de résultat soumis au protocole
d'évolution. Il ne modifie aucune définition de CWRM-000/001/002. Il ne propose aucun Workspace. Il
est entièrement générique — applicable à n'importe quel corpus de verbatims professionnels, pas
seulement à celui de MedLink.

---

## 1. Contract

**Objectif.** Répondre à une seule question : *comment identifier une transformation d'état à partir
d'un corpus de verbatims ?*

**Entrées.** Un corpus d'ACT déjà extraits selon CWRM-001 (verbatim ou synthèse rapportée, avec
ancrage source).

**Sorties.** Une liste de candidats `TRANS-NNN`, chacun statué `Candidate` / `Stable` / `Merged` /
`Rejected`, avec pour chacun : objet, état avant, état après, evidence, confiance, contre-exemple
éventuel.

**Garanties.** Toute sortie `Stable` de ce protocole a survécu à une tentative de destruction
documentée (§7) et dispose d'une condition de réfutation explicite (§8).

**Non-garanties.** Ce protocole ne garantit pas que les transformations identifiées remplacent les
ACT. Ne garantit pas la validité de l'hypothèse énoncée en §0. Ne garantit pas l'exhaustivité d'un
corpus donné — seulement la reproductibilité de la méthode appliquée à ce corpus.

---

## 2. Qu'est-ce qu'une transformation ?

**Définition.** Une transformation d'état est un changement observable de la valeur d'une propriété
nommée d'un objet nommé, entre un moment avant et un moment après, evidencé par un ou plusieurs ACT.

Formellement, une transformation est un quadruplet minimal :

```
(Objet, État avant, État après, Evidence)
```

Une transformation n'est **pas** un verbe. Un verbe rapporté est un ACT (CWRM-001 §2). Un ACT peut
être la cause rapportée d'une transformation, sans être la transformation elle-même. La transformation
est l'effet inféré ; l'ACT est la source qui permet de l'inférer.

**Test minimal d'existence.** Une transformation candidate n'existe que si l'on peut répondre aux
deux questions suivantes séparément et différemment :
1. Qu'est-ce qui était vrai *avant*, pour cet objet précis ?
2. Qu'est-ce qui est vrai *après*, pour ce même objet ?

Si les deux réponses sont identiques, il n'y a pas de transformation — seulement une action sans
effet observable sur l'objet considéré (ce qui est possible et ne disqualifie pas l'ACT lui-même,
seulement la candidature à ce niveau d'analyse).

---

## 3. Distinguer action / transformation / mécanisme d'exécution / artefact

Ces quatre catégories sont fréquemment confondues. Chacune répond à une question différente.

| Catégorie | Question à laquelle elle répond | Définition | Test diagnostique |
|---|---|---|---|
| **Action (ACT)** | Qu'est-ce que le praticien rapporte avoir fait ? | Un verbe rapporté, unité déjà définie par CWRM-001 | L'énoncé est-il formulé comme un verbe à l'infinitif rapporté par le sujet ? |
| **Transformation** | Qu'est-ce qui a changé, pour quel objet ? | Le quadruplet (Objet, avant, après, evidence) | Peut-on répondre différemment aux deux questions du §2 ? |
| **Mécanisme d'exécution** | Comment le changement est-il obtenu ? | Le support, l'outil ou le canal utilisé — détail d'implémentation | L'énoncé décrit-il un support (papier, écran, téléphone) plutôt qu'un état ? Si oui, c'est un mécanisme, pas une transformation |
| **Artefact** | Quel objet persistant porte ou représente un état ? | Une chose qui existe dans le temps, indépendamment d'un acte précis | L'énoncé nomme-t-il une chose sans décrire de changement ? Si oui, c'est un artefact, pas une transformation |

**Piège fréquent.** Un artefact (« la note ») et l'objet réel d'une transformation (« l'état
mémoriel du praticien » ou « l'état structuré de la note elle-même ») sont souvent confondus parce
qu'ils sont causalement liés. Ce ne sont pas la même chose : l'existence de l'artefact ne prouve pas
à elle seule quel objet a changé d'état. Voir §4 pour la méthode de découverte de l'objet.

**Exemple travaillé.** *"Rechercher la dernière séance dans le dossier"* est un ACT (verbe rapporté).
Le mécanisme d'exécution est « consulter un dossier » (pourrait être papier ou numérique sans changer
la transformation). L'artefact est « le dossier ». La transformation candidate est : objet =
praticien, avant = absence de contexte sur la situation en cours, après = contexte reconstruit.

---

## 4. Quel est l'objet de la transformation ?

Ce protocole **ne fixe aucune liste fermée d'objets**. Il définit une méthode pour la découvrir.

### 4.1 Procédure de découverte (méthode ascendante)

1. Pour chaque transformation candidate, poser la question : *"qui ou quoi est différent après, et
   qui ou quoi ne l'est pas ?"*
2. Nommer l'objet avec le terme le plus spécifique qui n'emprunte à aucun vocabulaire déjà utilisé
   ailleurs dans le projet (pour éviter le biais de nommage rétroactif, §9).
3. Ajouter ce nom à un registre ouvert d'objets. Ne pas présupposer qu'un nom déjà utilisé doit
   convenir à une nouvelle transformation — vérifier à chaque fois.
4. **Critère de saturation.** Le registre d'objets est considéré provisoirement stable quand N
   transformations candidates consécutives (N ≥ 10, ou 20 % du corpus restant si inférieur) ne font
   émerger aucun nouvel objet. Ce n'est jamais une clôture définitive — un nouveau corpus peut rouvrir
   le registre.

### 4.2 Exemples d'objets déjà rencontrés (informatif, non normatif)

Ces catégories sont données à titre d'illustration du type de granularité attendu — elles ne sont ni
exhaustives ni prescriptives : praticien (état cognitif/mémoriel), artefact/dossier (état structurel),
tiers (état informationnel), plan de soins (état de décision), environnement (état de disponibilité
matérielle), système administratif (état de traitement).

Toute nouvelle application de ce protocole doit vérifier si ces catégories suffisent ou si le corpus
en révèle d'autres.

---

## 5. Grammaire de description

### 5.1 Format d'une entrée

```
TRANS-[NNN]
Objet          : [nom découvert selon §4]
État avant     : [description courte, non interprétative]
                        ↓
État après     : [description courte, non interprétative]
Evidence       : [liste d'ACT — au moins un verbatim direct si disponible, sinon marqué
                   SYNTHÈSE RAPPORTÉE]
Mécanisme(s)   : [optionnel — variantes d'exécution observées, utile pour §6]
Confiance      : [voir §5.2]
Contre-exemple : [ACT ou profil où la transformation attendue n'apparaît pas malgré un contexte
                   plausible — "Aucun identifié" est une réponse valide, "Non cherché" ne l'est pas]
Statut         : Candidate / Stable / Merged into [TRANS-NNN] / Rejected
```

### 5.2 Confiance

Ce protocole définit sa propre échelle, autonome de toute convention externe, pour rester
indépendant de tout document d'architecture :

| Niveau | Seuil |
|---|---|
| HIGH | ≥ 65 % des sources disponibles convergent, dont au moins une en verbatim direct |
| MEDIUM | 30 % à 65 %, ou 100 % mais uniquement en synthèse rapportée |
| LOW | < 30 %, ou une seule source |

**Règle.** L'énoncé d'une transformation sans confiance affichée n'est pas une entrée valide de ce
protocole.

### 5.3 Règle de non-interprétation

L'état avant et l'état après sont décrits dans les termes les plus proches possibles du verbatim
source. Aucun mot causal (*"donc"*, *"parce que"*, *"ce qui montre"*) n'apparaît dans ces deux champs
— l'interprétation, si nécessaire, va exclusivement dans un champ séparé, hors de la grammaire
normative.

---

## 6. Détecter que deux actions différentes produisent la même transformation

**Procédure.** Pour deux ACT distincts (verbes différents, contextes différents), extraire
séparément le triplet (objet, avant, après) de chacun.

**Règle de fusion.** Si les deux triplets sont identiques une fois le mécanisme d'exécution
neutralisé (remplacé par un espace réservé générique), les deux ACT sont des instances de la **même**
transformation, via des mécanismes différents. Le mécanisme devient une variante documentée
(§5.1 champ *Mécanisme(s)*), pas une transformation séparée.

**Test opérationnel.** Retirer le verbe et le support de chaque ACT. Si la phrase résiduelle
(*"[objet] passe de [avant] à [après]"*) reste vraie et identique pour les deux, fusionner.

---

## 7. Détecter qu'une même action produit plusieurs transformations

**Procédure.** Pour un ACT donné, tester séparément chaque objet du registre (§4) : *"cet objet
change-t-il d'état du fait de cet ACT précis ?"* Ne pas s'arrêter à la première réponse positive.

**Règle.** Si plus d'un objet montre un changement d'état distinct et non réductible l'un à l'autre,
l'ACT correspond à plusieurs transformations, une par objet.

**Piège à éviter — sur-segmentation.** Deux effets apparents sur des objets différents peuvent en
réalité être un seul effet vu sous deux angles (ex. « le tiers est informé » et « le praticien est
soulagé » peuvent être la même transformation informationnelle, pas deux). Avant de conclure à une
segmentation, tenter activement la fusion (§6) entre les deux candidats ; ne retenir la segmentation
que si la fusion échoue explicitement.

---

## 8. Quand une transformation devient candidate primitive stable

Une transformation passe de `Candidate` à `Stable` seulement si **toutes** les conditions suivantes
sont remplies :

1. Présente dans au moins **3 sources indépendantes** (profils, praticiens, ou entretiens distincts —
   jamais 3 occurrences dans une seule source).
2. Au moins une occurrence est un verbatim direct, pas uniquement une synthèse rapportée.
3. A survécu à au moins une tentative active de fusion avec une transformation adjacente (§6),
   documentée même si elle a échoué.
4. Dispose d'une condition de réfutation explicite et vérifiable (§9), même non encore observée.
5. Ne recouvre pas intégralement (même objet, même avant, même après) une transformation déjà
   `Stable` — sinon, fusion obligatoire, pas duplication.

Une transformation qui échoue sur un seul de ces cinq critères reste `Candidate` ou passe à
`Insufficient Evidence` — jamais promue par défaut.

---

## 9. Conditions de réfutation

Toute transformation, au moment de sa proposition, énonce au moins une observation qui, si elle
était trouvée dans le corpus, la réfuterait. Exemples de forme :

- *"Si une source produit [état après] sans qu'aucune instance de [état avant] n'ait jamais été
  rapportée pour cet objet, la transformation est réfutée."*
- *"Si deux sources indépendantes rapportent [état avant] → [état après] contraire sur le même
  objet, dans des conditions comparables, sans justification contextuelle documentée, la
  transformation est réfutée en l'état — elle devient une Tension au sens où ce terme est déjà
  défini ailleurs, pas une primitive stable."*

**Réfutation par désaccord inter-codeurs.** Si le protocole §11 ne peut pas atteindre le seuil de
reproductibilité fixé pour une transformation donnée, cette transformation est réfutée
*opérationnellement* — indépendamment de sa plausibilité apparente. Une transformation qui ne peut
pas être identifiée de façon fiable par deux personnes différentes n'est pas une primitive stable,
quelle que soit sa cohérence théorique.

---

## 10. Biais possibles

Liste de départ (fournie), complétée par les biais rencontrés en pratique lors de l'élaboration de
ce protocole :

1. **Confusion action / transformation** — traiter un verbe rapporté comme s'il était lui-même le
   changement d'état, sans vérifier le triplet (§2).
2. **Confusion transformation / objectif** — confondre ce qui a changé avec ce que le praticien
   cherchait à accomplir. Un objectif est une intention rapportée ; une transformation est un état
   constaté.
3. **Confusion état cognitif / état documentaire** — traiter le fait qu'un document existe comme
   preuve suffisante qu'un état cognitif a changé, ou l'inverse (voir §3, piège artefact/objet).
4. **Mélange de niveaux d'abstraction** — comparer une transformation très générale ("le contexte est
   reconstruit") à une transformation très spécifique ("la posologie est vérifiée") comme si elles
   étaient du même ordre, sans grille de granularité explicite.
5. **Biais de nommage rétroactif** — nommer une transformation d'après un concept déjà connu par
   l'analyste plutôt que la laisser émerger du corpus (§4.1, règle 2).
6. **Biais de complétude illusoire** — croire qu'une transformation est corroborée parce qu'elle
   apparaît plusieurs fois dans une seule source, alors que la corroboration exigée est
   inter-sources, pas intra-source (§8, condition 1).
7. **Biais de fusion prématurée** — fusionner deux candidats parce qu'ils semblent thématiquement
   proches, sans avoir réellement exécuté le test du triplet (§6).
8. **Biais de l'absence de verbatim** — traiter une source sans verbatim direct comme si elle
   confirmait l'absence d'une transformation, alors qu'elle peut seulement refléter une limite de
   collecte. Une source à traçabilité insuffisante doit être explicitement exclue, pas comptée comme
   contre-exemple.
9. **Biais de symétrie forcée** — supposer qu'une transformation de lecture doit avoir une
   transformation d'écriture miroir (ou l'inverse) par élégance théorique, sans preuve indépendante
   de chaque côté.
10. **Biais de l'objet implicite** — décrire un état avant/après sans jamais nommer explicitement
    l'objet concerné, rendant la transformation invérifiable et non falsifiable (§9).

---

## 11. Protocole de reproductibilité — deux reviewers indépendants

### 11.1 Procédure

1. **Indépendance stricte.** Les deux reviewers travaillent sur le même corpus, séparément, sans
   consultation ni partage de résultats intermédiaires.
2. **Phase d'extraction.** Chaque reviewer produit sa propre liste de `TRANS-NNN` selon la grammaire
   du §5, y compris son propre registre d'objets (§4) construit indépendamment.
3. **Phase de comparaison.** Les deux listes sont comparées **par contenu du triplet**
   (objet/avant/après), jamais par le nom donné à chaque transformation — deux reviewers peuvent
   nommer différemment la même transformation réelle.
4. **Métrique de recouvrement.** Proportion de triplets identifiés indépendamment par les deux
   reviewers, divisée par le nombre total de triplets distincts identifiés par l'un ou l'autre (union).
5. **Seuil proposé.** Recouvrement ≥ 70 % pour qu'un ensemble de transformations soit considéré
   reproductible à ce stade expérimental. En dessous, le protocole lui-même — pas seulement le
   résultat — est remis en question.
6. **Résolution de désaccord.** Un troisième reviewer arbitre chaque triplet en désaccord,
   exclusivement sur la base de l'evidence citée (§5.1) — jamais sur la plausibilité théorique de la
   transformation.
7. **Non-effacement du désaccord.** Tout désaccord non résolu par le troisième reviewer est conservé
   et documenté comme tel (statut `Contested`), jamais moyenné ou silencieusement tranché.

### 11.2 Ce que ce protocole ne permet pas de conclure

Un recouvrement élevé valide la reproductibilité de la méthode. Il ne valide pas l'hypothèse du §0.
Deux reviewers peuvent s'accorder de façon fiable sur des transformations d'état sans que cela
démontre que ces transformations sont de meilleures primitives que les actions — cette question reste
ouverte et sort du périmètre de ce protocole.

---

## 12. Out of Scope

Ce document ne définit pas :
- si les transformations remplacent, complètent, ou coexistent avec les ACT — question ouverte ;
- un nouveau Workspace ou une nouvelle Responsibility ;
- une modification de CWRM-000/001/002 ;
- une taxonomie fermée d'objets (§4) ;
- un critère d'intégration au pipeline canonique — celui-ci suit le protocole d'évolution de
  CWRM-AF-001, hors périmètre de ce document.

---

## Annexe (informative, non normative) — Application illustrative

Le cas d'étude qui a fait émerger ce protocole est documenté dans
[AR-001B — Empirical Audit of WS-005](../../AR-001B-empirical-audit-ws005.md). Neuf candidats y ont
été produits, dont six `Stable`, un `Merged`, un `Insufficient Evidence`, un `Unknown`. Le détail
(triplets, evidence, tentatives de fusion) n'est pas reproduit ici — cette annexe note seulement que
la grammaire du §5 et les tests des §6/§7 s'y sont révélés exécutables sans blocage méthodologique.
Ceci ne constitue pas une validation de l'hypothèse du §0, seulement une preuve que le protocole est
applicable.

**Note d'ordre.** Ce document (CWRM-EXP-001) a en réalité été rédigé *avant* AR-001B, alors que la
séquence méthodologiquement correcte est l'inverse — documenter le cas avant de généraliser. AR-001B
§0 le déclare explicitement plutôt que de laisser cette antériorité invisible.

---

## Historique

| Date | Version | Nature |
|---|---|---|
| 2026-08-06 | 0.1 | Draft initial — protocole expérimental, hors core CWRM, en réponse à l'hypothèse issue de l'analyse par transformations d'état |
| 2026-08-06 | 1.0 | **ACCEPT (Experimental)** — le protocole est jugé explicite, reproductible, exposant ses biais et ses conditions de réfutation. L'hypothèse testée (§0) reste Experimental et non validée par cette acceptation. |
