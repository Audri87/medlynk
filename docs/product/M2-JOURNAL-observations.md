# M2 — Journal des observations

**Statut :** Living document — alimenté pendant toute la durée du gel [ADR-0022](../adr/ADR-0022-m2-freeze-protocol.md)
**Périmètre :** WS-002, WS-004, WS-005 uniquement (WS-003 hors gel)
**Règle :** aucune entrée ne modifie M2 directement. Chaque entrée est une observation, reformulée en
hypothèse d'amélioration, en attente de la revue de fin de gel.

> Seuil de journalisation (ADR-0022 §3) : une entrée existe seulement si la difficulté a forcé un
> contournement, une décision de scope imprévue, ou une contradiction avec ce que M2 dit faire.

---

## Format d'une entrée

```
OBS-M2-[NNN]
Workspace  : [WS-002 / WS-004 / WS-005]
Date       : [YYYY-MM-DD]
Difficulté : [ce qui a été rencontré, factuellement]
Loi motivante déjà connue (si applicable) : [T-NNN, PP-NNN, ou "aucune"]
Hypothèse d'amélioration : [reformulation testable — pas une solution actée]
Statut     : Confirme / Réfute / Suspendue / Abandonnée (vocabulaire CC-000)
```

---

## Entrées

### OBS-M2-001

**Workspace :** WS-002
**Date :** 2026-08-06
**Difficulté :** Le bloc "Nouveautés" proposé pour le prototype v0.2 ne s'ancre à aucune Observation
existante de WS-002, et son contenu (courrier confrère, rapport reçu) touche une limite de portée
explicitement exclue par le Blueprint (*"praticiens lisant les notes d'un collègue"*).
**Loi motivante déjà connue :** Aucune — proche de PP-001 (WS-001, Signal precedes Horizon) sans
en être une extension actée.
**Hypothèse d'amélioration :** Le bloc Nouveautés répond peut-être à une question de frontière entre
WS-002 et WS-005 (store de sortie de la transmission, déjà noté ouvert dans AR-001 Finding-004) plutôt
qu'à une extension propre de WS-002.
**Statut :** Suspendue — en attente de confrontation praticien (CWRM-020-APX-M2 §2 et §5).

---

### OBS-M2-002

**Workspace :** WS-002
**Date :** 2026-08-06
**Difficulté :** La granularité du mécanisme de composition ("widget") n'est définie nulle part —
Challenge 4 (N micro-actes ⇄ N widgets) reste non tranché, et la proposition "Clinical Capability
Block" a tenté de le figer en ADR avant tout test terrain.
**Loi motivante déjà connue :** Aucune — Challenge 9 conclut à une relation de traduction possible,
pas à un objet réutilisable démontré.
**Hypothèse d'amélioration :** Ne pas nommer ni figer d'unité de composition avant d'avoir observé au
moins deux traductions indépendantes (deux Workspaces) suivant le même besoin de composition par
métier.
**Statut :** Suspendue — condition de sortie liée à ADR-0022 (trois Workspaces, pas un seul).

---

### OBS-M2-003

**Workspace :** Transversal (constaté sur WS-003, applicable à WS-004/005 à venir)
**Date :** 2026-08-06
**Difficulté :** Risque de transposer automatiquement l'architecture noyau + widgets adaptatifs
découverte sur WS-002 aux autres Workspaces, sans vérifier si leur propre corpus/Blueprint la
justifie. WS-003 a un Blueprint qui écarte explicitement ce modèle (*"architecture de modes, pas de
blocs"*, §9) en faveur d'une machine à états.
**Loi motivante déjà connue :** Aucune — le choix d'architecture d'interface (widgets vs modes) n'est
lui-même établi par aucune loi M1 ; c'est une décision produit par Workspace.
**Hypothèse d'amélioration :** Chaque Workspace vérifie indépendamment, avant d'adopter un modèle
d'architecture, si son propre corpus/Blueprint le justifie — jamais un héritage automatique d'un autre
Workspace.
**Statut :** Confirme — ratifié explicitement par le Product Owner le 2026-08-06. Ne modifie pas le
workflow, la règle de stabilité, ni le format du journal (donc ne rouvre pas le gel M2, ADR-0022 §3) ;
s'applique comme critère de vérification lors de la construction de WS-004/005.

> **Précision de portée 2026-09-08.** Discussion Product Owner suite au challenge du Layout Global —
> une lecture trop large de cette entrée aurait pu interdire toute variation de contenu à l'intérieur
> de WS-003, ce que l'entrée ne dit pas. Précision, pas contradiction :
>
> - **Ce qu'`OBS-M2-003` rejette** : transposer dans WS-003 une architecture de blocs composables
>   affichés simultanément, telle qu'utilisée dans WS-002. Ça reste confirmé, ratifié, inchangé.
> - **Ce qu'elle ne rejette pas** : la variation du contenu ou des capacités disponibles à l'intérieur
>   des modes déjà définis de WS-003. Des capacités de production différentes selon le métier peuvent
>   être proposées dans un mode existant, notamment en Mode Clôture, sans constituer de nouveaux blocs
>   composables ni modifier l'architecture par modes.
>
> Distinction de statut, à ne pas mélanger :
> 1. **Architecture WS-003 par modes** — décision/connaissance existante (Blueprint §9), inchangée.
> 2. **Variabilité des productions selon le métier** — hypothèse produit appuyée par des observations
>    terrain (`CPP-001`, `OBS-M2-007`, `OBS-M2-009`).
> 3. **Un Mode Clôture proposant des sorties métier optionnelles** — non testé à ce stade ; le
>    prototype actuel n'a jamais construit ni montré cet écran à un praticien (le bouton "Clôturer"
>    ferme directement, sans choix de sortie).
> 4. **Variabilité supplémentaire selon le contexte de consultation** (première consultation, suivi,
>    aiguë, contrôle...) — hypothèse produit distincte, encore plus fraîche, aucune session ne l'a
>    évoquée.
>
> "Widget" peut servir de terme interne de conception produit/UI pour désigner (2)/(3), mais n'est ni
> un concept d'architecture WS-003 ni un terme destiné à l'interface praticien. Ces capacités doivent
> rester optionnelles, sans champ obligatoire ni template imposé (PP-012).

---

### OBS-M2-004

