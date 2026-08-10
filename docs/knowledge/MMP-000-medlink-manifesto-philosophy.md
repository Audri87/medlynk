# MMP-000 — MedLink Manifesto & Philosophy

**Sous-titre :** A Knowledge-Centered Approach to Designing Clinical Information Systems

**Type :** Founding Document
**Statut :** v1.0
**Date :** 2026-07-30
**Autorité :** Ce document précède tous les autres.
Il n'est ni une spécification, ni un article scientifique, ni un livre blanc.
C'est la philosophie qui guide toutes les décisions.

---

---

## Préface

La médecine produit chaque jour davantage de connaissances, tandis que les systèmes d'information produisent chaque jour davantage de données. Entre les deux existe un écart : celui de la cognition clinique. MedLink est né de la conviction que cet écart ne peut être réduit ni par l'accumulation de fonctionnalités, ni par l'intelligence artificielle seule, mais par une modélisation explicite des mécanismes cognitifs qui sous-tendent le travail clinique. Notre objectif n'est pas seulement de construire un logiciel, mais de fournir un cadre de connaissance permettant de concevoir des systèmes numériques alignés avec la manière dont les professionnels de santé pensent, collaborent et prennent leurs décisions.

Ce document n'est pas une spécification. Il ne contient aucune décision technique. Il ne décrit aucune fonctionnalité.

C'est le texte qui précède tous les autres. Celui qu'on lit pour comprendre pourquoi tout le reste existe.

Il peut être lu indépendamment de toute connaissance de MedLink. Il peut être lu par un clinicien, un chercheur, un ingénieur ou un investisseur. Il peut être relu dans dix ans, et demeurer juste.

---

---

## Chapitre I — Le Problème

### Les logiciels de santé n'ont pas de problème de fonctionnalités

La plupart des systèmes d'information clinique disponibles aujourd'hui sont riches. Ils contiennent des centaines de fonctionnalités, des milliers de champs de saisie, des dizaines de modules. Ils intègrent des alertes, des rappels, des tableaux de bord, des indicateurs. Ils consomment des données médicales à grande échelle.

Et pourtant, les professionnels de santé sont fatigués.

Fatigués de chercher l'information dont ils ont besoin dans des interfaces conçues pour l'archivage plutôt que pour la pensée. Fatigués d'adapter leur raisonnement au modèle du logiciel plutôt que de laisser le logiciel s'adapter à leur raisonnement. Fatigués de documenter non pas pour penser, mais pour satisfaire des systèmes qui ne comprennent pas ce qu'ils documentent.

Ce n'est pas un problème de fonctionnalités manquantes. C'est un problème de modèle.

### La donnée n'est pas la connaissance

Les systèmes actuels ont été conçus autour d'une prémisse simple : si l'on collecte suffisamment de données et si l'on les organise correctement, les praticiens disposeront de tout ce dont ils ont besoin.

Cette prémisse est fausse.

Un professionnel de santé n'a pas besoin de données. Il a besoin de comprendre une situation — rapidement, avec confiance, dans le contexte de ce qui a changé depuis sa dernière intervention. Une donnée qui n'est pas intégrée dans ce processus de compréhension n'est pas une ressource. C'est une charge.

Les logiciels qui accumulent des données sans modéliser la cognition qui les utilise ne réduisent pas l'effort clinique. Ils le déplacent.

### L'intelligence artificielle ne résout pas ce problème seule

L'intelligence artificielle peut lire, analyser, synthétiser et recommander. Ces capacités sont réelles et précieuses. Mais une IA qui opère sur un système dont le modèle d'information est inadapté à la cognition clinique produit des résultats dans un contexte dysfonctionnel.

Améliorer les algorithmes sans améliorer le modèle, c'est optimiser la vitesse d'un train sur une mauvaise voie.

Le problème n'est pas computationnel. Il est conceptuel.

---

---

## Chapitre II — Notre Hypothèse

Il existe une hypothèse centrale à tout ce que nous faisons. Elle est simple à énoncer, difficile à opérationnaliser, et suffisamment fondamentale pour que toutes nos décisions en découlent.

> **Les systèmes d'information clinique deviennent plus utiles lorsqu'ils sont conçus à partir des mécanismes de la cognition clinique plutôt qu'à partir de la structure des données.**

Cette hypothèse change la question de départ.

La question habituelle est : *Quelles données devons-nous stocker ?* Elle mène naturellement à des bases de données, puis à des formulaires, puis à des interfaces pour remplir ces formulaires.

