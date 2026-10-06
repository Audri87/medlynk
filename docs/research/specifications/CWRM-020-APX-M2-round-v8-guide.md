# CWRM-020-APX-M2-R8 — Guide du Round v8
## Matrice opérationnelle des 30 hypothèses

| Field | Value |
|---|---|
| ID | CWRM-020-APX-M2-R8 |
| Version | 1.1 |
| Date | 2026-10-06 |
| Statut | Prêt pour exécution |
| Prototype | `docs/product/workspaces/WS-002-WS-003-parcours-v8.html` |
| Périmètre | WS-001, WS-002, WS-003, WS-005, WS-006, Care Record, « À traiter » |
| Sources des hypothèses | [WS-001](../../product/workspaces/WS-001-morning-brief.md) §10 · [WS-002](../../product/workspaces/WS-002-patient-context.md) §13 · [WS-003](../../product/workspaces/WS-003-consultation.md) §16 · [WS-005](../../product/workspaces/WS-005-implementation.md) · [WS-006](../../product/workspaces/WS-006-implementation.md) · [Care Record](../../product/workspaces/CARE-RECORD-implementation.md) · [À traiter](../../product/workspaces/A-TRAITER-implementation.md) |
| Cadre | [ADR-0025](../../adr/ADR-0025-innovations-produit-non-observees.md) (fiches HYP, critère d'abandon) · [ADR-0022](../../adr/ADR-0022-m2-freeze-protocol.md) §4 (sortie du gel M2) · [ADR-0020](../../adr/ADR-0020-perimetre-mandat-ws005-coordination.md) §4 (garde-fou WS-005) · [AR-001](../../AR-001-architecture-review.md) Finding-003 |

> Les hypothèses, tests et critères d'abandon de ce guide sont **repris des fiches** — ce guide ne
> les redéfinit pas. En cas d'écart, la fiche fait foi et le guide est corrigé.

---

# 1. Objectif

Le Round v8 confronte les hypothèses produit et UX au comportement réel des praticiens.

Il ne cherche pas à :

- valider le prototype en bloc ;
- faire confirmer les décisions Founder-Driven ;
- transformer une absence d'utilisation en réfutation automatique ;
- modifier la gouvernance ;
- rouvrir les ADR gelés.

Pour chaque hypothèse, le round cherche à déterminer :

1. si le problème est réel dans le scénario ;
2. si la solution apporte une valeur identifiable ;
3. si elle crée une friction ou une confusion ;
4. si le critère d'abandon est atteint ;
5. si l'hypothèse peut rester ouverte.

**Règle :** une hypothèse Founder-Driven peut être validée ou abandonnée. Son origine ne constitue
jamais une preuve.

Ce round porte aussi trois obligations de gouvernance, qui ne sont remplies que si le guide est suivi
tel quel :

| Obligation | Condition | Où dans ce guide |
|---|---|---|
| AR-001 **Finding-003** — test de la décision du 2026-10-06 | Les **4 questions §6** posées mot pour mot | Séquences 8 et 9 |
| ADR-0020 §4 — **round 1/3** du garde-fou WS-005 | Transmission, Avis **et** Délégation sondés explicitement | Séquence 5 |
| ADR-0022 §4 — sortie du gel M2 (WS-002, WS-005, WS-006) | Un round praticien conduit + une entrée Journal M2 par écart | §14 |

---

# 2. Recrutement et seuils

**Nombre de praticiens : 5 minimum.** C'est aussi le seuil de Gate 3 (GOV-000 §4 : *"tests sur au
moins 5 praticiens"*). En dessous, aucun résultat « majorité » n'est interprétable : les hypothèses
concernées restent *À tester*.

**Organisation en sessions de 45 min (décision PO, 2026-10-06).** Chaque session passe un tronc commun
puis un seul des deux modules — voir [script animateur](CWRM-020-APX-M2-round-v8-script.md) §0. Le seuil
de 5 s'applique **par hypothèse** : 5 sessions suffisent pour le tronc commun, **10 sessions** (5 par
module) sont nécessaires pour les hypothèses des modules A et B.

**Majorité** = plus de la moitié des praticiens du round ayant passé le scénario concerné (définition
des fiches HYP). Avec 5 praticiens : 3.

