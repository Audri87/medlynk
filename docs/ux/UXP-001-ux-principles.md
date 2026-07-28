# UXP-001 — Principes UX de MedLink

**Version :** 1.0
**Statut :** Accepted
**Date :** 2026-07-28
**Sources primaires :** CW-001 v2.0 · Domain Atlas V1
**Sources secondaires :** M-003 · P-001 · FOUNDATIONS.md

---

## Préambule

### D'où viennent ces principes

Ces principes ne viennent pas de préférences de design.

Ils viennent de l'observation du travail clinique réel tel que décrit dans CW-001 — *Reprendre un patient*.

CW-001 décrit ce que les professionnels font effectivement lorsqu'ils reprennent un patient : dans quel ordre ils cherchent l'information, ce qu'ils lisent, ce qu'ils ignorent, comment ils construisent leur compréhension, où ils perdent du temps, où les erreurs se concentrent.

Chaque principe UX de ce document est la traduction directe d'une observation ou d'une hypothèse de CW-001 en exigence de conception.

### Ce que ce document n'est pas

Ce document ne dessine aucun écran.

Il ne décrit pas d'interactions.

Il ne prescrit pas de composants, de couleurs, de typographies, ou d'organisations visuelles.

Il établit les **contraintes cognitives** auxquelles toute interface de MedLink doit répondre. Le design est l'acte de trouver une forme qui respecte ces contraintes. Il commence après ce document.

### La règle de gouvernance

> Aucune décision d'interface ne peut contredire un principe de ce document sans déclencher une révision du principe.
>
> La charge de la preuve appartient toujours à l'interface : elle doit justifier pourquoi elle satisfait le besoin cognitif autrement.

---

## Partie I — Principes cognitifs

Ces principes décrivent la structure fondamentale de l'acte cognitif de reprise. Ils s'appliquent à tout contexte d'usage.

---

### UXP-01 — La reprise est une reconstruction, pas une lecture

**Source CW-001 :** §1.1 — "un travail cognitif actif, orienté vers un objectif : former une représentation suffisante de la situation du patient pour agir"

**Concept Domain Atlas :** §12 — Reprise de Contexte · §13 — Modèle de Situation

Le professionnel ne lit pas le dossier. Il construit un Modèle de Situation. Ces deux actes sont fondamentalement différents : la lecture est passive et séquentielle, la construction est active, sélective, et orientée vers un but.

Une interface conçue pour la lecture (scroll, pagination, chronologie brute) répond au mauvais acte cognitif.

**Ce que ce principe exige :** Chaque vue doit répondre à une question cognitive précise, pas exposer une collection de documents. L'accès à l'information est gouverné par l'utilité pour la construction du modèle, non par l'ordre de création ou de stockage.

**Ce que ce principe interdit :** Présenter le Parcours de Soins comme une liste chronologique à faire défiler de haut en bas. Forcer le professionnel à lire pour trouver — plutôt que de lui donner ce qu'il cherche.

---

### UXP-02 — Le professionnel arrive avec un prior

**Source CW-001 :** §2.1 — quatre configurations initiales : reprise courte, longue, inconnu, relève. "Ces configurations ne sont pas équivalentes en termes de charge cognitive."

**Concept Domain Atlas :** §2 — Professionnel de Santé (transitoire, perspectival)

La relation d'un professionnel avec un patient n'est jamais vierge. Elle est déterminée par leur histoire commune — ou son absence. Cette relation initiale conditionne la profondeur de lecture nécessaire, le seuil de suffisance acceptable, et le type d'information recherché en priorité.

**Ce que ce principe exige :** L'interface doit pouvoir adapter ce qu'elle présente en premier selon la relation du professionnel avec le patient. La reprise d'un inconnu n'est pas le même acte que la reprise d'un patient vu il y a 48 heures.

**Ce que ce principe interdit :** Présenter une vue identique à tous les professionnels, quel que soit leur niveau de familiarité avec le patient. L'interface uniforme est une interface qui ignore le contexte cognitif de l'utilisateur.

---

### UXP-03 — L'expertise se manifeste dans le cadrage initial

**Source CW-001 :** §3.2 — "Les professionnels expérimentés construisent des cadres initiaux plus riches et plus fiables que les professionnels juniors à partir du même volume d'informations de surface."

