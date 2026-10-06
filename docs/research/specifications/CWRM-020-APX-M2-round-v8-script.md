# CWRM-020-APX-M2-R8-SCRIPT — Round v8 · Script de l'animateur

| Field | Value |
|---|---|
| ID | CWRM-020-APX-M2-R8-SCRIPT |
| Version | 1.1 |
| Date | 2026-10-06 |
| Durée | **45 minutes** par session |
| Organisation | Tronc commun (toutes les sessions) + **Module A ou Module B** (en alternance) |
| Prototype | `docs/product/workspaces/WS-002-WS-003-parcours-v8.html` |
| Référence | [Guide du Round v8](CWRM-020-APX-M2-round-v8-guide.md) — hypothèses, critères d'abandon, statuts, consolidation. **En cas d'écart, le guide fait foi.** |

> Ce script dit **quoi dire, quoi ne pas dire, quoi observer**. Il est écrit pour pouvoir être conduit
> par un animateur qui ne connaît pas les documents internes de MedLink : aucun identifiant n'est à
> prononcer devant le praticien. Les identifiants HYP servent uniquement à la prise de notes.

---

# 0. Organisation du round

## Pourquoi des modules

45 minutes ne permettent pas de couvrir les 29 hypothèses à tester. Chaque session passe le **tronc
commun**, puis **un seul module** :

| Session | Module |
|---|---|
| P01, P03, P05, P07, P09 | **A** — Travail restant, dossier, transmission |
| P02, P04, P06, P08, P10 | **B** — Fin de journée et lendemain |

## Conséquence sur le nombre de praticiens

Le seuil « majorité » du guide s'applique **par hypothèse** : il faut au moins 5 praticiens ayant passé
le scénario concerné.

| Hypothèses | Passées par | Praticiens nécessaires |
|---|---|---|
| Tronc commun | toutes les sessions | 5 |
| Module A ou Module B | une session sur deux | **5 par module → 10 sessions au total** |

Avec moins de 10 sessions, le round reste exploitable, mais les hypothèses d'un module passé par moins de
5 praticiens restent *À tester* — elles ne sont ni validées ni abandonnées.

## Ce que porte chaque partie

| Partie | Hypothèses | Obligation de gouvernance |
|---|---|---|
| Tronc commun | HYP-001-000 → 006 · HYP-002-001, 003, 004 · HYP-003-001 → 005 | — |
| Module A | HYP-AT-001, 002 · HYP-CR-001, 002 · Fiche patient · HYP-005-001, 002 | **ADR-0020** — round 1/3 (Transmission, Avis, Délégation) |
| Module B | HYP-006-000 → 007 · HYP-001-002 (lendemain) | **AR-001 Finding-003** — les 4 questions §6 |

HYP-002-002 n'est pas testée en v8 (voir guide). HYP-006-004 est résolue par décision : observée
seulement.

---

# 1. Préparation de l'animateur — avant chaque session

1. **Recharger la page** du prototype : l'état (pause, éléments ajoutés, « gardé pour demain ») est
   remis à zéro.
2. Rester sur **Mon espace**.
3. **Module A uniquement** — régler les variantes de « À traiter » (encadré pointillé « Variante de
   test », écran À traiter) **avant** la session, hors de la vue du praticien :
   - sessions P01, P05, P09 : *Type* + *Masquée* ;
   - sessions P03, P07 : *Provenance* + *Visible*.
4. Préparer la fiche de collecte (guide §7) et noter : numéro de session, profession, module.
5. Connaître les limites du prototype (§12) — sans jamais les annoncer.

---

# 2. Règle fondamentale

Le praticien ne doit pas avoir l'impression de passer un examen.

Nous ne cherchons pas à savoir *« Est-ce que vous aimez cette fonctionnalité ? »* mais *« Est-ce que
cette interface vous permet naturellement de faire ce que vous cherchez à faire ? »*

**Le praticien peut** : parler à voix haute, utiliser l'interface librement, chercher ses propres
chemins, se tromper, revenir en arrière, dire qu'il ne comprend pas, proposer une autre manière de
faire.