Notre question est différente : *Comment un professionnel de santé construit-il mentalement une représentation exploitable d'un patient ?* Elle mène à l'observation du travail clinique réel, à la modélisation des mécanismes cognitifs, et seulement ensuite à la conception d'interfaces qui servent ces mécanismes.

Ce renversement n'est pas cosmétique. Il change l'ordre de toutes les décisions.

Dans l'approche habituelle, la conception précède la compréhension. On construit, puis on observe les usages, puis on ajuste.

Dans notre approche, la compréhension précède toute conception. On observe, on modélise, on valide — et seulement à cette condition, on conçoit.

---

---

## Chapitre III — Une Autre Manière de Concevoir les Logiciels

### L'approche classique

La construction d'un logiciel suit généralement un chemin connu :

```
Données
    ↓
Base de données
    ↓
Fonctionnalités
    ↓
Interface
```

Ce chemin part de ce que l'on possède (des données) et demande ce que l'on peut en faire (des fonctionnalités). Il produit des systèmes techniquement corrects qui ne correspondent pas nécessairement à la façon dont les utilisateurs pensent.

À chaque étape de ce chemin, une partie de la compréhension du problème réel est perdue. La recherche clinique ne se traduit pas entièrement en spécifications. Les spécifications ne se traduisent pas entièrement en design. Le design ne se traduit pas entièrement en développement. Chaque transition perd quelque chose d'essentiel.

### L'approche MedLink

Notre chemin part d'une question différente : *Que se passe-t-il réellement lorsqu'un clinicien travaille ?*

```
Observation du travail clinique réel
    ↓
Connaissance — ce que nous apprenons
    ↓
Modélisation — comment nous l'organisons
    ↓
Exigences — ce que le système doit fournir
    ↓
Expérience — comment le système le fournit
    ↓
Logiciel — où cette expérience vit
```

Cette chaîne est continue. Chaque niveau justifie le suivant. Chaque niveau est traçable jusqu'au premier.

Sa propriété la plus importante n'est pas sa rigueur — c'est sa réversibilité. Si une observation de terrain remet en cause un niveau intermédiaire, la chaîne permet d'identifier précisément ce qui doit être révisé, et à quel niveau.

### La rupture que nous cherchons à éliminer

Dans l'approche classique, un designer prend des décisions d'interface qui ne sont pas traçables à des observations. Un développeur implémente des fonctionnalités dont personne ne peut démontrer l'utilité cognitive. Un investisseur finance des fonctionnalités qui répondent à des intuitions plutôt qu'à des preuves.

Dans notre approche, chaque décision — d'interface, de fonctionnalité, d'architecture — peut être remontée jusqu'à l'observation qui la justifie. Si cette remontée est impossible, la décision est suspecte.

Cette traçabilité est notre réponse à la perte d'information entre les étapes. Elle est, à notre sens, la véritable innovation de la méthode.

---

---

## Chapitre IV — Nos Dix Principes

Ces dix principes ne sont pas des règles. Ce sont des convictions. Ils résistent aux modes technologiques, aux évolutions des organisations et aux révisions successives du produit. Ils doivent être vrais dans dix ans comme ils le sont aujourd'hui.

---

**1. La cognition précède la donnée.**

Une donnée sans praticien pour l'interpréter n'a pas de signification clinique. Le premier objet à modéliser n'est pas la donnée — c'est la cognition qui lui donne du sens.

---

**2. La connaissance précède la fonctionnalité.**

Une fonctionnalité est une réponse. Avant de formuler une réponse, il faut comprendre la question. Construire une fonctionnalité sans savoir quel problème cognitif elle résout, c'est répondre à une question qu'on ne s'est pas posée.

---

**3. Toute interface est une hypothèse.**

Chaque décision de design affirme implicitement quelque chose sur la façon dont les cliniciens pensent. Cette affirmation peut être juste ou fausse. Si elle n'est pas formulée explicitement, elle ne peut pas être testée. Et ce qui ne peut pas être testé ne peut pas être amélioré.

---

**4. Toute hypothèse doit pouvoir être réfutée.**

Un principe qui ne peut pas être contredit n'est pas un principe — c'est une opinion. Nous exigeons que chaque affirmation sur la cognition clinique soit formulée de façon à pouvoir être invalidée par une observation contraire. C'est la condition minimale de la rigueur scientifique.

---

**5. La simplicité est un résultat, jamais un point de départ.**