**Concept Domain Atlas :** §15 — Perspective (déterminée par l'expertise et la spécialité)

Le cadrage initial — la représentation schématique formée avant lecture approfondie — est d'autant plus fiable que le professionnel est expérimenté. Mais ce cadrage s'appuie sur des informations de surface disponibles avant que la reprise commence.

Un système qui enrichit ces informations de surface enrichit le cadrage initial de tous les professionnels, expérimentés ou non.

**Ce que ce principe exige :** Les informations de surface (motif, profil clinique essentiel, date du dernier contact) doivent être immédiatement accessibles, sans lecture préalable. Elles permettent au professionnel de construire son cadre initial avant d'entrer dans le détail.

**Ce que ce principe interdit :** Enterrer les informations de surface dans le corps du dossier. Exiger de lire pour avoir une idée générale de la situation.

---

### UXP-04 — La compréhension prend la forme d'une narration

**Source CW-001 :** §5.2 — "Les professionnels utilisent fréquemment le registre narratif... La construction du modèle de situation prend la forme d'une narration."

**Concept Domain Atlas :** §6 — Raisonnement Clinique (explication, pas liste de faits)

Le professionnel ne construit pas une base de données mentale du patient. Il construit une *histoire* — cohérente, orientée, simplifiée. Cette histoire est la forme que prend la compréhension pour devenir utilisable.

Un dossier présenté comme une liste de faits sans connexion causale ne supporte pas la construction narrative. Il la contraint.

**Ce que ce principe exige :** L'information doit être organisable en flux causal : ce qui a conduit à quoi, pourquoi, avec quel résultat. Le Raisonnement Clinique d'une Contribution est la brique de cette narration — et la plus précieuse.

**Ce que ce principe interdit :** Présenter les faits cliniques en liste plate, sans connexion entre eux. Décomposer artificiellement ce qui appartient à une même séquence causale.

---

### UXP-05 — L'incertitude est un résultat cognitif, pas un échec

**Source CW-001 :** §6.2 — "Un professionnel en reprise n'arrive jamais à zéro incertitude. Il atteint un seuil — un point au-delà duquel l'incertitude résiduelle lui semble acceptable pour l'action engagée."

**Concept Domain Atlas :** §8 — Incertitude Clinique · §14 — Lacune

L'incertitude résiduelle à la clôture de la reprise n'est pas un défaut de compréhension. C'est un état normal et légitime. La question n'est pas "est-ce que le professionnel a compris ?" mais "est-ce que son niveau d'incertitude est calibré avec le risque de l'action qu'il s'apprête à engager ?"

Un système qui masque l'incertitude (en la noyant dans des données, ou en ne la rendant pas visible) ne supprime pas l'incertitude — il la rend invisible et donc non gérable.

**Ce que ce principe exige :** Les Incertitudes Cliniques explicitement documentées par le professionnel précédent doivent être visibles et accessibles rapidement. Une Lacune identifiée (information attendue et absente) doit être signalée, pas dissimulée.

**Ce que ce principe interdit :** Présenter le dossier comme complet lorsqu'il est lacunaire. Optimiser l'interface pour une fausse apparence de complétude.

---

### UXP-06 — Les biais cognitifs se concentrent à trois moments précis

**Source CW-001 :** §11.2 — "Les erreurs liées à la reprise de contexte se concentrent sur trois moments : la formulation du cadre initial, l'identification des lacunes, et la clôture."

**Concept Domain Atlas :** §14 — Lacune · §12 — Reprise de Contexte

Les biais d'ancrage, de disponibilité, et de confirmation sont particulièrement actifs lors de la reprise de contexte. Ils ne sont pas liés à l'incompétence — ils sont activés par des conditions structurelles : information incomplète, temps limité, cadre initial formé rapidement.

L'interface peut atténuer ces biais en structurant l'information de façon à éviter que le cadre initial soit indûment ancré sur l'élément le plus récent ou le plus saillant.

**Ce que ce principe exige :** La présentation de l'information doit contrebalancer les effets de recency et de sailance. Ce qui est cliniquement important doit être visible — pas seulement ce qui est récent.

**Ce que ce principe interdit :** Amplifier les biais existants en accordant systématiquement une visibilité maximale aux entrées les plus récentes, quelle que soit leur importance clinique.

---

## Partie II — La reprise de contexte

Ces principes suivent les six phases de la reprise de contexte identifiées dans CW-001. Chaque phase génère une exigence d'interface distincte.

---

### UXP-07 — Phase 1 : La première question doit avoir une réponse immédiate

**Source CW-001 :** §3.1 — "Avant de lire quoi que ce soit, le professionnel formule implicitement une première question : Qui est ce patient, et pourquoi est-il là maintenant ?"

**Concept Domain Atlas :** §5 — Situation Clinique (état actuel perçu)

La réponse à cette première question oriente toute la reprise : l'urgence du temps, la profondeur de la lecture, le focus de l'attention. Si le système ne peut pas répondre à cette question en quelques secondes, il ralentit la reprise dès son premier instant.

**Ce que ce principe exige :** L'interface de reprise doit pouvoir répondre à "qui est ce patient, et pourquoi est-il là maintenant ?" sans que le professionnel ait à lire quoi que ce soit. Deux informations suffisent et sont nécessaires : l'identité clinique essentielle (pas administrative) et le motif actuel de prise en charge.

**Ce que ce principe interdit :** Commencer la reprise par un écran de bienvenue, un chargement, ou une page d'accueil qui ne répond pas à cette première question. Cacher le motif de prise en charge dans les détails du dossier.

---

### UXP-08 — Phase 2 : La lecture sélective est la norme, pas l'exception

**Source CW-001 :** §4.1 — "Un professionnel qui reprend un patient ne lit pas le dossier intégralement. Il le parcourt sélectivement, guidé par des stratégies implicites."

**Concept Domain Atlas :** §12 — Reprise de Contexte (acte cognitif actif)

La sélectivité n'est pas un défaut de pratique. C'est une adaptation rationnelle à une contrainte réelle. Un professionnel qui lirait tout ne serait pas plus compétent — il serait épuisé avant d'avoir vu son patient.

Une interface qui rend difficile la lecture sélective — par exemple en présentant tout de façon équivalente — travaille contre le professionnel, pas avec lui.

**Ce que ce principe exige :** L'interface doit permettre l'accès direct à chaque type d'information sans parcourir l'ensemble. Le professionnel qui cherche les Incertitudes actives doit pouvoir y accéder directement. Le professionnel qui cherche les Intentions en cours également.

**Ce que ce principe interdit :** La navigation séquentielle obligatoire. L'absence de distinction entre types d'information dans la présentation. Forcer le professionnel à tout voir pour trouver ce qui lui importe.

---

### UXP-09 — Phase 3 : Le modèle a quatre dimensions — pas une seule

**Source CW-001 :** §5.1 — "Le modèle comporte quatre dimensions : l'état actuel, la trajectoire, les incertitudes, les intentions."

**Concept Domain Atlas :** §3 — Compréhension Clinique (Situation · Raisonnement · Incertitudes · Intentions)

Le modèle de situation que le professionnel construit a exactement quatre dimensions. Ces quatre dimensions correspondent aux quatre composantes de la Compréhension Clinique (Domain Atlas §3). Ce n'est pas une coïncidence : elles décrivent le même acte cognitif vu de deux angles différents.

Une interface qui présente seulement l'état actuel — sans trajectoire, sans incertitudes, sans intentions — ne supporte qu'un quart du modèle. Le professionnel doit construire les trois autres quarts seul, depuis des données brutes.

**Ce que ce principe exige :** La restitution d'une Contribution Clinique doit permettre d'accéder distinctement à chacune des quatre dimensions : état perçu (Situation Clinique), explication (Raisonnement Clinique), questions ouvertes (Incertitudes), actions prévues (Intentions). Chaque dimension a une utilité cognitive propre et un moment d'usage dans la reprise.

**Ce que ce principe interdit :** Présenter la Contribution Clinique comme un bloc de texte non structuré. Mélanger dans un même espace les faits (état), les raisonnements (explication), les doutes (incertitudes), et les décisions (intentions).

---

### UXP-10 — Phase 4 : Les lacunes ne sont pas pré-identifiables

**Source CW-001 :** §6.1 — "Au fur et à mesure que le modèle de situation se construit, ses lacunes deviennent visibles. Le professionnel prend conscience de ce qu'il ne sait pas — et qu'il devrait savoir."

**Concept Domain Atlas :** §14 — Lacune (vide identifié, délimité, conscient)

Les Lacunes émergent de la construction du modèle — elles ne précèdent pas la lecture. On ne peut pas dresser la liste des lacunes sans d'abord avoir suffisamment construit le modèle pour constater ce qui manque.

Une interface qui demande au professionnel d'identifier ses besoins avant de commencer la reprise anticipe un processus qui, par nature, ne peut se dérouler que dans cet ordre.

**Ce que ce principe exige :** L'interface doit permettre l'identification progressive des Lacunes au fil de la construction du modèle — pas en amont. Elle doit permettre de signaler une Lacune dès qu'elle est identifiée, sans interrompre la reprise pour autant.

**Ce que ce principe interdit :** Exiger que le professionnel déclare ses besoins avant de consulter l'information. Présenter un formulaire "que cherchez-vous ?" comme porte d'entrée de la reprise.

---

### UXP-11 — Phase 5 : La priorisation est cognitivement biaisée par la sailance

**Source CW-001 :** §7.2 — "Un problème récemment introduit dans le modèle est souvent surpondéré. Un problème clairement défini est souvent traité avant un problème important mais ambigu."

**Concept Domain Atlas :** §9 — Intention Clinique (actionnelle, décidée) · §8 — Incertitude Clinique

Les biais de récence et de sailance dans la priorisation ne sont pas des erreurs du professionnel — ce sont des propriétés structurelles de la cognition sous contrainte. Un système qui les amplifie produit des priorisations sous-optimales. Un système qui les contrebalance aide le professionnel à décider.

**Ce que ce principe exige :** La hiérarchisation de l'information doit être gouvernée par la criticité clinique — non par la date, non par la taille du document, non par l'ordre de saisie. La criticité clinique est une propriété déclarée explicitement dans la Contribution Clinique (Intention Clinique, Incertitude Clinique) — elle doit se refléter dans la présentation.

**Ce que ce principe interdit :** Trier l'information automatiquement par date décroissante sans autre critère. Accorder la même visibilité à une Intention urgente et à un antécédent stable.

---

### UXP-12 — Phase 6 : La clôture prématurée est le risque principal

**Source CW-001 :** §8.2 — "La clôture prématurée — décider d'agir avant d'avoir construit un modèle suffisamment fiable — est l'un des risques les plus documentés de la reprise de contexte."

**Concept Domain Atlas :** UL-001 — Seuil de suffisance

La clôture prématurée est amplifiée par quatre conditions : pression temporelle, cohérence trompeuse du modèle initial, fatigue, et pauvreté en synthèses interprétatives. L'interface peut agir sur la quatrième condition — elle ne contrôle pas les trois premières.

**Ce que ce principe exige :** L'interface doit rendre visibles les Incertitudes Cliniques non résolues au moment où le professionnel s'apprête à agir. Une Lacune connue ne doit pas pouvoir être ignorée silencieusement. Il ne s'agit pas d'une interruption — mais d'une confirmation que le professionnel a vu ce qu'il doit voir.

**Ce que ce principe interdit :** Laisser le professionnel passer à l'action sans qu'aucune des Lacunes ou Incertitudes explicitement documentées ne soit signalée. Dissimuler la pauvreté du modèle sous une présentation visuellement soignée.

---

## Partie III — La charge mentale

Ces principes concernent le coût cognitif total de la reprise et comment l'interface peut le réduire sans sacrifier la qualité du modèle construit.

---

### UXP-13 — La reprise est elle-même un travail, avant toute action clinique

**Source CW-001 :** §1.1 — "Il s'agit d'un travail cognitif actif, orienté vers un objectif."

**Concept Domain Atlas :** §12 — Reprise de Contexte (acte cognitif — pas une consultation passive)

La reprise de contexte précède la consultation — elle n'en fait pas partie. C'est un travail à part entière, avec son propre coût cognitif, ses propres risques d'erreur, ses propres stratégies.

Chaque seconde supplémentaire dépensée dans la reprise est une seconde de moins disponible pour le raisonnement clinique et la relation avec le patient. L'interface qui rend la reprise lente ne nuit pas seulement à l'efficacité — elle nuit à la qualité des soins.

**Ce que ce principe exige :** Mesurer la charge cognitive imposée par chaque vue de reprise. Le critère de qualité d'une interface de reprise est le temps nécessaire pour construire un modèle de situation fiable — pas la complétude des informations affichées.

**Ce que ce principe interdit :** Optimiser pour l'exhaustivité de l'information affichée plutôt que pour la vitesse et la fiabilité de la construction du modèle. Ajouter des informations "au cas où" sans mesurer leur coût cognitif.

---

### UXP-14 — La reprise d'inconnu est le cas de référence

**Source CW-001 :** §2.1 — "La reprise d'inconnu est la plus coûteuse. Elle est la configuration de référence pour concevoir un système de reprise."

**Concept Domain Atlas :** §11 — Transition (crée un vide de compréhension)

La reprise d'un patient inconnu est la situation la plus coûteuse cognitivement — et aussi la plus risquée. Si le système peut soutenir cette reprise de façon satisfaisante, il soutiendra toutes les autres configurations de façon excellente.

Concevoir pour le cas de reprise courte (patient récemment vu) est concevoir pour le cas le plus facile. Ce n'est pas une bonne base.

**Ce que ce principe exige :** Toute décision de conception d'interface de reprise doit être testée contre le cas de la reprise d'inconnu. La question à poser est : "Est-ce qu'un professionnel qui n'a jamais vu ce patient peut construire un modèle de situation fiable avec cette interface ?"

**Ce que ce principe interdit :** Concevoir pour la reprise courte comme cas principal. Supposer que l'utilisateur connaît le patient.

---

### UXP-15 — L'interruption crée un coût de reprise sur la reprise

**Source CW-001 :** §10.2 — "Chaque interruption impose un coût cognitif spécifique : le coût de reprise. Après une interruption, le professionnel doit reconstruire l'état de sa propre réflexion au moment de l'interruption."

**Concept Domain Atlas :** §12 — Reprise de Contexte (peut elle-même être interrompue)

Une reprise interrompue génère un méta-problème : reprendre la reprise. À ce moment, le professionnel doit se souvenir de ce qu'il avait déjà compris, de ce qu'il lui restait à lire, et de l'état de son modèle au moment de l'interruption. Sans support, ce méta-problème a un coût cognitif significatif.

**Ce que ce principe exige :** L'interface doit permettre à un professionnel de reprendre une reprise interrompue sans repartir de zéro. Ce qui a déjà été accédé, ce qui a été noté, et l'état du modèle en construction doivent pouvoir être récupérés après une interruption.

**Ce que ce principe interdit :** Réinitialiser l'état d'une reprise lors d'un changement de contexte. Traiter chaque retour à la reprise comme un nouveau début.

---

### UXP-16 — La documentation interprétative réduit la charge de reconstruction

**Source CW-001 :** §8.2 — "Un dossier riche en résultats bruts mais pauvre en synthèses interprétatives conduit à des modèles de situation moins fiables, construits plus rapidement, avec un risque accru d'erreur."

**Concept Domain Atlas :** §6 — Raisonnement Clinique · §4 — Contribution Clinique (externalisation de la compréhension, pas des données)

Un dossier pauvre en raisonnements documentés impose au professionnel entrant de faire le travail d'interprétation que le professionnel précédent a déjà fait — mais sans accès à son contexte, son expertise, son information au moment de la décision. Ce travail est doublement coûteux : il consomme du temps et produit une reconstruction potentiellement incorrecte.

**Ce que ce principe exige :** L'interface de production d'une Contribution Clinique doit structurellement encourager la documentation du raisonnement, pas seulement des faits. Les dimensions Raisonnement Clinique et Incertitude Clinique doivent être des champs distincts et visibles — pas une note libre à tout mettre.

**Ce que ce principe interdit :** Présenter la Contribution Clinique comme un champ texte libre sans structure. Accepter une Contribution Clinique dont seule la dimension Situation Clinique est remplie sans signaler l'absence de raisonnement.

---

## Partie IV — La hiérarchie des informations

Ces principes décrivent l'ordre dans lequel les professionnels cherchent l'information lors d'une reprise. Cet ordre est empirique — il provient de l'observation des pratiques, pas d'un modèle théorique.

---

### UXP-17 — La synthèse récente prime sur tout

**Source CW-001 :** §4.2 — "Le professionnel cherche d'abord le document le plus récent qui propose une synthèse de la situation... Ce document est traité comme un point de départ ; il compresse le contexte en un volume lisible."

**Concept Domain Atlas :** §4 — Contribution Clinique (unité fondamentale de compréhension externalisée)

La synthèse récente est la Contribution Clinique la plus récente qui intègre les quatre dimensions : état actuel, raisonnement, incertitudes, intentions. C'est l'information de la plus haute valeur pour la reprise — parce qu'elle compresse ce que le professionnel précédent a compris en un volume lisible.

**Ce que ce principe exige :** La Contribution Clinique la plus récente et la plus complète doit être le premier élément accessible lors d'une reprise. Elle doit être distinguée des entrées purement factuelles (résultats, notes de constantes) qui n'ont pas de valeur synthétique.

**Ce que ce principe interdit :** Traiter toutes les entrées du Parcours de Soins de façon équivalente dans l'ordre de présentation. Placer une note de paramètres vitaux au même niveau qu'une synthèse interprétative.

---

### UXP-18 — Les événements récents viennent ensuite

**Source CW-001 :** §4.2 — "Ce qui s'est passé depuis la dernière synthèse disponible. Les résultats récents, les notes récentes. L'objectif est d'identifier ce qui a changé."

**Concept Domain Atlas :** §10 — Parcours de Soins (accumulation chronologique)

Après la synthèse, le professionnel cherche le delta : ce qui s'est passé entre la dernière synthèse et maintenant. Ce delta est plus précieux que l'historique complet — il représente l'information qui n'est pas encore intégrée dans une synthèse.

**Ce que ce principe exige :** L'interface doit pouvoir isoler le delta — les Contributions Cliniques produites après la dernière synthèse. Cette notion de "depuis quand ?" est une dimension de navigation fondamentale du Parcours de Soins.

**Ce que ce principe interdit :** Mélanger la synthèse et le delta dans un flux chronologique uniforme. Contraindre le professionnel à recalculer mentalement ce qui est "nouveau" en relisant tout.

---

### UXP-19 — Les problèmes actifs sont une vue distincte de l'historique

**Source CW-001 :** §4.2 — "La liste des problèmes cliniques actuellement en cours. Cette liste, quand elle est maintenue à jour, est l'un des éléments les plus utiles de la reprise."

**Concept Domain Atlas :** §9 — Intention Clinique · §8 — Incertitude Clinique

Les problèmes actifs sont ceux qui requièrent encore une attention ou une décision. Ils sont distincts des problèmes résolus et des antécédents stables. Cette distinction est une dimension clinique — pas un filtre technique.

**Ce que ce principe exige :** Les Intentions Cliniques non résolues et les Incertitudes Cliniques non levées doivent pouvoir être agrégées en une vue "problèmes actifs" — indépendamment de la Contribution Clinique dans laquelle elles ont été documentées.

**Ce que ce principe interdit :** Confondre "problèmes actifs" et "entrées récentes". Une Intention documentée il y a trois semaines peut être encore active. Une entrée de hier peut être déjà résolue.

---

### UXP-20 — Les signaux critiques sont permanents

**Source CW-001 :** §4.2 — "Les alertes et signaux critiques sont recherchés tôt, souvent en parallèle des autres lectures, parce que leur méconnaissance peut avoir des conséquences immédiates."

**Concept Domain Atlas :** UL-001 — Signal (information utile lors de la Reprise de Contexte)

Les signaux critiques — allergies, précautions spécifiques, contre-indications — ne font pas partie du flux de la reprise. Ils le précèdent. Un professionnel qui les ignore peut causer un dommage immédiat, indépendamment de la qualité du reste de sa compréhension.

**Ce que ce principe exige :** Les signaux critiques doivent être accessibles en permanence pendant toute la durée de la reprise, sans qu'il soit nécessaire de naviguer vers eux. Ils ne font pas partie du Parcours de Soins comme les autres Contributions — ils ont une visibilité propre.

**Ce que ce principe interdit :** Enterrer les signaux critiques dans le flux chronologique du Parcours de Soins. Les traiter comme des entrées parmi d'autres.

---

### UXP-21 — L'historique stable est accessible, pas intrusive

**Source CW-001 :** §4.3 — "L'historique ancien et stable — les pathologies chroniques connues, bien contrôlées, qui n'ont pas évolué — ces informations sont présupposées, pas re-lues."

**Concept Domain Atlas :** §10 — Parcours de Soins (accumulation non-destructive : tout est accessible, rien n'est forcé)

Le professionnel expérimenté présuppose l'historique stable — il ne le relit pas à chaque reprise. Le rendre trop visible, c'est créer du bruit là où le professionnel cherche un signal. Le rendre inaccessible, c'est priver le professionnel junior ou remplaçant de contexte nécessaire.

**Ce que ce principe exige :** L'historique stable doit être accessible en un accès volontaire — présent mais non proéminent. La visibilité par défaut est réservée à l'information active.

**Ce que ce principe interdit :** Afficher l'intégralité des antécédents stables au même niveau visuel que les problèmes actifs et les intentions en cours. L'égalité de traitement de toute l'information est une décision qui ignore la hiérarchie de valeur observée.

---

## Partie V — La lecture clinique

Ces principes concernent la manière dont les professionnels lisent et évaluent l'information clinique. Ils gouvernent ce qui doit être présenté pour que la lecture soit efficace.

---

### UXP-22 — Le raisonnement documenté vaut plus que les faits isolés

**Source CW-001 :** §5.3 — "'Il a noté pourquoi il a fait ce choix, c'est rare mais ça aide énormément.' L'explication du raisonnement accélère et sécurise la construction du modèle de situation."

**Concept Domain Atlas :** §6 — Raisonnement Clinique (explication de la situation — composante la plus précieuse)

Un fait clinique isolé exige du professionnel entrant qu'il en comprenne seul la signification. Un fait accompagné du raisonnement qui lui donne sens réduit ce travail d'interprétation. La différence n'est pas cosmétique — elle est quantifiable en temps de construction du modèle et en risque d'interprétation erronée.

**Ce que ce principe exige :** Le Raisonnement Clinique d'une Contribution doit être immédiatement visible et lisible — pas enfouie dans un sous-menu. Un fait sans raisonnement doit être signalé comme tel — parce que son absence est une information sur la qualité de la Contribution.

**Ce que ce principe interdit :** Traiter le Raisonnement Clinique comme une note optionnelle de moindre importance. Le cacher derrière un "voir plus". Permettre à une Contribution sans raisonnement d'être présentée exactement comme une Contribution avec raisonnement.

---

### UXP-23 — L'incertitude explicite est une information à valeur positive

**Source CW-001 :** §9.1 — "Une note qui indique 'j'hésite entre X et Y, le résultat attendu nous permettra de trancher' est d'une valeur considérable pour le professionnel qui reprend le patient."

**Concept Domain Atlas :** §8 — Incertitude Clinique (structurellement présente, explicitement formulée)

L'incertitude documentée par le professionnel précédent est une information de haute valeur — pas un aveu d'incompétence. Elle dit au professionnel entrant : "voici ce qui était ouvert, voici ce qui peut le résoudre." Cette information permet d'éviter de reconstruire une incertitude déjà identifiée et d'orienter directement l'attention vers sa résolution.

**Ce que ce principe exige :** Les Incertitudes Cliniques doivent être présentées avec autant de visibilité que les certitudes. Un professionnel qui a explicitement documenté une incertitude a fourni une information de haute valeur — elle mérite une présentation à la hauteur.

**Ce que ce principe interdit :** Masquer les Incertitudes Cliniques dans un registre textuel neutre. Présenter la Contribution Clinique comme si l'incertitude était une anomalie à minimiser visuellement.

---

### UXP-24 — Les intentions en suspens préviennent la redondance et orientent les priorités

**Source CW-001 :** §9.1 — "Une liste des choses décidées mais non encore réalisées évite les redondances et oriente les priorités."

**Concept Domain Atlas :** §9 — Intention Clinique (décidée et non encore exécutée)

Les Intentions Cliniques en cours sont les engagements du professionnel précédent envers l'avenir. Le professionnel entrant qui les ignore risque de re-décider ce qui a déjà été décidé, d'initier ce qui est déjà en cours, ou d'oublier ce qui était attendu.

**Ce que ce principe exige :** Les Intentions Cliniques actives doivent être agrégées et présentées en tant que telles — indépendamment de la Contribution dans laquelle elles ont été produites. Un professionnel doit pouvoir voir "ce qui reste à faire" sans lire toutes les Contributions.

**Ce que ce principe interdit :** Présenter les Intentions Cliniques uniquement dans le contexte de la Contribution qui les a produites, sans agrégation accessible.

---

### UXP-25 — La redondance est un bruit structurel, pas une information

**Source CW-001 :** §4.3 — "Le même diagnostic mentionné dans dix notes différentes. La même allergie citée à chaque entrée. Le professionnel apprend à filtrer les redondances."

**Concept Domain Atlas :** UL-001 — Bruit (information présente mais non utile lors de la Reprise de Contexte)

La redondance est filtrée par les professionnels expérimentés — mais ce filtrage consomme de l'attention et de la capacité cognitive. Il contraint le professionnel à faire un travail que le système devrait faire à sa place.

**Ce que ce principe exige :** L'interface doit dédupliquer structurellement : une information qui n'apporte pas de valeur différentielle par rapport à une information déjà accessible n'a pas à être répétée dans la vue principale. Elle peut être accessible mais ne doit pas occuper d'espace cognitif dans le flux principal.

**Ce que ce principe interdit :** Afficher systématiquement chaque mention d'une information dans chaque Contribution qui la contient. Traiter toutes les répétitions comme autant de points distincts d'entrée.

---

### UXP-26 — Une donnée sans interprétation est du bruit, pas un signal

**Source CW-001 :** §4.3 · §9.2 — "Un résultat biologique isolé, sans commentaire du praticien qui l'a prescrit, est souvent consulté rapidement et mis de côté. Les données sans interprétation constituent un bruit de fond qui dilue l'information pertinente."

**Concept Domain Atlas :** §4 — Contribution Clinique (comprend obligatoirement une dimension clinique interprétative, pas seulement des données brutes)

Un résultat biologique est un fait. Un résultat biologique accompagné d'une Situation Clinique ("ce résultat infirme l'hypothèse de...") est une information. Un résultat biologique accompagné d'un Raisonnement Clinique ("j'ai prescrit ce bilan parce que...") est une compréhension.

Le système ne peut pas forcer l'interprétation. Mais il peut présenter les données non interprétées avec un niveau de visibilité adapté à leur valeur cognitive — secondaire par rapport aux informations interprétées.

**Ce que ce principe exige :** Les résultats, mesures, et données brutes sans Contribution Clinique associée doivent être accessibles mais présentés comme tels — dans un espace distinct de l'espace des Contributions interprétatives.

**Ce que ce principe interdit :** Présenter un résultat de laboratoire et une Contribution Clinique synthétique avec le même niveau de hiérarchie visuelle.

---

## Synthèse — Cartographie des principes par phase de reprise

| Phase CW-001 | Principes UX actifs |
|---|---|
| **Conditions initiales** | UXP-02 (prior), UXP-14 (inconnu = référence) |
| **Phase 1 — Orientation** | UXP-03 (cadre initial), UXP-07 (première question) |
| **Phase 2 — Acquisition sélective** | UXP-08 (sélectivité), UXP-17 (synthèse en premier), UXP-18 (delta), UXP-20 (signaux critiques), UXP-21 (historique stable) |
| **Phase 3 — Construction du modèle** | UXP-01 (reconstruction), UXP-04 (narration), UXP-09 (4 dimensions), UXP-22 (raisonnement), UXP-23 (incertitude), UXP-24 (intentions), UXP-25 (redondance), UXP-26 (données brutes) |
| **Phase 4 — Identification des lacunes** | UXP-05 (incertitude légitime), UXP-10 (lacunes émergentes), UXP-19 (problèmes actifs) |
| **Phase 5 — Priorisation** | UXP-06 (biais cognitifs), UXP-11 (sailance vs criticité) |
| **Phase 6 — Clôture** | UXP-12 (clôture prématurée), UXP-13 (charge cognitive) |
| **Interruptions** | UXP-15 (reprise après interruption) |
| **Documentation reçue** | UXP-16 (interprétation réduit la charge) |

---

## Ce que ces principes n'établissent pas

Ces principes ne définissent pas :

| Non défini ici | Raison |
|---|---|
| La disposition des éléments dans un écran | Ceci appartient au design — qui commence après ces principes |
| Les composants d'interface à utiliser | Décision d'implémentation |
| Les couleurs et la typographie | Décision de design visuel |
| L'ordre des interactions | Décision d'interaction design |
| Les spécifications de développement | Niveau d'implémentation |

Ces principes définissent les **contraintes que le design doit satisfaire**. Comment le design les satisfait — c'est la liberté et la responsabilité du designer.

---

*Ce document est fondé exclusivement sur des observations empiriques (CW-001) et des concepts de domaine validés (Domain Atlas V1). Il ne contient aucune préférence esthétique, aucune tendance de design, aucune convention d'interface.*
*Son autorité vient de sa source : le travail clinique réel.*