**L'animateur** : n'explique pas l'interface, ne donne pas le nom des fonctionnalités, ne suggère pas le
chemin attendu, ne défend jamais une décision produit, ne corrige pas immédiatement une mauvaise
interprétation.

**Un comportement observé vaut plus qu'une opinion déclarée.** *« J'aimerais avoir cette information »*
est une opinion. *Le praticien cherche pendant 35 secondes dans trois écrans différents* est une
observation.

---

# 3. Introduction — 2 min

> « Je vais vous montrer un prototype de logiciel destiné à accompagner votre journée de travail.
> Il n'y a pas de bonne ou de mauvaise réponse. Ce qui nous intéresse, c'est ce que vous feriez
> spontanément.
> Si quelque chose n'est pas clair, dites-le. Si vous cherchez quelque chose qui n'existe pas,
> dites-moi aussi ce que vous auriez attendu.
> Je vais volontairement éviter de vous expliquer comment fonctionne le logiciel.
> C'est un prototype : certains boutons ne font rien. Si cela arrive, dites-moi simplement ce que vous
> vous attendiez à voir. »

Puis :

> « Imaginez que vous arrivez au cabinet ce matin et que vous ouvrez MedLink pour commencer votre
> journée. »

---

# TRONC COMMUN — 25 min

## T1. Arrivée dans MedLink — 5 min

**Consigne :** *« Vous commencez votre journée. Faites ce que vous feriez normalement. »* Ne rien
ajouter.

**Après 30 secondes** (avant toute autre question) :

> « Qu'est-ce qui a changé depuis hier ? Qu'est-ce qui vous attend aujourd'hui ? »

**Observer** : premier regard · patients du jour identifiés · compréhension des blocs · distinction
planning / « À votre attention » / éléments à traiter · compréhension des compteurs · tuiles citées ou
non · utilisation des raccourcis · navigation de date.

**Questions après observation :**

- *« Ce bloc (montrer « À votre attention ») contient-il des patients en plus de ceux de votre
  planning ? »*
- *« Où gérez-vous vos rendez-vous aujourd'hui ? Changeriez-vous cela ? »*

**Notes :** HYP-001-000, 001, 003, 004, 005, 006. (HYP-001-002 : en T4b, pas ici.)

**Relance si besoin :** *« Qu'est-ce que vous cherchez à comprendre maintenant ? »*

## T2. Préparer le patient — 5 min

**Consigne :** *« Votre patient de 10h30 va arriver. Préparez-vous à le recevoir. »*

> ⚠ Seul ce patient (Michel Rousseau) a un dossier complet dans le prototype. La consigne l'impose sans
> le nommer. Ne pas laisser le praticien s'engager dans un autre patient : si c'est le cas, *« Prenons
> plutôt celui de 10h30. »*

**Observer** : le praticien comprend-il le contexte du patient ? Cherche-t-il l'historique, une dernière
note, autre chose ? Repère-t-il ce qui est nouveau ?

**Questions :**

- *« Qu'avez-vous regardé pour vous rappeler où vous en étiez avec ce patient ? »*
- *« Qu'est-ce qui vous manque pour commencer ? »* — question importante, noter mot pour mot.
- *« Quand un rendez-vous est annulé, qui s'en occupe, et où ? »*

**Puis :** revenir sur Mon espace, et *« Retrouvez ce même patient en passant par la recherche. »*
Observer l'écran d'arrivée : *« Est-ce l'écran que vous attendiez ? »*

**Notes :** HYP-002-001, 003, 004.

## T3. Consultation — 9 min

**Consigne :** *« Vous êtes maintenant avec ce patient. Faites dans MedLink ce que vous auriez besoin de
faire pendant cette consultation. »*

**À mi-parcours, introduire un second sujet :** *« Le patient vous parle aussi d'une douleur au genou
apparue la semaine dernière. »* — sans rien suggérer sur la manière de le noter.

**Puis :** *« Retrouvez la dernière ordonnance de ce patient. »*

**Observer :**