Simplifier sans comprendre, c'est appauvrir. La simplicité d'une interface résulte d'une compréhension profonde de ce qui est nécessaire et de ce qui ne l'est pas. Elle ne peut pas être imposée a priori — elle doit être gagnée par la connaissance.

---

**6. Les professionnels ne doivent pas apprendre le logiciel. Le logiciel doit apprendre leur manière de travailler.**

Si un professionnel de santé doit adapter son raisonnement clinique pour utiliser un logiciel, c'est le logiciel qui est en défaut. La formation à l'outil est l'aveu que le modèle est inadapté.

---

**7. Les modèles doivent être explicites avant d'être implémentés.**

Un modèle implicite est un modèle que personne ne peut remettre en cause, améliorer ou transmettre. Rendre les modèles explicites — écrits, versionnés, discutés — est une condition de leur amélioration continue et de leur survie dans le temps.

---

**8. Les preuves priment sur les intuitions.**

Une intuition de designer peut être juste. Elle peut aussi être le reflet de biais non examinés. La seule façon de distinguer l'une de l'autre est l'évidence : observations terrain, tests utilisateurs, expériences contrôlées. Nos décisions préfèrent les preuves aux intuitions, même lorsque les preuves sont inconfortables.

---

**9. Les systèmes doivent pouvoir expliquer leurs décisions.**

Toute décision de conception — pourquoi cet écran, pourquoi cet ordre, pourquoi cette information visible et pas une autre — doit avoir une réponse articulable. Un système dont les décisions ne peuvent pas être expliquées est un système dont les erreurs ne peuvent pas être corrigées.

---

**10. La confiance se construit par la transparence.**

Les cliniciens font confiance aux systèmes qui leur montrent la source de chaque information, l'heure à laquelle elle a été produite, et par qui. La confiance n'est pas un sentiment — c'est une conclusion rationnelle fondée sur la traçabilité. Un système opaque ne mérite pas la confiance clinique.

---

---

## Chapitre V — Les Quatre Couches

Toute la méthode MedLink peut être résumée en quatre couches, dans un ordre précis.

```
Observer
    ↓
Comprendre
    ↓
Formaliser
    ↓
Concevoir
    ↓
Développer
```

Le développement arrive en dernier.

Ce n'est pas un détail d'organisation. C'est une déclaration philosophique.

**Observer**, c'est aller là où le travail clinique se produit réellement — pas dans les réunions de projet, pas dans les cahiers des charges, pas dans les démos de produits concurrents. C'est écouter les praticiens décrire leur travail, sans projeter nos propres modèles mentaux.

**Comprendre**, c'est identifier ce qui est constant dans cette diversité d'observations. Pas ce que les praticiens disent vouloir, mais ce que leurs comportements révèlent sur la structure de leur cognition. C'est le travail le plus difficile — et le plus important.

**Formaliser**, c'est rendre la compréhension explicite. Écrire les invariants. Définir les relations. Articuler les contraintes. Un modèle non formalisé reste personnel et périssable. Un modèle formalisé peut être discuté, réfuté, amélioré et transmis.

**Concevoir**, c'est traduire le modèle formalisé en décisions d'interface. Chaque décision de design est traçable à un requirement, chaque requirement à un besoin cognitif, chaque besoin à un invariant, chaque invariant à une observation. Si cette chaîne est rompue, la décision est une intuition.

Et enfin, seulement, **développer**. L'implémentation est la concrétisation du modèle — pas sa définition.

---

---

## Chapitre VI — Pourquoi une Ontologie ?

Le mot "ontologie" appartient à la philosophie et à l'informatique formelle. Nous l'empruntons pour une raison simple : nous avons besoin d'un mot pour désigner quelque chose que les autres mots ne capturent pas.

Une ontologie, dans notre sens, c'est la réponse à trois questions :

*Quels objets de connaissance existent dans ce domaine ?* Un invariant cognitif n'est pas la même chose qu'un requirement système. Un profil clinique n'est pas la même chose qu'un épisode d'activité. Si ces distinctions ne sont pas nommées, elles sont ignorées.

*Comment ces objets sont-ils reliés ?* Une observation soutient un invariant, qui implique un besoin cognitif, qui dérive un requirement, qui est implémenté par un principe de design. Si ces relations ne sont pas typées, n'importe quoi peut justifier n'importe quoi.