**Profils.** Au moins une profession absente des 6 sessions M2 et citée par les Display Rules de WS-002
(sage-femme, échographiste ou infirmière coordinatrice) — nécessaire à HYP-002-002, même si celle-ci
n'est pas testable en v8 (voir §4), pour que les autres hypothèses bénéficient de ce profil.

**Exception de seuil :** HYP-CR-002 est abandonnée dès **un seul** échec (voir §9).

---

# 3. Statuts

On utilise les statuts **déjà portés par les fiches HYP** — pas de nouveau vocabulaire (ADR-0025).

| Statut (fiche) | Signification dans ce round |
|---|---|
| **Validé** | Critère d'abandon non atteint **et** valeur observée chez la majorité |
| **Abandonné** | Critère d'abandon atteint |
| **À tester** | Le round ne permet pas de trancher (scénario non passé, effectif insuffisant, résultat partagé, prototype en cause) |
| **Résolue par décision** | Élément déjà décidé (HYP-006-004) ; le round observe ses conséquences, il ne la remet pas en cause |

> Une décision produit n'est jamais transformée en « validation terrain ». Un résultat est noté dans
> la fiche concernée, avec le round et la date (ex. *"Abandonné — round v8, 2026-10-xx"*).

---

# 4. Règles d'entretien

## Ne pas annoncer l'hypothèse

Ne pas dire : *« Nous voulons savoir si À traiter est utile. »*

Dire : *« Vous avez plusieurs choses qui nécessitent votre attention. Montrez-moi ce que vous faites. »*

## Observer avant de questionner

Pour chaque scénario :

1. laisser agir ;
2. noter le premier geste ;
3. noter les hésitations ;
4. noter les contournements ;
5. ne pas corriger immédiatement ;
6. questionner ensuite.

## Ne pas demander uniquement une opinion

Préférer : *« Qu'est-ce que vous faites aujourd'hui ? »* · *« Où allez-vous chercher cette information ? »*
· *« Qu'est-ce qui vous manque ici ? »* · *« Qu'est-ce qui vous ferait revenir demain ? »*

## Questions imposées

Les questions signalées **[MOT POUR MOT]** ne sont pas reformulées : elles conditionnent une obligation
de gouvernance (§1).

## Limites connues du prototype — à ne pas lire comme des réfutations

L'enquêteur les connaît ; si le praticien bute dessus, l'observation est notée *prototype*, pas
*hypothèse*.

- Seul **Michel Rousseau** a un dossier complet ; les autres patients n'ont qu'une ligne.
- **Une seule** consultation peut être en pause à la fois.
- Le reste-à-faire de la Clôture **ne passe pas automatiquement** dans « À traiter » (décrit dans le
  Blueprint WS-003, non construit).
- De nombreux boutons « Ouvrir », « Consulter », « Rédiger » sont inactifs.
- « + Nouvelle action » (À traiter) et les cases à cocher sont décoratifs.
- La forme de la Fiche patient hors consultation n'est **pas décidée** — la page actuelle est
  provisoire.

## Variantes de test de « À traiter »

Le sélecteur *Regrouper par Type / Provenance* et *Provenance masquée / visible* est un **instrument de
l'enquêteur**, pas une fonctionnalité. L'enquêteur le règle avant la séquence 6, hors de la vue du
praticien si possible. **Contrebalancement** : les praticiens impairs commencent par *Type + masquée*,
les pairs par *Provenance + visible* ; on bascule à mi-séquence.

---

# 5. Matrice des 30 hypothèses

30 hypothèses : 29 à tester, 1 résolue par décision (HYP-006-004).

## WS-001 — Mon espace

### HYP-001-000 — Format dashboard

**Hypothèse.** Le format actuel de « Mon espace » répond à Q-001 aussi bien que la structure historique
à trois blocs.

**Test.** Après 30 secondes : *« Qu'est-ce qui a changé depuis hier ? Qu'est-ce qui vous attend ? »*

**Abandon.** La majorité ne sait pas dire ce qui a changé → retour à la structure Signal / Horizon /
Obligations.

**À observer.** Compréhension immédiate ; capacité à distinguer changement et travail restant ;
orientation vers les patients.

### HYP-001-001 — Tuiles d'état en tête

**Hypothèse.** Une vue chiffrée du cabinet entier oriente avant la liste des patients.

**Test.** Observer où se porte le premier regard et si les tuiles apparaissent spontanément dans la
réponse à HYP-001-000.