**Workspace :** Transversal (WS-001, WS-002, WS-005)
**Date :** 2026-08-06
**Difficulté :** Le même besoin — signaler ce qui a changé / doit être transmis — apparaît sous trois
formes distinctes sans qu'aucune loi commune ne soit établie : *"Ce qui a changé depuis hier"* +
*"Transmissions à réaliser"* dans `probe-dashboard-v3.html` (échelle jour), le bloc "Nouveautés"
testé sur WS-002 v0.2 (échelle patient), et le mandat même de WS-005 (transmission entre acteurs).
**Loi motivante déjà connue :** Aucune — convergence de surface, pas encore une Loi corroborée.
**Hypothèse d'amélioration :** Vérifier explicitement, lors des entretiens déjà prévus
([CWRM-020-APX-M2](../research/specifications/CWRM-020-APX-M2-workspace-questionnaires.md) §2 et §5),
si les praticiens distinguent réellement ces trois échelles ou les vivent comme une seule
préoccupation continue.
**Statut :** Suspendue.

---

### OBS-M2-005

**Workspace :** Transversal
**Date :** 2026-08-06
**Difficulté :** `probe-dashboard-v3.html` mélange un shell de navigation persistant (sidebar, barre
du haut, nav Aujourd'hui/Patients/Transmissions/Paramètres) avec le contenu propre à WS-001. Aucun
document existant (GOV-000, PRODUCT-ARCHITECTURE-v1.0, Blueprints) ne définit ni ne nomme ce shell
comme concept d'architecture produit.
**Loi motivante déjà connue :** Aucune.
**Hypothèse d'amélioration :** Nommer et scoper ce shell explicitement avant d'y intégrer d'autres
Workspaces — sinon il s'installe par l'usage sans définition, répétant la dérive déjà observée avec
"widget" (OBS-M2-002/003).
**Statut :** Suspendue.

> **Mise à jour 2026-08-06.** Le Product Owner formule explicitement le rôle attendu du shell
> ("Mon Espace") : préserver les habitudes du praticien — sa journée, ses patients, ses alertes, ses
> éléments en attente, ses accès habituels — pendant que WS-002/WS-003 peuvent, une fois un patient
> ouvert, faire vivre une expérience différente. Ceci précise le périmètre à tester, sans encore
> constituer une confirmation terrain — reste `Suspendue`, mais moins ouvert qu'avant.

> **Mise à jour 2026-08-17.** Première confrontation terrain (test d'utilisabilité, médecin
> spécialiste, 7 ans d'expérience, cabinet seul) : après ouverture d'une fiche patient, le praticien a
> eu des difficultés à identifier comment revenir à « Mon Espace » (*"je ne savais plus comment revenir
> en arrière"*), avant de repérer le bouton en haut de l'écran. Confirme partiellement le besoin de
> nommer et rendre visible ce shell — reste `Suspendue`, un seul praticien ne corrobore rien
> (IP-REQ-007), mais la friction est désormais observée, pas seulement anticipée.

> **Mise à jour 2026-09-08.** Discussion Product Owner autour du Layout Global v3 : proposition d'un
> mécanisme conditionnel dans "Mon Espace" — au démarrage de la journée, afficher d'abord ce qui reste
> en suspens depuis la veille (rapports, tâches reportées) si ça existe, sinon aller directement au
> planning. Reformulation utile après une première version (planning déplacé derrière un clic, écartée
> — contredite frontalement par la session 4 biologiste : *"je regarderai mon planning [...] puis les
> éléments en suspens"*, ordre inverse de ce qui était proposé).
>
> Deux points de collision avec l'existant, pas une idée neuve à construire directement :
> 1. **C'est exactement le terrain de WS-001 ("Morning Brief")**, avec ses propres lois déjà posées
>    (PP-002 *Preparation follows Uncertainty*, PP-004 *Obligations secondary, not invisible*) — à
>    vérifier avant de construire quoi que ce soit dans le shell "Mon Espace", pour ne pas dupliquer ou
>    contredire silencieusement WS-001.
> 2. **La question "tâches reportées, retrouvées le lendemain" est déjà écrite, jamais posée** —
>    [CWRM-020-APX-M2-workspace-questionnaires](../research/specifications/CWRM-020-APX-M2-workspace-questionnaires.md)
>    §6 (WS-006, *"Je termine"*) : *"Le lendemain matin, est-ce que vous repensez à ce qui restait en
>    suspens la veille — et comment vous en souvenez-vous ?"* et *"Les tâches reportées — vous les
>    retrouvez où, le lendemain ?"* — notées comme *"la frontière WS-006 → WS-001, jamais spécifiée"*.
>    Zéro session à ce jour n'a couvert WS-006 (le script ne teste que WS-002/WS-003).
>
> **Décision :** ne pas construire ce mécanisme dans `WS-002-WS-003-parcours-v3.html` maintenant — poser
> les questions WS-006 §6 au prochain round d'abord. Reste `Suspendue`, hypothèse de conception notée,
> pas actée.

---

### OBS-M2-006

**Workspace :** WS-002
**Date :** 2026-08-17
**Difficulté :** Confrontée au bandeau patient (allergies/diabète/HTA) du prototype
`WS-002-WS-003-parcours-v2.html`, une praticienne (médecin spécialiste, 7 ans, cabinet seul, logiciel
actuel Vita) juge le contenu actuel « suffisant si c'est tout », mais formule spontanément deux besoins
non anticipés par le corpus : (1) choisir elle-même quels antécédents apparaissent dans le bandeau
plutôt que de recevoir une sélection fixe, et (2) un indicateur visuel (« comme un message en attente »)
quand un confrère a ajouté un antécédent qu'elle n'a pas encore vu. Ni la personnalisation ni la
notification de nouveauté non lue ne figurent dans DR-001→004 ni dans les itérations précédentes du
bandeau.
**Loi motivante déjà connue :** Aucune — proche de PP-004 (WS-001, *Obligations secondary, not
invisible*) sans en être une extension actée ; la notion de « non-lu » n'a jamais été testée sur un
antécédent clinique dans le corpus.
**Hypothèse d'amélioration :** Le bandeau patient pourrait avoir besoin d'un niveau de personnalisation
par praticien (pas seulement d'une règle produit fixe), et d'un mécanisme de « nouveauté non vue »
distinct de l'alerte de sécurité (rouge = danger, autre signal = information ajoutée par un tiers depuis
la dernière consultation de ce praticien). Reste à vérifier sur au moins un second praticien avant toute
traduction produit (IP-REQ-007).
**Statut :** Suspendue — un seul praticien, pas encore de corroboration.

---

### OBS-M2-007

**Workspace :** WS-002 (signal transversal CPP-001)
**Date :** 2026-08-27
**Source :** Thérapeute — hypnose et sophrologie, 5 ans d'expérience (depuis 2021), cabinet individuel,
aucun logiciel actuel. Session unique — seuil IP-REQ-007 non atteint pour ce profil (aucun deuxième
praticien de cette profession testé à ce jour).
**Situation observée :** Première confrontation de WS-002 à une profession non médicale (test sur
`WS-002-WS-003-parcours-v2.html`). Le mental model général de WS-002 (chercher « dernière visite + ce
qui s'y est fait » avant d'agir) transfère sans friction à cette pratique. Deux éléments interrogent
cependant CPP-001 : (1) le bandeau patient (allergies/diabète/HTA) est jugé suffisant *pour le
médical*, mais la praticienne indique elle-même que ce qui lui serait utile (une synthèse de ses
séances) est différent ; (2) les catégories de la sidebar (Résultats/Ordonnances/Historique), conçues
sur un modèle médical classique, ne lui parlent pas nettement pour ranger une synthèse séance par
séance ou un bilan de neurotransmetteurs — elle hésite entre "Historique" et "Résultats" sans trancher,
et le clic sur "Résultats" n'aboutit à rien pour ce cas d'usage dans le prototype (non implémenté).
**Verbatim :** *"si je devais avoir une synthèse, ce serait les textes que j'utilise en hypnose [...]
mais c'est encore autre chose, quoi"* ; sur la sidebar : *"ça pourrait être hypnose 1, estime de soi,
hypnose 2 [...] je me dis que dans l'historique, ça pourrait être ça, ou sinon dans les résultats, ça
dépend de comment on voit le truc à mon niveau."*
**Interprétation minimale :** Le besoin sous-jacent (« retrouver rapidement où j'en suis avec ce
patient ») est le même concept que celui déjà testé côté médical (T2) — CPP-001/CPT-002 qualifierait
probablement ceci de différence *comportementale* (le contenu diffère par métier) plutôt que
*conceptuelle* (pas besoin d'un nouveau concept Domain par métier). La demande de « synthèse des
séances » est donc à lire comme un signal spécifique à la pratique thérapeutique — pas comme une preuve
que WS-002 a besoin d'un composant générique de synthèse longitudinale. Ne pas confondre les deux.
**Lien avec l'existant :** CPP-001 (Cross-Practitioner Principle, test CPT) — jamais confronté à un
profil non médical sur WS-002 avant cette session ; le résultat va plutôt dans le sens de CPP-001
(concept partagé, comportement/contenu à qualifier par profession) que contre. DR-001→004 (toutes
`Draft`, jamais validées) restent non tranchées par cette session — elle porte sur les catégories du
bandeau/sidebar, pas directement sur ces quatre règles.
**Croisement avec OBS-M2-006 :** PARTIELLEMENT CORROBORÉ — même direction générale (des catégories
fixes du bandeau ne suffisent pas telles quelles), mécanisme différent (OBS-M2-006 : personnalisation
par le praticien lui-même sur un contenu médical inchangé ; OBS-M2-007 : adaptation du contenu par
métier). Les deux ne doivent pas être fusionnés en une seule hypothèse sans vérification supplémentaire.
**Statut méthodologique :** Suspendue — n=1 pour ce profil, IP-REQ-007 non atteint. Ne pas traduire en
exigence produit (ni « WS-002 doit avoir un composant de synthèse de séances », ni « le métier du
patient doit conditionner l'affichage ») avant confrontation à d'autres professions non médicales
(sage-femme, infirmier, kinésithérapeute...).

---

### OBS-M2-008

**Workspace :** Transversal (Mon Espace / shell — cf. OBS-M2-005)
**Date :** 2026-08-27
**Source :** Même session — thérapeute, hypnose et sophrologie, 5 ans, cabinet individuel, aucun
logiciel actuel.
**Situation observée :** Le planning est regardé spontanément en premier — comportement déjà observé
en session 1 (médecin spécialiste), ici sur un deuxième profil différent. Elle juge heure + note +
type de consultation (premier contact / suivi) + âge largement suffisants par rendez-vous, sans
exprimer de besoin de préparation supplémentaire. Elle signale vouloir, en plus, la distance temporelle
depuis le dernier rendez-vous. Elle relève aussi une incohérence : "Mon espace" affiche déjà le
planning du jour, mais cliquer sur l'item "Planning" de la sidebar n'affiche rien.
**Verbatim :** *"je regarde mon planning en premier [...] ce qui me suffirait, je crois que c'est une
consultation, un premier contact ou un suivi. Je vois son âge. J'aurais pas besoin de plus [...] ce qui
me manquerait, c'est de savoir si je l'ai vu il y a un mois, il y a deux ans ou il y a une semaine."*
Sur la contradiction : *"quand je clique sur planning [...] j'ai rien [...] ça m'a perturbée."*
**Interprétation minimale :** Le planning-comme-point-d'entrée est un deuxième point de donnée
convergent avec la session 1, sur un profil différent — pas une corroboration formelle IP-REQ-007
(professions distinctes), mais un signal qui va dans le même sens. La contradiction "Planning" est très
probablement une lacune d'implémentation du prototype (l'item de sidebar n'a pas de page derrière lui)
plutôt qu'un signal de conception — à vérifier avant d'en tirer une conclusion.
**Lien avec l'existant :** PP-001 (WS-001, *Signal precedes Horizon*) — le planning en premier va dans
le sens de PP-001, sur un 2ᵉ profil. PP-002 (*Preparation follows Uncertainty*) — aucun besoin de
préparation exprimé ici, cohérent avec le signal « je ne prépare jamais mes rendez-vous » de la session
1 (médecin) — **rappel explicite : ce point ne doit pas devenir une conclusion générale sur le
Dashboard à partir de deux entretiens seulement, professions différentes, échantillon minuscule.**
**Croisement avec la session 1 (médecin spécialiste) :** PARTIELLEMENT CORROBORÉ sur "planning regardé
en premier" et "pas de besoin de préparation" (même direction, professions différentes, statut encore
loin du seuil IP-REQ-007). NON CORROBORÉ / nouveau sur la distance temporelle depuis le dernier
rendez-vous et sur la contradiction du bouton "Planning" — absents de la session 1.
**Statut méthodologique :** Suspendue — contradiction "Planning vide" à vérifier comme un défaut
d'implémentation avant tout statut plus définitif ; le reste reste un signal à deux points de donnée,
pas une règle.

---

### OBS-M2-009

**Workspace :** WS-002 (+ WS-003, signal transversal CPP-001)
**Date :** 2026-09-03
**Source :** Kinésithérapeute, 28 ans d'expérience, cabinet (ouvert seule, exercice à deux avec un
collègue depuis 3 ans), logiciel actuel Vega. Session unique — IP-REQ-007 non atteint pour ce profil.
**Situation observée :** 3ᵉ manifestation du même besoin structurel déjà vu en session 1 (dernier
résultat/dernière consultation, médecin) et session 2 (synthèse de séances, thérapeute), avec un
contenu propre à sa profession à trois endroits distincts : (1) sur le Dashboard, elle voudrait voir le
nombre de séances déjà faites sur le total prescrit (« 4 sur 20 ») et un signal de renouvellement
d'ordonnance ; (2) avant la consultation (WS-002), elle voudrait un espace listant les techniques déjà
utilisées à la dernière séance ; (3) pendant la consultation (WS-003), elle redemande le même accès pour
« consulter encore une fois ce qui a été fait ». Elle justifie explicitement ce besoin par un rythme de
suivi différent de la médecine (*"nous, on les voit vraiment régulièrement"*).
**Verbatim :** *"il me manquerait le nombre de séances [...] ça me permet de savoir aussi si on a déjà
eu beaucoup de séances ou pas [...] parce que souvent, nous, on a des ordonnances qui se renouvellent"* ;
*"un petit espace pour noter les techniques qui ont été utilisées déjà à la dernière séance."*
**Interprétation minimale :** Même lecture que OBS-M2-007 (CPT-002 — différence comportementale/de
contenu, pas conceptuelle) : le concept « où en suis-je avec ce patient » est partagé, son contenu
concret (séries de séances prescrites vs synthèse d'hypnose vs antécédents médicaux) varie par métier.
Trois professions, trois contenus différents, même structure de besoin — c'est le signal CPP-001 le
plus net obtenu jusqu'ici sur WS-002.
**Lien avec l'existant :** CPP-001 (Cross-Practitioner Principle). Recoupe T2 (AR-001B, reconstruction
de contexte) et la demande d'accès au dossier pendant la consultation déjà notée en session 1/2 (§8 du
script, hypothèse structure).
**Croisement :** PARTIELLEMENT CORROBORÉ avec OBS-M2-007 (même direction CPP-001, contenu différent —
ne pas fusionner) ; PARTIELLEMENT CORROBORÉ avec la demande d'accès au dossier pendant la consultation
des sessions 1 et 2 (même besoin structurel, contenu différent à chaque fois).
**Statut méthodologique :** Suspendue — 3 professions, 3 sessions, 0 profession corroborée à 2
praticiens (IP-REQ-007 non atteint nulle part). Ne pas traduire en composant générique de "suivi de
séries" avant confrontation à d'autres professions à suivi régulier (orthophoniste, infirmier).

---

### OBS-M2-010

**Workspace :** WS-002
**Date :** 2026-09-03
**Source :** Même session — kinésithérapeute, 28 ans, cabinet à deux.
**Situation observée :** En cliquant sur un élément de la sidebar patient (Résumé/Historique/
Résultats...), elle attendait que l'élément cliqué grossisse sur place, avec la possibilité d'annoter
dedans — pas de revoir "les mêmes éléments qui sont déjà à gauche". Elle juge ce dernier comportement
redondant (*"pour moi, ça me semble de trop"*).
**Verbatim :** *"je m'attendais à ce que ce soit l'élément cliqué qui apparaisse un peu plus gros, et
qu'on puisse annoter quelque chose dans cet élément-là [...] je pense que si juste tu cliques sur un
[élément] et puis avoir [ces] éléments-là qui se mettent sur l'écran, pour moi ça serait suffisant."*
**Interprétation minimale :** C'est l'exact inverse de la Lecture A obtenue sans ambiguïté en session 1
(médecin) — sortir de la page vers le dossier complet. Ici, la praticienne attend une expansion en place
(accordéon), pas une sortie de page. **Ne pas trancher** : c'est une vraie divergence entre deux
praticiens sur la même question de conception, pas un signal à moyenner ou à lisser.
**Lien avec l'existant :** Distinction Lecture A / Lecture B tranchée en conception le 2026-08-13
(CWRM-020-APX-M2-USA §5, Scénario 2), jamais confrontée à plus d'un praticien avant cette session.
**Croisement avec la session 1 (médecin) :** `NON CORROBORÉ` — divergence directe et explicite, pas une
absence de signal. À traiter comme telle.
**Statut méthodologique :** Suspendue — question de conception rouverte par le terrain lui-même (2
praticiens, 2 réponses opposées), pas encore par une décision. Nécessite au minimum un 3ᵉ et 4ᵉ
praticien avant d'envisager trancher.

> **Mise à jour 2026-09-03.** Session 4 (biologiste médical, 7 ans, hôpital, questionnaire
> auto-administré) répond sans ambiguïté en Lecture A sur les quatre items testés (Historique,
> Résultats, Ordonnances, Documents — chacun décrit comme "toutes les précédentes X"). Ça fait 2 votes
> Lecture A (médecin, biologiste) contre 1 vote accordéon en place (kiné). Toujours très loin du seuil
> IP-REQ-007, mais un motif possible apparaît : les deux votes Lecture A viennent de professions
> médicales stricto sensu, le vote accordéon d'une profession paramédicale — **hypothèse à vérifier au
> prochain entretien, pas une conclusion.** Reste `Suspendue`.

> **Correction 2026-09-04.** Les labels Lecture A / Lecture B de cette entrée étaient inversés par
> rapport à la source de vérité (commentaire du code, `WS-002-WS-003-parcours-v2.html` lignes 361-367,
> et ADR-0023 §7 Règle 3 / §9) : **Lecture A** = quitter la page pour ouvrir le Care Record (comportement
> du médecin et du biologiste) ; **Lecture B** = rester sur place en onglet interne, explicitement
> écartée par ADR-0023 (« WS-002 ne doit pas devenir un dossier médical complet », « ne pas fusionner
> WS-002 et Care Record »). Conséquence : ce n'est pas une question ouverte à 50/50 entre deux options
> égales — le comportement attendu par le kiné (accordéon en place) correspond à ce qu'ADR-0023 a déjà
> explicitement écarté. Ça ne rend pas sa friction moins réelle (« ça me semble de trop » reste un vrai
> signal d'épure à traiter), mais la réponse ne peut pas être « adopter la Lecture B » — elle doit
> passer par autre chose : améliorer la transition vers le Care Record (Lecture A) plutôt que la
> remplacer. Statut inchangé (`Suspendue`), mais la nature de ce qui reste à trancher change.

> **Gel 2026-09-08.** Lecture A explicitement figée dans le code (`WS-002-WS-003-parcours-v2.html`,
> commentaire mis à jour) avant le prochain round de test — pas une nouvelle décision, une
> confirmation tracée d'ADR-0023 §7 Règle 3/§9, renforcée par 2/3 réponses terrain. La friction du kiné
> reste explicitement `Suspendue` et non résolue par ce gel — elle est notée comme un sujet UX à
> travailler séparément (transition, pas structure), pas comme clause à rouvrir sans contradiction
> empirique démontrée (ADR-0015 Règle 4).

---

### OBS-M2-011

**Workspace :** Transversal (Mon Espace / shell — cf. OBS-M2-004, OBS-M2-008)
**Date :** 2026-09-03
**Source :** Même session — kinésithérapeute, 28 ans, cabinet à deux.
**Situation observée :** Sur le Dashboard, elle ne sait pas si le bloc "À votre attention" contient des
éléments en plus du planning ou s'il correspond aux patients déjà listés dans le planning — ambiguïté
non résolue spontanément, elle indique qu'elle aurait présenté cette zone différemment sans proposer de
solution précise.
**Verbatim :** *"on sait pas si c'est quelque chose en plus, on sait pas si ça correspond aux patients
qui sont déjà mis."*
**Interprétation minimale :** Rejoint directement OBS-M2-004 (le même besoin « signaler ce qui a changé
/ ce qui mérite attention » apparaît déjà à trois échelles sans loi commune établie) — c'est une 4ᵉ
occurrence, cette fois sous forme d'une ambiguïté de relation entre deux blocs du Dashboard plutôt que
d'un besoin exprimé positivement.
**Lien avec l'existant :** OBS-M2-004 (transversal, 2026-08-06), OBS-M2-008 (Dashboard, session 1
thérapeute — planning en premier, sans ce point précis).
**Croisement :** Nouveau — absent des sessions 1 et 2, qui n'ont pas commenté ce bloc spécifiquement.
**Statut méthodologique :** Suspendue — un seul praticien, à vérifier si l'ambiguïté vient du contenu du
bloc ou simplement de son intitulé/emplacement.

> **Mise à jour 2026-09-03.** Session 4 (biologiste médical) traite spontanément le second bloc du
> Dashboard (« les éléments en suspens ») comme une deuxième étape normale de son parcours (« je
> regarderai mon planning [...] puis les éléments en suspens »), sans signaler d'ambiguïté. `NON
> CORROBORÉ` vis-à-vis de la confusion relevée par le kiné — à ce stade, ça ressemble plus à une
> question de formulation/présentation propre à un praticien qu'à une confusion structurelle. Reste
> `Suspendue`, n=2 sur des réponses opposées.

---

### OBS-M2-012

**Workspace :** WS-002
**Date :** 2026-09-03
**Source :** Biologiste médical, 7 ans d'expérience, hôpital, logiciel actuel GLIMS. Reçu via
questionnaire auto-administré ([CWRM-020-APX-M2-QST](../research/specifications/CWRM-020-APX-M2-questionnaire-praticiens-ws002-ws003.md)) —
pas d'observation de comportement, réponses écrites uniquement.
**Situation observée :** Vérifiée directement dans le code du prototype — pas seulement rapportée par
le praticien : chaque item de la sidebar "Dossier" (Historique, Résultats, Ordonnances, Documents,
**Antécédents**, Famille, Vaccins, Mes notes, Courriers) appelle exactement la même fonction
`openRecord('patient')` (`WS-002-WS-003-parcours-v2.html`, lignes 390-400) — aucun d'eux n'ouvre un
contenu filtré ou dédié à la catégorie cliquée. Le praticien clique "Antécédents" en s'attendant à une
fiche résumée (antécédents médicaux, chirurgicaux, familiaux, allergies) et retombe sur le même Care
Record générique que "Résultats" ou "Historique".
**Verbatim :** *"lorsque l'on clique sur antécédent on retombe sur historique/résultat/traitement/doc
alors que ça serait intéressant d'avoir une fiche résumé avec les antécédents médicaux, chirurgicaux,
familiaux et allergie"* ; à la question de ce qui a le plus manqué : *"la fiche résumée du patient."*
**Interprétation minimale :** Contrairement à la contradiction "Planning" (OBS-M2-008, probable simple
absence de page dans le prototype), celle-ci est structurelle et documentée dans le commentaire du code
lui-même (*"chaque item (hors Résumé) ouvre le Care Record"*) — c'est un choix de simplification du
prototype, pas un accident. Mais elle correspond exactement au type de lacune que le praticien remonte
spontanément : il attend une différenciation de contenu par catégorie que le prototype ne fournit pas
encore.
**Lien avec l'existant :** DR-001→004 (toutes `Draft`, jamais validées) — porteraient potentiellement
sur ce point si elles étaient assez précises pour trancher entre "Lecture A uniforme" et "Lecture A
avec contenu filtré par catégorie". Recoupe aussi la nuance déjà notée en session 1 (médecin,
`CWRM-020-APX-M2-workspace-questionnaires` §2) : *"une fois sur une catégorie, elle ne veut pas revoir
les autres catégories mélangées."*
**Statut méthodologique :** Suspendue quant à la traduction produit (un seul praticien) — mais le fait
générateur (toutes les entrées de la sidebar mènent au même endroit) est, lui, un fait vérifié, pas une
hypothèse. À corriger ou à assumer explicitement avant le prochain test, plutôt qu'à laisser ambigu.

> **Gel 2026-09-08.** Décision du Product Owner : filtrer par catégorie plutôt qu'assumer le
> comportement uniforme. `WS-002-WS-003-parcours-v2.html` — chaque item de la sidebar (Historique,
> Résultats, Ordonnances, Documents, Antécédents, Famille, Vaccins, Mes notes, Courriers) ouvre
> désormais le Care Record ancré sur sa propre section (`openRecord('patient', section)`, scroll +
> surlignage temporaire), au lieu de retomber sur le sommet générique de la page. Le Care Record est
> passé de 4 à 9 cartes pour correspondre exactement aux 9 items de la sidebar — contenu volontairement
> minimal (mockup), la fiche "Antécédents" mentionne explicitement médical/chirurgical/allergies comme
> demandé. Toujours un seul praticien à l'origine de la demande (`Suspendue` quant à la corroboration),
> mais le choix de conception est maintenant assumé explicitement plutôt que laissé ambigu — à confirmer
> ou infirmer par le prochain round de test (patient dense).

---

### OBS-M2-013 — WS-004 : contradiction entre responsabilité démontrée et classification Workspace

**Workspace :** Transversal (WS-003/WS-004, périmètre du proof set M2)
**Date :** 2026-09-08

**Observation.** La falsification de WS-004 (challenge du 2026-09-08) n'a identifié aucune
responsabilité cognitive, décisionnelle ou opérationnelle propre au praticien qui soit distincte de
WS-003 sur les scénarios A–G testés. La production d'une ordonnance, d'un examen, d'un courrier ou d'un
rendez-vous est déjà couverte par le Mode Clôture de WS-003 (§9 du Blueprint). La persistance et les
traitements futurs identifiés (WBD-004, §"Memory Capture" — transcription, résumé IA, extraction)
relèvent actuellement d'opérations système plutôt que d'une activité Actor-facing.

**Contradiction M2.** La définition de Workspace ([WSP-001](../workspace/WSP-001-workspace.md)) exige
une projection calculée depuis l'état du domaine et assemblée *pour un Actor*, et exclut explicitement
qu'un Workspace soit *"un Application Service."* Si aucune responsabilité Actor-facing distincte n'est
démontrée pour WS-004, sa classification comme Workspace doit être reconsidérée.

**Hypothèse.** WS-004 pourrait ne pas constituer un Workspace produit mais une responsabilité
architecturale interne — notamment de persistance, structuration ou traitement asynchrone. Cette
hypothèse ne constitue pas encore une décision d'architecture — elle est à instruire, pas à acter.

**Impact potentiel** (à confirmer par l'audit ciblé, pas encore établi) :
- le périmètre du proof set M2 ([ADR-0022](../adr/ADR-0022-m2-freeze-protocol.md) §2, qui liste WS-002/004/005 comme *"les trois seuls Workspaces réellement construits sous M2"*, et §4, condition de sortie exigeant *"au moins un round d'entretien praticien conduit"* pour chacun) ;
- [WBD-004](../product/workspaces/WBD-004-consultation-vs-documentation.md) (RESOLVED — la responsabilité de persistance resterait valide, sa classification en Workspace serait à revoir) ;
- le questionnaire WS-004 ([CWRM-020-APX-M2-workspace-questionnaires](../research/specifications/CWRM-020-APX-M2-workspace-questionnaires.md) §4, dont les questions supposent un entretien praticien sur un Workspace) ;
- la distinction normative entre Workspace et services internes (absente de GOV-000 à ce jour).

**Action proposée.** Instruire cette contradiction selon le mécanisme d'évolution prévu par le corpus
(ADR-0015 Règle 4) avant toute modification des documents `Accepted`/`RESOLVED`. Séquence retenue :
1. `OBS-M2-013` (cette entrée) — enregistrer la contradiction.
2. Audit ciblé ADR-0022 / WSP-001 / WBD-004 — vérifier précisément ce que devient le proof set M2 si
   WS-004 cesse d'être considéré comme Workspace. **Fait — voir résultat ci-dessous.**
3. Décision d'évolution via ADR-0015 Règle 4 — l'audit confirme la contradiction. **Fait —
   [ADR-0024](../adr/ADR-0024-ws004-nature-et-proof-set-m2.md) (Draft) présente deux options (remplacer
   WS-004 par WS-006 dans le proof set / réviser la définition du proof set elle-même), en attente de
   décision du Product Owner.
4. Révision de WBD-004 — probable changement de nature/classification, pas nécessairement suppression
   de la responsabilité de persistance elle-même.
5. Prototype — `#ws4` disparaît du parcours praticien testable (déjà appliqué dans
   `WS-002-WS-003-parcours-v5.html`, en avance sur la décision formelle : aucun chemin de clic n'y mène).

> **Résultat de l'audit falsificateur (2026-09-08).** Mené en cherchant activement à contredire la
> conclusion, pas à la confirmer — deux pistes instruites explicitement.
>
> **G1 — Clinical Authorization.** N'apporte aucun appui à WS-004. `HR-001` classe `H-G1`
> (Publication & Visibility Rules) et `H-A-006` en *"Domain Behaviour"*, résolution prévue par
> *"Strategic Design"* — un comportement de domaine consommé silencieusement par les Workspaces qui
> lisent des Clinical Contributions (WS-002, WS-005), pas une responsabilité de Workspace en soi.
> Aucun document affecté par `H-G1` (`UL-001`, `CAL-001`, `ADR-0010`, `DR-001`) ne mentionne un écran
> WS-004. De plus, `WSP-001` situe explicitement les scénarios multi-praticiens hors périmètre Sprint 1.
>
> **PDX-001 — Capture clinique assistée.** Apporte une pièce réelle, à distinguer avec précision.
> Le document contient une exigence déjà écrite, tirée de CLAUDE.md (AI Principles) : *"la synthèse
> proposée [...] jamais une écriture automatique dans le dossier — validation explicite du praticien,
> non contournable."* C'est exactement le type de preuve demandé par la règle méthodologique posée
> avant l'audit (*"une exigence normative qui impose cette projection à un Actor"*) — pas une
> possibilité vague. Mais cette exigence est **conditionnelle**, pas active : `PDX-001` a le statut
> `Discovery (PDX)`, n'a jamais été prototypé ni testé, et *"Blueprint : Non — et ne le sera jamais
> directement (RG-002, RG-003)."* Le document dit lui-même ce qu'il ne prouve pas : *"Que les
> praticiens souhaitent être enregistrés. Qu'une synthèse IA soit acceptable. Que cela améliore
> réellement leur travail."* L'obligation de validation qu'il entraînerait reste donc dormante, pas
> active — elle ne suffit pas, seule, à maintenir WS-004 comme Workspace du proof set M2 aujourd'hui.
>
> **Conclusions, dans l'ordre demandé :**
> 1. **WS-004 est-il aujourd'hui un Workspace au sens de WSP-001 ? Non.** À l'état actuel et démontré
>    du corpus, aucune responsabilité Actor-facing n'est active.
>    - G1 ne justifie pas WS-004 — c'est un comportement de domaine, pas une responsabilité de Workspace.
>    - PDX-001 constitue une exigence Actor-facing réelle, mais conditionnelle à l'existence future
>      d'une capacité elle-même non démontrée, non prototypée, jamais testée.
> 2. **Que doit devenir WS-004 ? Aujourd'hui, une responsabilité architecturale interne**
>    (persistance/structuration), pas un Workspace. **Conditionnellement**, si `PDX-001` progresse un
>    jour jusqu'à Validation, une projection de validation Actor-facing devra exister quelque part —
>    mais rien n'impose que ce soit sous le nom "WS-004" ni un Workspace séparé de WS-003 (pourrait
>    être un mode supplémentaire de WS-003). **Cette question reste explicitement ouverte, à ne pas
>    trancher maintenant** — la trancher préemptivement reproduirait exactement l'erreur diagnostiquée
>    (créer une case pour combler un diagramme avant qu'une activité praticien ne soit démontrée).
>
> **Le verdict porte sur l'état actuel du corpus et ne préjuge pas de la forme UX future que pourrait
> prendre PDX-001** si sa capacité sous-jacente est un jour validée.

**Statut méthodologique :** Contradiction confirmée par audit falsificateur, pas seulement à instruire.
Ne pas journaliser "WS-004 est un Application Service" comme un fait établi pour autant — c'est
l'hypothèse la plus soutenue par l'audit pour l'état actuel du corpus, pas une conclusion architecturale
actée. `ADR-0022`, `WBD-004` et les autres documents normatifs ne sont pas modifiés par cette entrée —
étape suivante : décision d'évolution via `ADR-0015` Règle 4, portant spécifiquement sur la question de
savoir s'il faut remplacer WS-004 dans le proof set M2 ou revoir la définition même du proof set.

---

## Historique

| Date | Version | Nature |
|---|---|---|
| 2026-08-06 | 1.0 | Ouverture du journal — 2 entrées initiales reprises des difficultés déjà identifiées en session sur WS-002 |
| 2026-08-06 | 1.1 | OBS-M2-003 ajoutée — non-transposition du modèle noyau+widgets de WS-002 vers les autres Workspaces, ratifiée par le Product Owner |
| 2026-08-06 | 1.2 | OBS-M2-004 et OBS-M2-005 ajoutées, suite à l'examen de `probe-dashboard-v3.html` et `probe-dossier-v1.html` — triangulation Nouveautés/Transmissions à trois échelles ; shell de navigation non défini |
| 2026-08-17 | 1.3 | Première session de test d'utilisabilité WS-002/WS-003 ([CWRM-020-APX-M2-USA](../research/specifications/CWRM-020-APX-M2-usability-script-ws002-ws003.md)) : OBS-M2-005 mise à jour (confrontation terrain de la navigation retour) ; OBS-M2-006 ajoutée (personnalisation du bandeau patient + indicateur de nouveauté non vue) |
| 2026-08-27 | 1.4 | Deuxième session de test d'utilisabilité, premier profil non médical (thérapeute, hypnose et sophrologie) : OBS-M2-007 ajoutée — friction CPP-001 sur les catégories fixes du bandeau/sidebar WS-002, reliée à OBS-M2-006 |
| 2026-08-27 | 1.5 | OBS-M2-007 refondue (Source/Situation observée/Verbatim/Interprétation minimale/Lien/Croisement/Statut méthodologique, croisement explicite CORROBORÉ/PARTIELLEMENT/NON avec OBS-M2-006) ; OBS-M2-008 ajoutée (Dashboard/Mon Espace, même session — planning en premier, contradiction du bouton "Planning", distance temporelle depuis dernier RDV) |
| 2026-09-03 | 1.6 | Troisième session de test d'utilisabilité, 2ᵉ profil non médical (kinésithérapeute) : OBS-M2-009 ajoutée (3ᵉ manifestation CPP-001 — suivi de séries de séances) ; OBS-M2-010 ajoutée (divergence non lissée avec la session 1 sur l'interaction de la sidebar, `NON CORROBORÉ`) ; OBS-M2-011 ajoutée (ambiguïté du bloc "À votre attention", rejoint OBS-M2-004) |
| 2026-09-03 | 1.7 | Quatrième session (questionnaire auto-administré), biologiste médical/hôpital — profession réelle correspondant à la ligne "Biologiste" d'une synthèse externe non vérifiée jusque-là : OBS-M2-010 mise à jour (2 votes Lecture A contre 1 accordéon — hypothèse médical/paramédical à vérifier) ; OBS-M2-011 mise à jour (pas de confusion sur "éléments en suspens" pour ce profil, `NON CORROBORÉ`) ; OBS-M2-012 ajoutée (sidebar "Antécédents" et toutes ses voisines redirigent vers le même Care Record générique — vérifié dans le code, pas seulement rapporté) |
| 2026-09-04 | 1.8 | Correction terminologique : labels Lecture A/Lecture B inversés depuis leur introduction (2026-08-27) par rapport au code et à ADR-0023 §7 Règle 3/§9 — corrigés dans ce document, `CWRM-020-APX-M2-workspace-questionnaires` et `CWRM-020-APX-M2-usability-script-ws002-ws003`. OBS-M2-010 complétée : le comportement demandé par le kiné correspond à la Lecture B explicitement écartée par ADR-0023, pas à une option égale non tranchée. Base réelle (`WS-002-WS-003-parcours-v2.html`) adaptée : bloc "À votre attention" relié à des entités nommées (corrige OBS-M2-011), sans dupliquer l'information déjà visible dans le planning |
| 2026-09-08 | 1.9 | Cinquième session (médecin généraliste retraitée) : 2ᵉ signal "clic de trop" sur Dossier. Décision du Product Owner de figer trois points avant le prochain round (patient dense) : (1) clic direct sur "Dossier" (mode intermédiaire supprimé de la base) ; (2) Lecture A explicitement figée dans le code (déjà actée par ADR-0023, désormais tracée comme telle) ; (3) OBS-M2-012 — filtrage par catégorie du Care Record, 4→9 cartes, ancrage + surlignage par section depuis chaque item de la sidebar |
| 2026-09-08 | 2.0 | OBS-M2-005 mise à jour — discussion Layout Global v3 : proposition d'un mécanisme conditionnel "Mon Espace" (reporté de la veille avant planning si besoin, sinon planning direct) écartée de la construction pour l'instant ; collision identifiée avec WS-001 (PP-002/PP-004) et avec la question WS-006 §6 jamais posée ("tâches reportées, retrouvées où le lendemain ?") — à tester au prochain round avant toute construction |
| 2026-09-08 | 2.1 | OBS-M2-003 précisée (pas contredite) suite au challenge du parcours V2.3 : ce qu'elle rejette (architecture de blocs composables pour WS-003) distingué de ce qu'elle ne rejette pas (variation du contenu à l'intérieur des modes existants, notamment Mode Clôture) ; 4 niveaux de statut explicités (architecture par modes = décision ; variabilité par métier = hypothèse appuyée ; Mode Clôture à sorties optionnelles = non testé ; variabilité par contexte de consultation = hypothèse distincte non testée) ; "widget" confirmé comme terme produit/UI interne, jamais montré au praticien, jamais un concept d'architecture |
| 2026-09-08 | 2.2 | OBS-M2-013 ajoutée — suite au challenge WS-003/WS-004 : contradiction entre la responsabilité démontrée pour WS-004 (aucune UX Actor-facing distincte de WS-003 sur les scénarios A–G) et sa classification comme Workspace (WSP-001 exige "assemblée pour un Actor", exclut explicitement "un Application Service"). Hypothèse de reclassification à instruire, pas encore actée — séquence retenue : OBS-M2 → audit ciblé ADR-0022/WSP-001/WBD-004 → décision d'évolution ADR-0015 Règle 4 si confirmée → révision WBD-004 → prototype. ADR-0022 non modifié à ce stade |
| 2026-09-08 | 2.3 | OBS-M2-013 complétée avec le résultat de l'audit falsificateur (étape 2) : G1/Clinical Authorization n'apporte aucun appui (Domain Behaviour, HR-001) ; PDX-001 apporte une exigence Actor-facing réelle mais conditionnelle à une capacité non démontrée (Discovery, jamais prototypé/testé). Conclusion : WS-004 n'est pas démontré comme Workspace aujourd'hui ; la forme UX future de PDX-001, si validé, reste explicitement non tranchée. Contradiction confirmée par audit, pas seulement à instruire — étape suivante : ADR-0015 Règle 4 |
| 2026-09-08 | 2.4 | OBS-M2-013 (étape 3) : ADR-0024 créé (Draft) — deux options présentées (remplacer WS-004 par WS-006 dans le proof set M2 / réviser la définition du proof set et potentiellement GOV-000), grille de justification CWRM-AF-001 appliquée, avis non contraignant donné (adopter l'Option A maintenant, ouvrir l'Option B séparément). En attente de décision du Product Owner — aucun document normatif encore modifié |
| 2026-09-08 | 2.5 | Décision du Product Owner : Option A retenue, Option B différée (chantier GOV-000 séparé). ADR-0024 passé à Accepted ; ADR-0022 amendé (v1.1, §2 : WS-004 retiré, WS-006 intégré, explicitement pas comme remplacement fonctionnel). Séquence de suite fixée : WBD-004 → questionnaire WS-004 → prototype WS-006 → GOV-000 |
| 2026-09-08 | 2.6 | Étape 1 de la séquence : WBD-004 amendé (v2.2 — Erratum) — responsabilité de persistance/structuration confirmée inchangée, qualification "Workspace" retirée à l'état actuel du corpus, texte v2.1 conservé avec annotations ponctuelles (table des responsabilités, section Collision de nommage), aucune nouvelle responsabilité inventée pour WS-004 |
| 2026-09-08 | 2.7 | Étape 2 de la séquence : questionnaire WS-004 reclassé dans `CWRM-020-APX-M2-workspace-questionnaires` §4 — deux questions (fiabilité/critère de fin d'une note) déplacées vers §3 pour informer le test de Mode Clôture (WS-003, écran désormais réel dans v5) ; question de nommage du Workspace retirée (sans objet) ; question de relecture personnelle conservée mais différée. Étape suivante : prototype WS-006 |
| 2026-09-08 | 2.8 | Étape 3 de la séquence : premier écran WS-006 ("Je termine") construit dans `WS-002-WS-003-parcours-v6.html` — "Consultations encore ouvertes" (état réel `consultationPaused`, pas figé), "À reporter à demain", "Avant de partir" (ACT-F001-024→027, illustratif), bouton de clôture de journée. Chaque bloc renvoyé explicitement aux 4 questions déjà écrites, jamais posées (§6). Frontière WS-006 → WS-001 volontairement laissée ouverte (OBS-M2-005), écrans non fusionnés. Aucun Blueprint WS-006 — `HYPOTHÈSE — À TESTER` intégrale. Étape suivante : GOV-000 (Option B, différée) |
| 2026-09-09 | 2.9 | Étape 4 (Option B) : `GOV-000` amendé (v1.8) — WS-004 instruit comme cas révélant un contrôle manquant, pas un modèle manquant. §5 : nouveau champ `Éligibilité` en tête du format WBD (contrôle contre `WSP-001` avant toute attribution) + verdict `NO-WORKSPACE`. §4 Gate 2 : Règle v1.8, symétrique à la Règle v1.2 (un WBD peut conclure qu'aucun Workspace ne reçoit la responsabilité). Aucune nouvelle taxonomie créée — correction en cours de route : `WSP-001` excluait déjà "un Application Service" depuis l'origine, contrairement à ce qui avait été proposé par erreur ; aucun ajout fait à ce document. `WBD-004` non modifié rétroactivement — WS-004 reste le cas révélateur, pas une exception. Séquence WBD-004→questionnaire→WS-006→GOV-000 close |