*Quelles conclusions peuvent être tirées automatiquement ?* Si un invariant est réfuté, tous les requirements qui en dépendent doivent être révisés. Si un besoin cognitif n'a pas de requirement associé, il n'existe pas dans le produit. Ces inférences ne sont pas des opinions — elles sont des conséquences logiques.

Sans ontologie, un système de connaissance reste une collection de documents. Des documents sont lus, oubliés, contredits, perdus. Une ontologie est un graphe : elle est traversable, vérifiable, et évolutive sans perte de cohérence.

Nous avons construit une ontologie parce que nous voulons que notre connaissance survive à ses auteurs, à ses technologies, et à ses premières formulations imparfaites.

---

---

## Chapitre VII — Pourquoi une Gouvernance ?

La connaissance change. C'est sa nature. Ce que nous savons de la cognition clinique aujourd'hui est différent de ce que nous saurons dans cinq ans, après davantage d'observations, d'expériences et de discussions critiques.

Si la connaissance change sans règles, elle se dégrade. Les affirmations les plus récentes remplacent les plus anciennes sans examen. Les opinions les plus fortes remplacent les preuves les plus solides. Les urgences du moment écrasent les fondements construits sur des années.

La gouvernance scientifique est la réponse à ce risque. Elle définit :

*Comment un invariant est renforcé* — par l'accumulation d'observations convergentes.

*Comment un invariant est nuancé* — par la découverte de son domaine d'application limité.

*Comment un invariant est suspendu* — quand des observations contradictoires apparaissent sans résolution possible.

*Comment un invariant est r��futé* — par une évidence suffisante et documentée.

Ces quatre opérations ne sont pas arbitraires. Elles suivent des règles définies à l'avance, indépendamment de tout contexte de projet ou de toute pression commerciale.

La gouvernance ne ralentit pas l'évolution de la connaissance. Elle la rend fiable.

Un modèle sans gouvernance peut être révisé à volonté. C'est une faiblesse, pas une flexibilité.

---

---

## Chapitre VIII — Pourquoi MedLink n'est pas un Logiciel

Cette affirmation surprend. Elle doit surprendre.

MedLink est un programme, une interface, une base de données, un ensemble de services. En ce sens, c'est bien un logiciel. Mais réduire MedLink à ces composants techniques, c'est confondre l'implémentation avec ce qu'elle implémente.

MedLink est, en premier lieu, **un modèle scientifique** — une description formelle de la façon dont les professionnels de santé construisent, utilisent et transmettent leur raisonnement clinique. Ce modèle a été élaboré à partir d'observations terrain, validé par la littérature scientifique, et formalisé dans un système de connaissance explicite.

MedLink est, en second lieu, **une méthode de conception** — un ensemble de principes et de processus permettant de traduire un modèle de la cognition clinique en décisions d'interface. Cette méthode peut être appliquée à n'importe quel logiciel clinique, indépendamment de la technologie choisie.

MedLink est, en troisième lieu, **une architecture de connaissance** — un graphe d'objets reliés par des relations typées, gouverné par des contraintes formelles, capable de propager automatiquement les impacts des révisions du modèle sur toutes les décisions qui en dépendent.

Le logiciel, lui, est une implémentation de ces trois éléments. Il peut changer de technologie. Il peut changer d'interface. Il peut être remplacé. Ce qui ne change pas — ce qui doit ne pas changer — c'est la compréhension de la cognition clinique qui le fonde.

C'est cette distinction qui garantit la durabilité. Les technologies ont une durée de vie de quelques années. Les modèles de connaissance bien construits ont une durée de vie de plusieurs décennies.

---

---

## Chapitre IX — Ce que Nous Refusons

Un manifeste dit ce qu'il croit. Il doit aussi dire ce qu'il refuse.

**Nous ne croyons pas qu'un dossier médical soit une suite de formulaires.**
Un dossier médical est la mémoire externe d'un réseau de praticiens. Il sert à reconstruire une situation clinique, à identifier ce qui a changé, à calibrer la confiance dans les informations accumulées. Le réduire à des champs de saisie, c'est en méconnaître la fonction cognitive.

**Nous ne croyons pas que davantage de données produise automatiquement davantage de connaissance.**
La connaissance clinique n'est pas le produit de l'accumulation. C'est le résultat d'un raisonnement exercé par un professionnel formé, sur des informations pertinentes, dans un contexte compris. Sans ce raisonnement, les données sont du bruit.