**Abandon.** La majorité ne les utilise pas ou estime qu'elles retardent l'accès aux patients →
déplacement sous le planning ou repli.

**Vigilance.** PP-001 et PP-004 restent normatifs.

### HYP-001-002 — Continuité de travail

**Hypothèse.** Une consultation interrompue doit être reprise avant toute autre chose.

**Test.** **Après la séquence 4** (consultation mise en pause) : retour sur Mon espace — *« Que faites-vous
maintenant ? »* Le bloc n'apparaît que si une consultation est en pause : il ne peut pas être testé en
séquence 1.

**Abandon.** La majorité ne voit pas le bloc → déplacement, pas suppression (le besoin reste porté par
PP-011).

### HYP-001-003 — « À votre attention » séparée du planning

**Hypothèse.** Isoler ce qui a changé le rend plus visible que de le mélanger au planning.

**Test.** *« Ce bloc contient-il des patients en plus de ceux du planning ? »*

**Abandon.** L'ambiguïté observée dans OBS-M2-011 se reproduit chez la majorité → fusion dans le
planning via les pastilles.

**Point spécifique v8.** Tester aussi la distinction « À votre attention » = **signal** / « À traiter »
= **action**. Noter si la confusion s'étend à trois blocs (planning / attention / à traiter).

### HYP-001-004 — Pastilles sur les patients du jour

**Hypothèse.** Un signal posé sur la ligne du patient indique où se préparer.

**Test.** Comparer l'utilisation des pastilles et du bloc « À votre attention ».

**Abandon.** Conserver le mécanisme utilisé par la majorité, retirer l'autre.

### HYP-001-005 — Navigation de date / ajout de rendez-vous

**Hypothèse.** Le praticien veut préparer les jours suivants depuis Mon espace.

**Test.** *« Où gérez-vous vos rendez-vous aujourd'hui ? Changeriez-vous cela ? »*

**Abandon.** La majorité conserve son outil d'agenda → retour à « aujourd'hui seulement ».

**Attention.** Si validée, WS-001 §7 (Non-Goals) nécessiterait une décision formelle.

### HYP-001-006 — Accès rapides

**Hypothèse.** Les actions fréquentes hors patient du jour doivent être accessibles en un clic.

**Test.** Observer l'utilisation des raccourcis pendant le parcours.

**Abandon.** Non utilisés par la majorité → retrait ; la sidebar suffit.

## WS-002 — Contexte patient

### HYP-002-001 — Encart « Dernière note »

**Hypothèse.** La dernière note du praticien est le moyen le plus rapide de reprendre le fil.

**Test.** *« Qu'avez-vous regardé pour vous rappeler où vous en étiez avec ce patient ? »*

**Abandon.** La majorité utilise le bloc Continuité et ignore l'encart → fusion dans Continuité.

### HYP-002-002 — Format unique

**Hypothèse.** Un seul format, dont le contenu varie, suffit pour toutes les professions.

**Statut prévu pour ce round : À tester — non testable en v8.** Le prototype ne contient qu'un dossier
complet (suivi de diabète). Une sage-femme ou une échographiste n'y trouverait pas « son information
clé » parce qu'elle n'existe pas dans les données : un échec mesurerait le prototype, pas l'hypothèse.

**Ce que le round recueille quand même** (sans conclure) : auprès de la profession recrutée hors des 6
sessions, *« Quelle est l'information que vous cherchez en premier avant de voir un patient ? Où
serait-elle ici ? »*

**Pour un round ultérieur.** Ajouter au prototype un patient adapté à la profession recrutée, puis
appliquer le test de la fiche (information clé trouvée en moins de 30 s ; une profession échoue →
Display Rule réintroduite pour cette profession seulement).

### HYP-002-003 — Annuler / Décaler depuis WS-002

**Hypothèse.** Le praticien gère lui-même l'annulation d'un rendez-vous au moment où il regarde le
patient et souhaite en conserver le motif.

**Test.** *« Quand un rendez-vous est annulé, qui s'en occupe, et où ? »*

**Abandon.** Annulation gérée par secrétariat ou agenda externe pour la majorité → retrait des actions
de WS-002.

### HYP-002-004 — Annuaire → Care Record

**Hypothèse.** Un patient recherché dans l'annuaire n'est pas nécessairement un patient du jour : on
veut son dossier, pas sa préparation.