- patient actif identifié ; le praticien sait-il où il se trouve ;
- regarde-t-il la carte de contexte à droite pendant l'échange ;
- crée-t-il une deuxième note pour le second sujet ;
- utilise-t-il un modèle ; le modifie-t-il avant de valider ;
- ordonnance retrouvée par les onglets ou par le dossier ;
- **phrases à noter mot pour mot** : *« Il faudrait que je… »*, *« Je dois penser à… »*, *« Je vais faire
  ça plus tard »*, *« Je note ça où ? »* — signaux pour « À traiter ».

**Questions après le scénario :**

- *« Est-ce que quelque chose vous a distrait pendant l'échange ? »*
- Si deux notes : *« Pourquoi avez-vous fait cela ? »*

**Notes :** HYP-003-001, 002, 003, 004.

## T4. Interruption — 4 min

**Consigne :** *« Un confrère passe la tête par la porte : il vous demande de rappeler une de vos
patientes, Mme Dupont, à propos de son dossier. Vous ne pouvez pas le faire maintenant. Faites ce que
vous feriez dans le logiciel avant de vous occuper de lui. »*

Ne jamais prononcer : *pause*, *interruption*, *À traiter*, *action*.

**Observer :** le praticien cherche-t-il à noter la demande ? Utilise-t-il « Mettre en pause » ?
Comprend-il le champ proposé ? Note-t-il ailleurs (papier, mémoire, autre outil) ? Relève-t-il que la
pause demande deux clics ?

**Question après l'action :** *« Qu'est-ce que vous pensez qu'il va se passer avec ce que vous venez de
noter ? »*

**Notes :** HYP-003-005.

## T4b. Retour — 2 min

Le prototype revient sur Mon espace après la pause.

**Consigne :** *« Le confrère est reparti. Que faites-vous maintenant ? »*

**Observer :** voit-il le bloc de reprise de la consultation ? Reprend-il là où il en était ?

**Notes :** HYP-001-002.

---

# MODULE A — Travail restant, dossier, transmission — 14 min

## A1. Travail restant — 5 min

**Consigne :** *« Plusieurs choses nécessitent encore votre attention. Montrez-moi ce que vous
faites. »* Laisser trouver le chemin.

**Une fois sur la liste :** *« Qu'est-ce que vous pensez trouver ici ? »* puis, en montrant un élément :
*« Pourquoi cet élément est-il là ? »*

**Deux tâches :**

1. *« Retrouvez ce qui vient de votre consultation de ce matin. »*
2. *« Retrouvez tous vos courriers. »*

**À mi-module, basculer la variante** (encadré « Variante de test ») et refaire une des deux tâches.
Puis : *« Cette information sur l'origine de l'élément vous aide-t-elle ? »*

Ne pas demander *« Préférez-vous par provenance ou par type ? »*.

**Notes :** HYP-AT-001, HYP-AT-002. Noter la variante de départ.

## A2. Dossier et coordonnées — 4 min

**Consigne 1 :** *« Vous devez appeler ce patient. Retrouvez ses coordonnées. »*

**Observer :** où cherche-t-il ? Trouve-t-il la fiche patient ? Revient-il facilement d'où il venait ?

**Consigne 2 :** depuis le dossier de Michel Rousseau, *« Retrouvez ses antécédents familiaux. »* —
sans passer par le menu de gauche.

**Observer :** lit-il la vue générale en tête ou va-t-il directement à la catégorie ? Trouve-t-il la
catégorie repliée (« Plus ▾ ») ? **Un échec suffit à conclure HYP-CR-002** : le noter précisément.

**Notes :** Fiche patient (observation), HYP-CR-001, HYP-CR-002.

## A3. Transmission — 5 min

**Consigne :** *« Vous recevez une information d'un confrère concernant un patient, et elle demande une
action de votre part. Montrez-moi ce que vous feriez. »*

**Observer :** où cherche-t-il ? Distingue-t-il reçu et envoyé ? Considère-t-il la liste comme un
historique ou comme une liste de tâches ? Clique-t-il sur « Demander un avis à un confrère » ?

**Questions :**

- *« Qu'est-ce qui attend une action de votre part dans cette liste ? »*
- *« Si vous ne faites pas cette action maintenant, où allez-vous la retrouver ? »*
- Si le bouton d'avis a été vu : *« Qu'est-ce que vous vous attendez à obtenir ici ? »*