**Nous ne croyons pas que l'intelligence artificielle remplace la compréhension clinique.**
L'IA peut détecter, synthétiser, recommander. Elle ne peut pas assumer la responsabilité d'une décision médicale. Et un outil d'IA construit sur un mauvais modèle cognitif produira des erreurs difficiles à détecter précisément parce que le modèle sous-jacent n'est pas explicite.

**Nous ne croyons pas qu'une bonne interface puisse compenser un mauvais modèle.**
Une interface est la traduction d'un modèle. Si le modèle est faux — s'il ne correspond pas à la façon dont les cliniciens pensent — aucune qualité d'exécution visuelle ne réparera cet écart fondamental.

**Nous ne croyons pas que la formation des utilisateurs soit une réponse acceptable.**
Si un professionnel de santé doit apprendre à utiliser un logiciel, c'est que le logiciel n'a pas appris à servir son travail. La formation est parfois nécessaire — mais elle ne peut pas être la solution au problème de conception.

**Nous ne croyons pas que la vitesse de développement soit une valeur en soi.**
Développer vite une mauvaise solution ne produit pas une bonne solution. Comprendre d'abord, concevoir ensuite, développer en dernier — même si cela prend plus de temps au début, cette séquence produit des résultats plus durables.

---

---

## Chapitre X — Ce que Nous Voulons Construire

Pas seulement MedLink.

MedLink est une première implémentation. C'est la preuve que la méthode fonctionne — que l'on peut observer la cognition clinique, la modéliser rigoureusement, et en dériver un système d'information qui sert réellement le travail des praticiens.

Mais l'ambition est plus large.

Nous voulons construire un modèle de connaissance suffisamment robuste pour que plusieurs logiciels puissent en être des implémentations fidèles. Aujourd'hui, ce modèle fonde MedLink. Demain, il pourrait fonder d'autres systèmes — dans d'autres pays, d'autres spécialités, d'autres contextes de soin — qui partageraient les mêmes invariants cognitifs et les appliqueraient différemment.

Nous voulons établir une discipline : l'ingénierie de la connaissance clinique. Une façon rigoureuse de passer des observations du travail clinique à des systèmes d'information qui servent ce travail. Une méthode qui peut être enseignée, critiquée, améliorée et appliquée par d'autres équipes que la nôtre.

Nous voulons que les logiciels de santé soient conçus différemment — pas parce que nous l'affirmons, mais parce que nous le démontrons. Chaque décision de MedLink traçable jusqu'à une observation est une démonstration que l'alternative existe.

Ce n'est pas une ambition de marché. C'est une ambition de méthode.

---

---

## Chapitre XI — Dans Vingt Ans

Nous n'espérons pas que MedLink soit dominant dans vingt ans. Les marchés changent. Les technologies changent. Les organisations changent.

Ce que nous espérons est différent.

Nous espérons que, dans vingt ans, la question que se posent les équipes qui conçoivent des logiciels cliniques ne sera plus :

*Quel logiciel utilisez-vous ?*

Mais :

*Quel modèle de cognition clinique fonde votre système ?*

Ce déplacement — de la question technologique à la question cognitive — est le signal que quelque chose a changé en profondeur dans la façon dont l'industrie comprend son rôle.

Nous espérons que les invariants cognitifs identifiés dans notre corpus de 2026 auront été confirmés, nuancés, étendus et parfois réfutés par des dizaines d'études menées par d'autres équipes. C'est le signe qu'ils étaient suffisamment rigoureux pour mériter d'être testés.

Nous espérons que le modèle de connaissance de MedLink aura été utilisé, critiqué et amélioré par des équipes que nous ne connaissons pas encore — et que ces améliorations auront rendu le modèle plus vrai, pas simplement plus grand.

Nous espérons que les praticiens qui travailleront dans vingt ans avec des systèmes d'information clinique n'auront pas à penser à ces systèmes — qu'ils pourront consacrer leur énergie au raisonnement, à la décision, et à la relation avec leurs patients.

Ce serait la confirmation que l'hypothèse du Chapitre II était juste.

---

---

## Épilogue

Les logiciels changent.
Les technologies changent.
Les modèles évoluent.

Mais comprendre comment les cliniciens pensent restera toujours le fondement des systèmes qui les accompagnent.

---

---

*Version 1.0 — 2026-07-30*
*Ce document est vivant. Il sera révisé lorsque la philosophie elle-même évolue — pas à chaque évolution du produit.*
*Il ne doit pas contenir de références technologiques, de décisions produit, ou de détails d'implémentation.*
*Si une révision introduit de tels éléments, elle est rejetée.*