**Test.** *« Retrouvez Michel Rousseau depuis la recherche. »* Observer l'écran d'arrivée attendu.

**Abandon.** La majorité attend une synthèse → l'annuaire ouvre WS-002, sans démarrer de consultation
(ADR-0023 §7 R1).

## WS-003 — Consultation

### HYP-003-001 — Contexte patient permanent

**Hypothèse.** Garder allergies, pathologies et traitement visibles évite les allers-retours sans
détourner l'attention.

**Test.** Consultation simulée. Observer l'utilisation de la carte, les passages en Lookup, la
distraction ressentie. Après le scénario : *« Est-ce que cela vous a distrait ? »*

**Abandon.** La majorité ne regarde pas la carte ou se dit distraite → retour à PP-010 (Lookup plein
écran).

### HYP-003-002 — Onglets persistants

**Hypothèse.** Une navigation visible permet de retrouver historique, notes et actions sans mémoriser
les modes.

**Test.** *« Retrouvez la dernière ordonnance. »* Noter : onglet ou Lookup.

**Abandon.** Abandon conjoint avec HYP-003-001, ou majorité n'utilisant jamais les onglets.

### HYP-003-003 — Notes multiples

**Hypothèse.** Un praticien veut séparer ses notes pendant une même consultation.

**Test.** Consultation simulée avec deux sujets. Observer si le praticien crée spontanément une
deuxième note, puis : *« Pourquoi avez-vous fait cela ? »*

**Abandon.** La majorité écrit une seule note → retour à une note unique (PP-012/013).

### HYP-003-004 — Modèles dans le Brouillon

**Hypothèse.** Pré-remplir un brouillon à partir d'un modèle accélère les sorties répétitives.

**Test.** Observer l'utilisation du modèle, les modifications, la validation.

**Abandon.** Non utilisé par la majorité → retrait. Validé sans relecture → modèle éventuellement
conservé, mais l'action de validation explicite est revue (CAL-I-003).

### HYP-003-005 — Noter une action pendant une interruption

**Origine.** Founder-Driven / Innovation.

**Hypothèse.** Pouvoir noter en quelques mots une action pendant l'interruption évite de la perdre ou
de la garder en mémoire.

**Scénario.** Un confrère demande pendant la consultation : *« Pouvez-vous rappeler un autre patient à
propos de son dossier ? »* Observer si le praticien note dans MedLink, mémorise, utilise du papier ou
un autre outil.

**Garde-fou.** Texte libre minimal ; patient facultatif ; aucun autre contexte patient ouvert.

**Abandon.** La majorité ne l'utilise pas ou préfère un autre support → retrait.

**Note prototype.** La pause passe d'un à deux clics ; si le praticien le relève, c'est une friction de
l'hypothèse, à noter comme telle.

## WS-005 — Coordination / Transmission

### HYP-005-001 — Liste unique reçues / envoyées

**Hypothèse.** Une seule liste suffit pour suivre ce qui circule dans les deux sens.

**Test.** *« Qu'est-ce qui attend une action de votre part dans cette liste ? »*

**Abandon.** La majorité confond reçu et envoyé → deux listes distinctes.

**Point v8.** Vérifier que Coordination ne devient pas une seconde collection « À traiter ».

### HYP-005-002 — « Demander un avis »

**Hypothèse.** Une affordance visible peut faire émerger un besoin d'avis que les entretiens n'ont pas
capté.

**Test.** Présenter l'affordance sans l'expliquer. Observer clic, compréhension, attente associée.
Question : *« Qu'est-ce que vous vous attendez à obtenir ici ? »*

**Abandon.** Aucun critère propre : comptée dans le garde-fou d'ADR-0020 §4.

### Garde-fou ADR-0020 — questions obligatoires (séquence 5)

Pour que ce round compte comme **round 1/3** d'ADR-0020, les trois composantes sont sondées
explicitement, avec les questions déjà écrites dans
[CWRM-020-APX-WS005](CWRM-020-APX-WS005-coordination-guide.md) §4 et
[CWRM-020-APX-M2](CWRM-020-APX-M2-workspace-questionnaires.md) :