**Questions obligatoires [MOT POUR MOT]** — condition du round 1/3 d'ADR-0020 :

- *« À qui avez-vous transmis cela, et comment ? »*
- *« Comment avez-vous reçu cette information — et qu'en avez-vous fait ensuite ? »*
- *« Qu'est-ce qui vous a fait demander un avis à ce moment précis ? »* — seulement si le praticien
  évoque une demande d'avis ; sinon, noter « Avis non évoqué ».
- *« Qu'est-ce que vous avez délégué, et à qui ? Comment avez-vous su que c'était fait ? »*
- *« Vous arrive-t-il de transférer une tâche ou un patient à un collègue ? Comment décidez-vous à qui,
  et comment le collègue sait-il quoi faire ? »*

**Notes :** HYP-005-001, HYP-005-002. **Compter** : Avis évoqué (oui/non, verbatim ?), Délégation
évoquée (oui/non, verbatim ?).

---

# MODULE B — Fin de journée et lendemain — 14 min

## B1. Avant de montrer quoi que ce soit — 3 min

Toujours sur Mon espace, **avant** que le praticien n'ouvre un autre écran :

**Questions obligatoires [MOT POUR MOT]** — Finding-003 :

- *« Comment savez-vous que votre journée est vraiment terminée ? »*
- *« Qu'est-ce qui vous empêcherait de partir tranquille, ce soir ? »*

Noter les réponses mot pour mot. Ne rien commenter.

## B2. Départ — 6 min

**Consigne :** *« Il est 18h30. Vous allez quitter le cabinet. Faites ce que vous feriez normalement avant
de partir. »*

Ne pas dire *« Faites votre clôture »* ni *« Utilisez la fin de journée »*.

**Observer :** va-t-il spontanément vers « Terminer ma journée » ? Cherche-t-il les consultations
ouvertes, les actions restantes, les rendez-vous ? Lit-il les tuiles ? Les statistiques ? Fait-il
confiance à l'enregistrement automatique ?

**S'il rencontre un élément non terminé :** *« Vous devez partir maintenant. Que faites-vous de cet
élément ? »* — ne pas montrer « Garder pour demain ». S'il l'utilise ou le découvre : *« Qu'est-ce que
signifie pour vous cette action ? »* puis *« Où vous attendez-vous à retrouver cet élément demain ? »*

**Questions après observation :**

- *« Ouvririez-vous cet écran sans qu'on vous le demande ? À quel moment ? »*
- *« Vous arrive-t-il de partir avec une consultation non terminée ? Comment le savez-vous
  aujourd'hui ? »*
- *« Après une consultation, qui pose le prochain rendez-vous, et quand ? »*
- En montrant les chiffres de la journée : *« Que vous inspirent ces chiffres ? »*
- En montrant la ligne sur l'enregistrement automatique : réaction spontanée, sans question orientée.

**Notes :** HYP-006-000, 001, 003, 005, 006, 007 · HYP-006-004 (observation).

## B3. Le lendemain — 5 min

Cliquer sur « Retour à Mon espace » (ou y revenir), puis :

> « Nous sommes le lendemain matin. Vous revenez au cabinet. »

> ⚠ Le prototype ne change pas de date : ne pas le relever, sauf si le praticien le fait (noter alors
> *limite du prototype*).

**Questions obligatoires [MOT POUR MOT]** — Finding-003, **avant** toute navigation :

- *« Le lendemain matin, est-ce que vous repensez à ce qui restait en suspens la veille — et comment
  vous en souvenez-vous ? »*
- *« Les tâches reportées — vous les retrouvez où, le lendemain ? »*

**Puis :** *« Vous aviez plusieurs choses à faire hier. Où les retrouvez-vous ? »* Observer le chemin.

**Questions :**

- *« Quelle différence faites-vous entre ce que vous aviez gardé pour demain et ce qui était simplement
  en attente ? »*
- Si le praticien n'était pas passé par l'écran de fin de journée en B2 : *« Vous n'êtes pas passé par
  l'écran de fin de journée hier. Vous a-t-il manqué quelque chose ce matin ? »*

