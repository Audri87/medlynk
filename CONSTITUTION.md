# The MedLink Constitution

*Une constitution philosophique — pas juridique.*

---

Ce texte ne décrit ni un logiciel, ni une architecture, ni une méthode. Il ne contient aucun
diagramme, aucun schéma technique, aucun vocabulaire d'ingénierie. Tout ce vocabulaire — Domain,
Bounded Context, CQRS, Platform Kernel, ADR, Workspace Blueprint — a sa place ailleurs, dans des
documents qui, eux, peuvent changer souvent. Ce texte est écrit pour rester lisible, et vrai, même
le jour où plus aucune ligne du code actuel n'existera.

Il tient volontairement en peu de pages. Un texte qu'on doit relire pour se souvenir de ce qu'il dit
n'est pas un texte qu'on a vraiment adopté.

---

## Préambule

MedLink n'existe pas pour numériser la santé.

MedLink existe parce qu'un soignant, face à un patient, dépense une part de son attention à
reconstruire ce qu'il devrait déjà savoir — plutôt que de la consacrer à comprendre, décider, et
être présent.

Ce n'est pas un problème de logiciel. C'est un problème de charge — la charge que porte une personne
qui doit reconstituer, seule, une histoire que d'autres connaissent déjà en partie.

Nous pensons que cette charge peut être réduite. Pas supprimée — la compréhension clinique restera
toujours un acte humain — mais réduite, pour que l'énergie qu'elle libère retourne au patient, et non
à la recherche d'information.

C'est le pourquoi. Tout le reste — le code, les modèles, les plateformes, les décisions
d'architecture — n'est qu'une tentative, actuelle et révisable, de servir ce pourquoi. Ce document
protège le pourquoi. Il ne protège rien d'autre.

---

## Article I

Le travail clinique précède le logiciel.

Le logiciel s'adapte au travail clinique.

Jamais l'inverse.

> *Un logiciel qui demande au praticien de changer sa façon de raisonner pour lui correspondre a déjà
> échoué, même s'il fonctionne parfaitement. La réussite technique ne rachète jamais une inversion de
> priorité.*

---

## Article II

Le noyau cognitif est l'invariant.

Les implémentations sont adaptatives.

> *Le noyau cognitif n'est pas une couche technique — ce n'est pas le Platform Kernel décrit ailleurs,
> qui est une décision d'architecture et peut être réécrit. Le noyau cognitif est ce que MedLink
> protège depuis le Préambule : la charge que porte un esprit humain pour comprendre une situation
> clinique. Une technologie change. La nature de cette charge ne change pas.*

---

## Article III

Toute décision architecturale doit pouvoir être reliée à une observation empirique.

> *Une idée qui semble juste n'est pas une preuve. Ce qui a été vu, entendu, ou rapporté par un
> praticien pèse plus qu'une intuition, aussi brillante soit-elle. Ce principe ne juge pas
> l'intelligence des idées — il juge leur origine.*

---

## Article IV

La stabilité est la position par défaut.

Toute évolution du noyau porte la charge de la preuve.

> *Ce n'est pas de l'immobilisme. C'est une asymétrie assumée : il est plus coûteux de changer le
> noyau à tort que de le laisser stable un peu trop longtemps. Le doute profite à ce qui existe déjà.*

---

## Article V

Les modèles sont révisables.

Les preuves décident.

Jamais les préférences.

> *Un modèle qui ne peut pas être révisé n'est pas une conviction — c'est un dogme. Mais le réviser
> se fait par la preuve qui le contredit, jamais par la lassitude, l'opinion, ou la nouveauté pour
> elle-même.*

---

## Article VI

Le logiciel n'est qu'une implémentation du noyau cognitif.

> *Il peut être remplacé, réécrit, migré, abandonné. Le noyau qu'il sert survit à chacune de ces
> décisions, ou alors la décision était mauvaise.*

---

## Article VII

Une IA n'est pas un décideur clinique.

Elle soutient les transitions cognitives.

> *Assister n'est pas décider. Une IA peut préparer, résumer, rappeler, mettre en évidence — elle ne
> franchit jamais la frontière qui la ferait juger à la place d'un soignant. Cette frontière ne se
> déplace pas parce que la technologie progresse.*

---

## Article VIII

Les Workspaces sont des expressions actuelles du noyau.

Ils peuvent évoluer.

Le noyau ne change qu'exceptionnellement.

> *Un Workspace qui disparaît demain n'affaiblit pas ce texte. Un noyau qui change tous les
> trimestres n'aurait jamais dû être appelé noyau.*

---

## Article IX

Les implémentations locales sont libres.

Elles respectent les invariants.

> *La liberté d'implémenter ne fonde aucun droit d'ignorer ce qui doit rester vrai partout où MedLink
> existe. La diversité des contextes cliniques ne dilue pas les invariants — elle les traverse.*

---

## Article X

Le projet privilégie toujours :

la simplicité ;

la traçabilité ;

la reproductibilité.

> *Face à un choix, ces trois critères l'emportent sur l'élégance, la performance, ou la rapidité de
> livraison — pas parce que ces dernières n'ont pas de valeur, mais parce qu'elles ne protègent rien
> par elles-mêmes.*

---

## Clôture

Ce texte n'est pas figé par orgueil.

Il est figé par respect pour ce que l'Article IV exige de tout changement : la charge de la preuve.

Le jour où un article de ce texte devra changer, ce jour mérite d'être un événement rare, documenté,
et justifié — jamais une conséquence accidentelle d'un projet qui a simplement continué d'avancer.

---

*The MedLink Constitution — première version, 2026-08-06.*