| Composante | Question |
|---|---|
| Transmission | *« À qui avez-vous transmis cela, et comment ? »* · *« Comment avez-vous reçu cette information — et qu'en avez-vous fait ensuite ? »* |
| Avis | *« Qu'est-ce qui vous a fait demander un avis à ce moment précis ? »* (si le praticien évoque une demande d'avis — sinon, noter l'absence) |
| Délégation | *« Qu'est-ce que vous avez délégué, et à qui ? Comment avez-vous su que c'était fait ? »* · *« Vous arrive-t-il de transférer une tâche ou un patient à un collègue ? Comment décidez-vous à qui, et comment le collègue sait-il quoi faire ? »* |

Comptage à reporter dans la consolidation : nombre de praticiens évoquant un **Avis** (verbatim ou
non) et une **Délégation** (verbatim ou non). C'est ce compteur qui décide, au terme du 3ᵉ round, du
maintien ou du retrait d'Avis et Délégation.

## WS-006 — Fin de journée

### HYP-006-000 — Valeur de la clôture

**Hypothèse.** Un acte explicite de clôture du travail dans MedLink apporte une valeur même si tout
reste conservé dans « À traiter ».

**Test.** *« Ouvririez-vous cet écran sans qu'on vous le demande ? À quel moment ? »* Puis, en séquence
9 : *« Vous n'êtes pas passé par cet écran hier. Vous retrouvez votre travail dans À traiter. Vous a-t-il
manqué quelque chose ? »*

**Abandon.** La majorité n'ouvre pas l'écran spontanément, **ou** retrouve son travail le lendemain sans
percevoir de manque → WS-006 retiré ; « À traiter » suffit.

**Contrainte.** La journée peut se terminer hors du logiciel (ACT-F001-027).

### HYP-006-001 — Consultations encore ouvertes

**Hypothèse.** Lister les consultations non clôturées au moment du départ évite une perte silencieuse.

**Test.** *« Vous arrive-t-il de partir avec une consultation non terminée ? Comment le savez-vous
aujourd'hui ? »*

**Abandon.** Si WS-006 est retiré, le bloc est déplacé (besoin porté par PP-014) ; sinon retrait
uniquement si la majorité ne laisse jamais de consultation ouverte.

### HYP-006-002 — Garder pour demain

**Hypothèse.** Marquer explicitement un élément comme « gardé pour demain » facilite sa reprise par
rapport à une simple persistance.

**Test.** **[MOT POUR MOT]** *« Les tâches reportées — vous les retrouvez où, le lendemain ? »* Puis :
*« Quelle différence faites-vous entre "gardé pour demain" et "simplement en attente" ? »*

**Abandon.** La majorité utilise un autre outil et ne veut pas changer, **ou** ne distingue pas les deux
états → retrait du geste spécifique.

**Important.** « Gardé pour demain » est un **état**, pas une provenance.

### HYP-006-003 — Avant de partir

**Hypothèse.** Une courte liste de vérifications réduit l'oubli d'une tâche non clinique.

**Test.** Avant de montrer la liste : **[MOT POUR MOT]** *« Qu'est-ce qui vous empêcherait de partir
tranquille, ce soir ? »* Puis réaction à : *« Dossiers enregistrés automatiquement — aucune sauvegarde à
faire. »*

**Abandon.** Aucun praticien ne cite spontanément une vérification pertinente, ou les éléments ne
relèvent pas du logiciel.

### HYP-006-004 — Éléments à traiter

**Statut : Résolue par décision (2026-10-06).** Le tableau de WS-006 est une **vue filtrée de la
collection unique « À traiter »** ; il ne possède pas de collection propre. Le round peut observer sa
valeur comme point de revue, pas remettre en cause cette propriété sans nouvelle décision.

### HYP-006-005 — Rendez-vous à planifier

**Hypothèse.** Les rendez-vous de suivi décidés mais non encore posés peuvent se perdre.

**Test.** *« Après une consultation, qui pose le prochain rendez-vous, et quand ? »*

**Abandon.** Le rendez-vous est posé pendant la consultation ou par un secrétariat pour la majorité →
retrait.

**Architecture produit.** S'il est conservé, il devient un **type d'élément « À traiter »**, pas une liste
indépendante.

### HYP-006-006 — Tuiles d'état

**Hypothèse.** Un résumé chiffré permet de juger rapidement si la journée est « propre ».

**Test.** Observer la lecture des tuiles et la navigation directe vers les tableaux.

**Abandon.** La majorité ignore les tuiles ou les juge redondantes → retrait.

### HYP-006-007 — Statistiques de la journée