**Notes :** HYP-006-000 (lendemain), HYP-006-002, réponses Finding-003.

---

# CLÔTURE — 3 min (toutes les sessions)

> « Si vous utilisiez MedLink demain matin, qu'est-ce qui vous ferait gagner du temps par rapport à
> votre manière actuelle de travailler ? Et qu'est-ce qui vous en ferait perdre ? »

> « Y a-t-il quelque chose que vous vous attendiez à trouver et que vous n'avez pas trouvé ? »

**Question centrale [MOT POUR MOT]** — noter la réponse mot pour mot, ne rien suggérer :

> **« Demain matin, pourquoi ouvririez-vous MedLink ? »**

KPI : *A reason to come back tomorrow* — analysé séparément des préférences d'interface.

---

# 10. Relances — dans cet ordre

1. **Neutre** — *« Qu'est-ce que vous cherchez ? »*
2. **Compréhension** — *« Qu'est-ce que vous vous attendiez à trouver ici ? »*
3. **Blocage** — *« Qu'est-ce que vous feriez maintenant si vous étiez réellement au cabinet ? »*
4. **Clarification** — *« Qu'est-ce qui vous ferait penser que votre travail est terminé ? »*

Éviter toute question qui contient déjà la solution.

---

# 11. Ce que l'animateur ne dit jamais

> « Ici vous avez À traiter. »
> « Vous pouvez mettre la consultation en pause. »
> « Regardez la dernière note. »
> « Cette information est dans le Care Record. »
> « Vous pouvez garder ça pour demain. »
> « Les éléments sont regroupés par provenance. »

Ces formulations transforment le test en démonstration.

---

# 12. Limites du prototype — à connaître, jamais à annoncer

Si le praticien bute dessus, noter *limite du prototype* — ce n'est pas une réfutation.

- Seul Michel Rousseau (patient de 10h30) a un dossier complet.
- Une seule consultation peut être en pause à la fois.
- Le reste-à-faire de la clôture d'une consultation ne passe pas automatiquement dans la liste des
  éléments à traiter.
- Beaucoup de boutons « Ouvrir », « Consulter », « Rédiger » sont inactifs ; « + Nouvelle action » et les
  cases à cocher aussi.
- La date ne change pas au « lendemain ».
- La présentation de la fiche patient hors consultation est provisoire.

---

# 13. Après chaque session

**Ne pas modifier le prototype entre deux sessions.**

1. Remplir la fiche de collecte du guide (§7) pour chaque hypothèse passée — y compris *cause d'un
   non-usage* et *limite du prototype en cause*.
2. Résultat individuel avec les statuts du guide (§3) : **Validé / Abandonné / À tester** ;
   HYP-006-004 reste *Résolue par décision*. Une décision produit n'est jamais notée comme validation
   terrain.
3. Recopier séparément, mot pour mot : les réponses Finding-003 (Module B), le comptage Avis /
   Délégation (Module A), la réponse à la question centrale.

La consolidation et ses sorties (fiches HYP, AR-001, WS-005, Journal M2, corpus) suivent le guide §9 et
§10.

---

## Évolution

| Version | Date | Nature |
|---|---|---|
| 1.0 | 2026-10-06 | Création — script animateur rédigé par le Product Owner, réaligné sur le Guide du Round v8. Sessions de **45 min** (décision PO) : tronc commun + Module A ou B en alternance, d'où **10 sessions** nécessaires pour 5 praticiens par hypothèse. Script conduisible par un animateur tiers (aucun identifiant prononcé, préparation explicite). Ajouts pour que chaque hypothèse soit réellement déclenchée : patient de 10h30 imposé, second sujet en consultation, interruption avec demande concrète, retour après pause (HYP-001-002), coordonnées et antécédents familiaux, séquence « lendemain ». Questions [MOT POUR MOT] : 4 questions §6 (Finding-003, Module B) et Transmission/Avis/Délégation (ADR-0020, Module A). Statuts et fiche de collecte renvoyés au guide. |
| 1.1 | 2026-10-06 | Limite retirée : l'écran de fin de journée affiche désormais toute consultation ouverte, en pause (« Reprendre ») ou en cours (« Retourner »). |