**Hypothèse.** Voir ce qui a été accompli donne un sentiment de clôture et une raison de revenir.

**Test.** *« Que vous inspirent ces chiffres ? »* Observer la réaction spontanée.

**Abandon.** Réaction neutre ou négative chez la majorité → retrait.

**Vigilance.** Risque de perception comme mesure de productivité ou de surveillance.

## Care Record

### HYP-CR-001 — Vue générale

**Hypothèse.** Une synthèse clinique en tête oriente avant de descendre dans les catégories.

**Test.** Arrivée par Lecture A avec une catégorie précise : le praticien lit-il la Vue générale ou
va-t-il directement à la catégorie ?

**Abandon.** La majorité la saute → retrait ; l'ancrage par catégorie suffit.

### HYP-CR-002 — Catégories repliées

**Hypothèse.** Masquer les catégories moins consultées allège la vue sans faire perdre d'information.

**Test.** *« Retrouvez les antécédents familiaux. »* Sans passer par la sidebar.

**Abandon.** **Un seul praticien échoue** à trouver une catégorie repliée → toutes les catégories
deviennent visibles.

**Seuil volontairement bas.** Le coût d'une information clinique introuvable est supérieur au coût d'un
écran plus chargé.

## À traiter

### HYP-AT-001 — Provenance visible

**Origine.** Founder-Driven.

**Hypothèse.** Afficher la provenance réduit le temps nécessaire pour comprendre pourquoi un élément
existe.

**Test.** Variantes *provenance visible* / *provenance masquée* (contrebalancées, §4). Question :
*« Pourquoi cet élément est-il là ? »* Puis : *« Cette information vous aide-t-elle ? »*

**Abandon.** La majorité ne lit pas la provenance ou sait répondre sans elle → provenance secondaire,
au survol ou à l'ouverture.

### HYP-AT-002 — Regroupement par provenance

**Hypothèse.** Le praticien peut penser davantage en origine de l'action qu'en type de document.

**Test.** Variantes *par type* (résultats, courriers, actions, rendez-vous) / *par provenance*
(interruption, consultation, entrant, fin de journée), contrebalancées (§4). Deux tâches :
*« Retrouvez ce qui vient de votre consultation de ce matin. »* puis *« Retrouvez tous vos courriers. »*

**Abandon.** La majorité utilise le regroupement par type → retrait du regroupement par provenance.

**Note prototype.** Le groupe « Fin de journée » est vide (aucun élément n'est créé à la clôture) ; ne
pas l'interpréter.

---

# 6. Parcours de test global

Les 29 hypothèses à tester ne sont pas posées comme 29 questions indépendantes. Le round suit un
**parcours naturel** ; les questions de chaque fiche viennent après l'observation de la séquence.

| # | Consigne | Teste | Questions [MOT POUR MOT] |
|---|---|---|---|
| 1 | *« Vous commencez votre journée. Montrez-moi ce que vous faites. »* | HYP-001-000, 001, 003, 004, 005, 006 | — |
| 2 | *« Votre prochain patient arrive. Préparez la consultation. »* Puis : *« Retrouvez Michel Rousseau depuis la recherche. »* | HYP-002-001, 003, 004 (+ recueil HYP-002-002) | — |
| 3 | *« Faites votre consultation comme vous le feriez normalement. »* (deux sujets) | HYP-003-001 → 004 | — |
| 4 | *« Votre consultation est interrompue par un confrère. »* | HYP-003-005 | — |
| 4b | Retour sur Mon espace après la pause : *« Que faites-vous maintenant ? »* | **HYP-001-002** | — |
| 5 | *« Vous recevez une transmission d'un confrère. »* | HYP-005-001, 002 + garde-fou ADR-0020 (Transmission, Avis, Délégation) | — |
| 6 | *« Plusieurs éléments nécessitent encore votre attention. Montrez-moi ce que vous faites. »* | HYP-AT-001, 002 (variantes contrebalancées) | — |
| 7 | *« Vous avez besoin des coordonnées de ce patient. »* Puis : *« Retrouvez ses antécédents familiaux. »* | Fiche patient (observation, pas d'HYP), HYP-CR-001, 002 | — |
| 8 | *« Votre journée est terminée. Faites ce que vous faites normalement avant de partir. »* | HYP-006-000, 001, 003, 005, 006, 007 ; HYP-006-004 (observation) | *« Comment savez-vous que votre journée est vraiment terminée ? »* · *« Qu'est-ce qui vous empêcherait de partir tranquille, ce soir ? »* |
| 9 | *« Vous revenez le lendemain. Vous aviez plusieurs choses à faire hier. Où les retrouvez-vous ? »* | HYP-006-000 (scénario du lendemain), HYP-006-002, cohérence « À traiter », **Finding-003** | *« Le lendemain matin, est-ce que vous repensez à ce qui restait en suspens la veille — et comment vous en souvenez-vous ? »* · *« Les tâches reportées — vous les retrouvez où, le lendemain ? »* |

**Finding-003.** Les 4 questions §6 (séquences 8 et 9) sont posées **avant** de montrer l'écran ou la
solution correspondante, pour recueillir la pratique actuelle sans l'orienter. Les réponses sont la
condition de résolution d'AR-001 Finding-003 — elles sont consignées séparément (§14).

**Question transversale (fin de session) :** *« Si vous deviez revenir demain, qu'est-ce qui vous ferait
ouvrir MedLink ? »* — voir §16.

---

# 7. Fiche de collecte individuelle

Une fiche par praticien et par hypothèse.

| Champ | Valeur |
|---|---|
| Praticien | P01 |
| Profession | |
| Variante « À traiter » de départ | Type + masquée / Provenance + visible |
| Séquence | |
| Hypothèse | HYP-XXX |
| Premier geste | |
| Comportement observé | |
| Verbatim | |
| Hésitation | |
| Contournement | |
| Temps approximatif | |
| Compréhension | |
| Valeur perçue | |
| Friction | |
| Cause d'un non-usage (§8) | |
| Limite du prototype en cause ? | Oui / Non |
| Critère d'abandon atteint | Oui / Non |
| Résultat individuel | Validé / Abandonné / À tester |
| Commentaire | |

---

# 8. Règle d'interprétation

Une absence d'utilisation n'est pas automatiquement une réfutation. Distinguer :

- fonctionnalité non découverte ;
- fonctionnalité mal comprise ;
- fonctionnalité inutile ;
- fonctionnalité incompatible avec le workflow ;
- solution remplacée naturellement par une autre ;
- absence de besoin dans ce scénario ;
- refus explicite ;
- valeur présente mais insuffisamment visible ;
- **limite du prototype** (§4).

Seuls « inutile », « incompatible », « remplacée », « refus explicite » comptent pour un critère
d'abandon formulé en termes de non-usage. « Non découverte » et « mal comprise » sont des frictions
de présentation : elles laissent l'hypothèse *À tester* et alimentent une itération du prototype.

---

# 9. Consolidation finale

| ID | Hypothèse | P1 | P2 | P3 | P4 | P5 | Résultat |
|---|---|---|---|---|---|---|---|
| HYP-001-000 | Format dashboard | | | | | | |
| HYP-001-001 | Tuiles | | | | | | |
| HYP-001-002 | Continuité de travail | | | | | | |
| HYP-001-003 | « À votre attention » séparée | | | | | | |
| HYP-001-004 | Pastilles | | | | | | |
| HYP-001-005 | Navigation de date | | | | | | |
| HYP-001-006 | Accès rapides | | | | | | |
| HYP-002-001 | Dernière note | | | | | | |
| HYP-002-002 | Format unique | — | — | — | — | — | À tester (non testable en v8) |
| HYP-002-003 | Annuler / Décaler | | | | | | |
| HYP-002-004 | Annuaire → Care Record | | | | | | |
| HYP-003-001 | Contexte permanent | | | | | | |
| HYP-003-002 | Onglets persistants | | | | | | |
| HYP-003-003 | Notes multiples | | | | | | |
| HYP-003-004 | Modèles | | | | | | |
| HYP-003-005 | Action pendant interruption | | | | | | |
| HYP-005-001 | Liste reçues / envoyées | | | | | | |
| HYP-005-002 | « Demander un avis » | | | | | | |
| HYP-006-000 | Valeur de la clôture | | | | | | |
| HYP-006-001 | Consultations ouvertes | | | | | | |
| HYP-006-002 | Garder pour demain | | | | | | |
| HYP-006-003 | Avant de partir | | | | | | |
| HYP-006-004 | Éléments à traiter | — | — | — | — | — | Résolue par décision |
| HYP-006-005 | Rendez-vous à planifier | | | | | | |
| HYP-006-006 | Tuiles d'état | | | | | | |
| HYP-006-007 | Statistiques | | | | | | |
| HYP-CR-001 | Vue générale | | | | | | |
| HYP-CR-002 | Catégories repliées | | | | | | |
| HYP-AT-001 | Provenance visible | | | | | | |
| HYP-AT-002 | Regroupement par provenance | | | | | | |

Colonne finale : **Validé / Abandonné / À tester / Résolue par décision** (§3).

---

# 10. Sorties du round

Le round produit, dans cet ordre :

1. **Fiches HYP mises à jour** — statut, round, date, justification, dans chaque fiche source
   (en-tête du document).
2. **Finding-003** — réponses aux 4 questions §6, consolidées ; annotation d'AR-001 indiquant si la
   décision du 2026-10-06 est confirmée, révisée (critères HYP-006-000 / HYP-006-002) ou toujours
   ouverte. AR-001 n'est pas rouvert.
3. **ADR-0020** — compteur Avis / Délégation après le round 1/3, reporté dans
   [WS-005-implementation](../../product/workspaces/WS-005-implementation.md). ADR-0020 n'est pas modifié.
4. **Journal M2** — une entrée `OBS-M2-NNN` dans
   [M2-JOURNAL-observations](../../product/M2-JOURNAL-observations.md) pour chaque écart rencontré
   (ADR-0022 §3, seuil de journalisation : contournement du workflow, décision de scope imprévue,
   contradiction avec ce que M2 dit faire). C'est une condition de sortie du gel M2 (ADR-0022 §4).
5. **Corpus** — les verbatims utiles au Discovery sont reversés selon CWRM-020 (ACT / OBS), pas
   seulement dans les fiches produit.

---

# 11. Ce que le Round v8 ne doit pas faire

Il ne doit pas :

- modifier ADR-0023, ADR-0020, ADR-0022 ou GOV-000 ;
- créer un nouvel ADR ;
- créer un nouveau concept Domain ;
- considérer « non observé » comme « invalidé » ;
- considérer « Founder-Driven » comme « validé ».

---

# 12. Critère de réussite du round

Le round est réussi si, à son terme, nous pouvons répondre clairement :

> **Pour chacune des 30 hypothèses, savons-nous ce que nous avons appris, ce qui est validé, ce qui est
> abandonné et ce qui reste réellement ouvert ?**

Le but n'est pas d'obtenir 30 validations. Le but est de **réduire l'incertitude sans fabriquer de
certitude**.

---

# 13. KPI produit

Question transversale à tout le round :

> **« Si vous deviez revenir demain, qu'est-ce qui vous ferait ouvrir MedLink ? »**

Cette réponse est analysée **séparément** des préférences d'interface. Elle renvoie au KPI produit :
**A reason to come back tomorrow.**

---

## Évolution

| Version | Date | Nature |
|---|---|---|
| 1.0 | 2026-10-06 | Création — guide du Round v8 rédigé par le Product Owner, intégré avec neuf corrections : (1) 4 questions §6 de Finding-003 ajoutées mot pour mot (séquences 8 et 9) ; (2) questions Délégation et Avis ajoutées pour que le round compte comme round 1/3 d'ADR-0020 ; (3) HYP-002-002 marquée *À tester — non testable en v8* (un seul dossier complet dans le prototype) ; (4) HYP-001-002 déplacée après la séquence 4 (le bloc n'existe qu'avec une consultation en pause) ; (5) « majorité » et effectif minimal (5, seuil Gate 3) définis ; (6) statuts alignés sur ceux des fiches HYP (Validé / Abandonné / À tester / Résolue par décision) au lieu d'un vocabulaire nouveau ; (7) variantes « À traiter » pilotées par l'enquêteur et contrebalancées ; (8) sorties vers le Journal M2 (ADR-0022 §4), AR-001 et WS-005 précisées ; (9) limites connues du prototype listées pour ne pas être lues comme des réfutations. |
| 1.1 | 2026-10-06 | Sessions de 45 min (décision PO) : tronc commun + Module A ou B, défini dans le [script animateur](CWRM-020-APX-M2-round-v8-script.md). Le seuil de 5 praticiens s'applique par hypothèse → 10 sessions pour les hypothèses des modules. Le guide reste la référence des hypothèses ; le script, celle de la conduite des sessions. |
