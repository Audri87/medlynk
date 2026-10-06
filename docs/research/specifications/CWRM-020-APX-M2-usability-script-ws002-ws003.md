# CWRM-020-APX-M2-USA — Script de test utilisateur : WS-002 / WS-003

---

## 0. Metadata

| Field | Value |
|---|---|
| Document ID | CWRM-020-APX-M2-USA |
| Title | Usability Test Script — WS-002 (Patient Context) / WS-003 (Consultation) |
| Version | 0.2 |
| Status | Draft — Instrument non normatif (supplément informatif à CWRM-020) |
| Layer | 100 — Method (application ciblée) |
| Date | 2026-08-13 |
| Authors | Product Owner (script initial), reformulé et complété en session |
| Depends on | [CWRM-020](CWRM-020-interview-protocol.md) §7.4 (IP-REQ-018/019/020 — questions ouvertes, non-directives) · [CWRM-020-APX-M2-workspace-questionnaires](CWRM-020-APX-M2-workspace-questionnaires.md) §2/§3 · [ADR-0023](../../adr/ADR-0023-patient-context-consultation-care-record.md) |
| Consommé par | Toute session de test praticien sur `WS-002-WS-003-parcours-v2.html` |
| Origine | Script rédigé par le Product Owner le 2026-08-13, complété pour boucler avec les questions déjà ouvertes dans le corpus |

### Changelog

| Version | Date | Nature |
|---|---|---|
| 0.1 | 2026-08-13 | Script initial du Product Owner — contexte praticien, exploration libre, 3 scénarios |
| 0.2 | 2026-08-13 | Ajout : capture de métadonnées participant, rappel d'enregistrement, ancrage explicite des questions déjà ouvertes (densité des tags, sidebar Lecture A/B) dans les scénarios, debrief de clôture, grille d'observation reliée à CWRM-020-APX-M2 §2/§3 et au [M2-JOURNAL-observations](../../product/M2-JOURNAL-observations.md) |

---

## 1. Statut de ce document

Ce document **n'est pas une nouvelle spécification CWRM**. C'est un supplément d'application de
[CWRM-020](CWRM-020-interview-protocol.md), au même titre que
[CWRM-020-APX-WS005](CWRM-020-APX-WS005-coordination-guide.md) — mais pour un objet différent : ici,
pas un entretien narratif sur le travail (IP-REQ-019, ancré sur une journée passée), mais un **test
d'utilisabilité modéré** sur le prototype `WS-002-WS-003-parcours-v2.html`, avec exploration libre
puis scénarios à faire réaliser.

Les principes de CWRM-020 qui s'appliquent quand même, sans exception :

- **IP-REQ-018** (questions ouvertes) — aucune question ne doit indiquer où cliquer.
- **IP-REQ-020** (probing autorisé uniquement) — pas de question orientée vers une réponse attendue.
- **Phase 1 de CWRM-020 §7.4** — présenter l'objectif de la recherche sans révéler les hypothèses de conception testées.

Ce que ce document ajoute, propre au test d'utilisabilité (hors du périmètre normatif de CWRM-020) :
tâches à réaliser, observation du comportement (pas seulement du discours), scénarios chronométrés.

**Ce script ne teste que ce qui existe dans le prototype.** Le Mode Interruption/Recovery (5ᵉ mode de
WS-003, ADR-0023 §4) n'est pas implémenté — si un praticien tente de le déclencher spontanément,
c'est une donnée à noter (voir §6), pas un échec de script.

---

## 2. Avant la session

**Enregistrement.** Enregistrer au minimum l'audio (écran + voix si possible), avec l'accord du
praticien — même pour un test informel, dites-le explicitement avant de commencer et laissez-le
refuser sans justification. Sans enregistrement, l'essentiel de ce qui compte ici (les hésitations,
ce qu'il cherche du regard, ce qu'il ignore) se perd à la réécriture.

**Métadonnées à noter avant de commencer** (permet de savoir plus tard si une observation est
transversale ou spécifique à un profil, cf. le principe de diversité de profession de CWRM-020
IP-REQ-005/007, appliqué ici de façon allégée, pas comme échantillonnage formel) :

| Champ | Valeur |
|---|---|
| Profession | |
| Années d'expérience | |
| Cadre d'exercice (cabinet seul, groupe, hôpital…) | |
| Logiciel actuellement utilisé | |
| Date du test | |

---

## 3. Contexte donné au praticien

*(reprise du texte du Product Owner, inchangé — déjà conforme à IP-REQ-018/020 : explique le
principe sans révéler quoi cliquer)*

### Pourquoi vous participez

Nous travaillons actuellement sur MedLink, une nouvelle approche du logiciel de travail des
professionnels de santé.

L'objectif n'est pas simplement de créer un nouveau dossier patient, mais de concevoir un outil qui
aide le praticien à reprendre rapidement le contexte d'un patient, agir pendant la consultation et
retrouver de la profondeur clinique lorsqu'il en a besoin.

Le prototype que vous allez tester est encore en conception. Certaines informations, formulations ou
fonctionnalités sont volontairement simplifiées ou fictives.

Nous ne cherchons pas à tester vos connaissances informatiques.

Nous cherchons à comprendre :
- ce que vous comprenez spontanément ;
- ce que vous recherchez ;
- ce qui vous paraît naturel ;
- ce qui vous semble inutile ou trop présent ;
- ce qui vous manque ;
- et surtout si le parcours correspond à votre manière réelle de travailler.

### Le principe du parcours

MedLink est organisé autour de trois niveaux de travail :

**Mon Espace** — Votre point d'entrée quotidien : votre journée, vos patients, ce qui mérite votre
attention.

**Patient Context (WS-002)** — Lorsque vous ouvrez un patient, MedLink vous présente le contexte
nécessaire pour comprendre pourquoi ce patient est devant vous aujourd'hui.

**Consultation (WS-003)** — Lorsque vous décidez de commencer la consultation, vous entrez dans un
espace de travail volontairement plus épuré, conçu pour vous laisser vous concentrer sur le patient.

Le Care Record reste disponible lorsque vous avez besoin d'aller plus profondément dans l'histoire
clinique du patient.

**Le prototype ne cherche donc pas à remplacer l'intégralité du dossier médical. Il cherche à vous
présenter la bonne profondeur d'information au bon moment.**

---

## 4. Exploration libre (2–3 minutes)

Ne pas commencer par une instruction de clic. Consigne :

> *"Prenez quelques minutes pour parcourir librement le prototype. Imaginez que vous venez de
> commencer votre journée et que vous utilisez MedLink comme votre outil de travail. Dites-nous à
> voix haute ce que vous comprenez, ce que vous cherchez et ce qui vous surprend. Il n'y a pas de
> bonne ou de mauvaise réponse."*

**Ce que l'observateur note, sans intervenir** : par où il commence, ce qu'il ignore complètement, ce
sur quoi il s'arrête sans qu'on le lui demande, tout mot qu'il utilise spontanément pour décrire ce
qu'il voit (utile pour comparer son vocabulaire à celui du corpus — PP-NNN, DR-NNN).

---

## 5. Scénarios

### Scénario 1 — Début de journée

> *"Vous commencez votre journée. Vous avez plusieurs patients prévus. Que faites-vous en premier ?"*

**Observer** : le Dashboard. Est-ce que le Planning du jour et les blocs de contexte par
rendez-vous (les mini-blocs sous chaque patient) sont lus, ignorés, ou mal interprétés ?

### Scénario 2 — Patient (WS-002)

> *"Vous allez maintenant recevoir Michel Rousseau. Vous venez d'ouvrir sa fiche. Avant de commencer
> votre consultation, dites-moi ce que vous cherchez à comprendre."*

**Observer** : WS-002 — les 4 blocs (Présence / Continuité / Intention / Historique). Complète le
scénario par ces deux points, déjà identifiés comme non tranchés dans le corpus (à poser seulement
si le comportement spontané ne les a pas révélés) :

- *Densité du bandeau patient* — reprend telle quelle la question déjà ajoutée le 2026-08-06 dans
  [CWRM-020-APX-M2-workspace-questionnaires](CWRM-020-APX-M2-workspace-questionnaires.md) §2 :
  *"Quand vous ouvrez ce patient, quelles informations d'identité ou de sécurité avez-vous besoin de
  voir immédiatement, sans les chercher — et lesquelles pouvez-vous retrouver seulement si
  nécessaire ?"*
- *Sidebar "Dossier"* — sans la nommer : observer si le praticien clique un item de la sidebar
  gauche (Historique, Résultats, Ordonnances…). S'il le fait, noter s'il **s'attend** à rester sur
  cette page (une tab qui change de contenu) ou à **en sortir** (ouvrir le Care Record). C'est
  exactement la distinction Lecture A / Lecture B tranchée en conception le 2026-08-13 — jamais
  encore confrontée à un praticien réel. Poser si besoin : *"Quand vous cliquez sur 'Résultats' dans
  ce menu, qu'est-ce que vous vous attendiez à voir ?"*

### Scénario 3 — Consultation (WS-003)

> *"Vous avez maintenant suffisamment de contexte et vous allez commencer la consultation.
> Montrez-moi ce que vous feriez."*

**Observer** : est-ce qu'il trouve naturellement *"Démarrer la consultation"* → WS-003 ? Hésite-t-il
sur le bouton, ou cherche-t-il ailleurs (un menu, un raccourci) ?

Puis :

> *"Pendant la consultation, vous avez besoin de retrouver une information ancienne concernant ce
> patient. Montrez-moi comment vous feriez."*

**Observer** : passe-t-il par Lookup (◎) ? Comprend-il que Lookup mène au Care Record ? Si le
praticien tente une autre voie non prévue par le prototype (ex. chercher un raccourci clavier, ou
revenir en arrière vers WS-002), le noter sans le corriger.

---

## 6. Debrief de clôture (5 min)

Ne pas sauter cette étape — elle recueille directement les points annoncés en §3 mais jamais
redemandés explicitement pendant les scénarios.

- *"Qu'est-ce qui vous a semblé inutile, ou trop présent, dans ce que vous avez vu ?"*
- *"Qu'est-ce qui vous a manqué ?"*
- *"Est-ce que ce parcours ressemble à votre façon réelle de travailler — et si non, en quoi ?"*
- Si le praticien a mentionné vouloir interrompre puis reprendre une consultation, ou gérer une
  interruption (appel, urgence) pendant WS-003, le signaler explicitement : c'est le Mode
  Interruption/Recovery absent du prototype (ADR-0023 §4) — une mention spontanée est une donnée
  utile, à ne pas laisser filer.

---

## 7. Après la session — où va cette observation

Ne pas laisser les notes de session dormir hors corpus. Selon ce qui a été observé :

- Une réponse à une question déjà posée dans
  [CWRM-020-APX-M2-workspace-questionnaires](CWRM-020-APX-M2-workspace-questionnaires.md) §2/§3 →
  y consigner directement la réponse (même informelle, même un seul praticien — ce n'est pas encore
  une preuve statistique, mais c'est une première donnée traçable).
- Une difficulté imprévue, un contournement, ou une contradiction avec ce que WS-002/WS-003 disent
  faire → nouvelle entrée `OBS-M2-[NNN]` dans le
  [M2-JOURNAL-observations](../../product/M2-JOURNAL-observations.md), format déjà défini
  (Workspace / Date / Difficulté / Loi motivante déjà connue / Hypothèse d'amélioration / Statut).
  Rappel : WS-003 est hors périmètre du gel M2 (ADR-0022) — une observation WS-003 ne s'y loge pas de
  la même façon ; la consigner en note libre dans ce document ou dans `WS-003-consultation.md`
  suffit, pas besoin d'un `OBS-M2`.
- Une seule session ne corrobore rien (cf. CWRM-020 IP-REQ-007 — minimum 2 participants par
  profession avant toute promotion en Invariant). Ne pas trancher une question ouverte sur la base
  d'un unique test.

---

## 8. Notes de session — WS-003 (hors gel M2)

Rappel : WS-003 est hors périmètre du gel M2 (ADR-0022) — ces observations ne deviennent pas des
`OBS-M2-NNN`, elles restent consignées ici en attendant la revue de fin de gel ou une confrontation à
d'autres praticiens (voir aussi les réponses routées vers
[CWRM-020-APX-M2-workspace-questionnaires §3](CWRM-020-APX-M2-workspace-questionnaires.md#3-ws-003--consultation-gold-standard)).

### Session du 2026-08-17 — médecin spécialiste, 7 ans, cabinet seul, logiciel actuel Vita

**Labels non compris.** Face à l'écran de consultation, la praticienne n'a identifié le sens d'aucun
des trois labels proposés (*"Capturer, Look up, suivi... rien qui me parle... Pour moi, c'est du
chinois"*). Elle s'attendait à atterrir directement dans l'espace où elle rédige sa consultation, sans
étape de choix intermédiaire. Les trois labels échouent, pas seulement "Look up" — "Capturer" et
"Suivi" sont pourtant du français courant, ce qui indique que le problème n'est pas l'anglicisme mais le
fait que ces trois mots nomment des *modes internes du modèle cognitif* (Présence/Capture/Lookup/Suivi,
Model C) plutôt qu'une intention du praticien au moment où il regarde l'écran (« je note », « je
consulte le dossier », « je prescris »).

Deux hypothèses distinctes en découlent, à ne pas fusionner :

1. **Hypothèse terminologie (quasi-certaine).** Les trois labels doivent être remplacés par du
   vocabulaire métier, pas des noms de modes internes. Candidats à tester au prochain prototype :
   "Dossier" ou "Consulter le dossier" (Lookup), "Noter" ou "Rédiger" (Capturer) ; "Suivi" reste à
   clarifier avant renommage — vérifier d'abord ce qu'il désigne réellement (plan de suivi ?
   prescriptions en cours ?) avant de proposer un nouveau mot.
2. **Hypothèse structure (encore ouverte).** Reste à trancher : un point d'entrée mieux nommé et plus
   visible vers le dossier suffit-il à satisfaire le besoin d'accès pendant la consultation, ou faut-il
   un accès permanent latéral ? Rien dans cette session ne permet de conclure — voir "Accès au dossier
   pendant la consultation" ci-dessous.

**Accès au dossier pendant la consultation.** Une fois en consultation, elle n'a pas retrouvé d'accès à
l'historique/résultats/ordonnances du patient sans quitter l'écran de consultation. Contournement
qu'elle décrit spontanément : *"il faudrait que quand je suis dans ma consulte, sur le côté, il y ait
encore historique, résultats, ordonnances."* Elle n'a pas utilisé ni mentionné Lookup (◎) — la question
« comprend-il que Lookup mène au Care Record ? » (§5, Scénario 3) reste sans réponse : le praticien n'a
pas trouvé ce point d'entrée par lui-même. Impossible de distinguer, sur cette session, si la demande
d'accès permanent vient d'un vrai besoin structurel ou du simple fait que le point d'entrée existant
n'a pas été vu — d'où l'hypothèse structure ci-dessus, à trancher seulement après avoir testé un Lookup
renommé et plus visible sur un prochain praticien (ne pas rouvrir la décision Founder-Driven "no
split-screen during consultation" sur la base de ce seul signal).

**Mode Interruption/Recovery confirmé spontanément.** Sans qu'on le lui demande, la praticienne
distingue explicitement « clôturer » et « mettre en pause » une consultation, avec besoin de retrouver
l'état exact au retour après être allée consulter un autre dossier suite à une interruption (appel
d'urgence). C'est exactement le 5ᵉ mode absent du prototype (ADR-0023 §4, Mode Interruption/Recovery) —
à signaler explicitement dès la prochaine revue WS-003, comme le prévoit §6.

**Portée.** Une seule session — aucune de ces observations ne doit être traduite en décision produit
avant confrontation à un second praticien (IP-REQ-007).

**Suite au renommage.** Les labels ont été renommés dans le prototype après cette session : Capturer →
Noter, Lookup → Dossier, Suivi → Rappel (voir Historique v0.4). Un bouton "⏸ Mettre en pause" a aussi
été ajouté dans la topbar pendant la consultation, distinct de "Clôturer" (retour à Mon Espace sans
fermer la consultation, bandeau "Reprendre" sur le Dashboard).

---

### Session du 2026-08-27 — thérapeute (hypnose, sophrologie), 5 ans, cabinet seule, aucun logiciel actuel

Testée sur le prototype déjà mis à jour (labels renommés).

**Hypothèse terminologie — première corroboration.** Contrairement à la session précédente, les trois
labels renommés ("Noter" / "Dossier" / "Rappel") sont compris sans aucune difficulté : *"on peut noter,
on peut regarder notre dossier et l'ouvrir éventuellement [...] ou éventuellement faire un rappel. Moi,
je trouve que c'est pas mal."* Signal positif net, sur un profil différent (donc pas une corroboration
au sens strict IP-REQ-007, qui porte sur la même profession — mais un signal de généralisation plus
fort qu'une simple répétition, puisqu'il traverse deux métiers différents). L'hypothèse terminologie
passe de *quasi-certaine* à **confirmée sur 2 sessions, 2 profils** — à confirmer encore sur un
médecin généraliste ou un second médecin spécialiste pour corroborer IP-REQ-007 côté médical
spécifiquement.

**Interruption — nuance sur l'hypothèse structure.** Rare pour son activité, mais quand on lui pose la
question, elle attend d'abord un enregistrement automatique de ce qu'elle a commencé à noter, puis la
possibilité d'ouvrir la fiche de suivi d'un autre patient et son planning — sans mentionner explicitement
un bouton "pause" dédié. Contrairement à la session 1, l'attente porte d'abord sur l'auto-save implicite,
pas sur une action explicite de mise en pause. À vérifier au prochain test : le bouton "⏸ Mettre en
pause" ajouté au prototype est-il repéré et suffisant, ou l'auto-save est-elle attendue en plus, de façon
totalement silencieuse (sans clic) ?

**Résumé condensé pendant la consultation.** Besoin réaffirmé (déjà présent session 1 sous une autre
forme) d'un accès à une synthèse très courte de l'historique du patient pendant la prise de notes, sans
quitter l'écran — reste à vérifier si "Dossier" (renommé) y répond, ou si un résumé encore plus rapide
est nécessaire.

**Signal CPP-001 (Cross-Practitioner Principle).** Premier profil non médical testé sur WS-002/WS-003 —
voir [OBS-M2-007](../../product/M2-JOURNAL-observations.md) : le mental model général transfère bien,
mais les catégories fixes du bandeau et de la sidebar (pensées modèle médical) ne généralisent pas
telles quelles.

---

### Session du 2026-09-03 — kinésithérapeute, 28 ans, cabinet à deux, logiciel actuel Vega

**Réception positive, sans mention explicite des labels.** « Ça me convient, je trouve ça bien, il n'y a
pas de souci. » Contrairement à la session thérapeute, elle ne cite pas "Noter"/"Dossier"/"Rappel" par
leur nom — signal favorable mais plus faible, à ne pas compter comme une corroboration aussi forte.

**Recherche d'info ancienne.** Voudrait une « case note » listant les techniques déjà utilisées à la
dernière séance — 3ᵉ occurrence du même besoin structurel (accès à un résumé condensé pendant la
consultation), contenu différent à chaque fois (voir [OBS-M2-009](../../product/M2-JOURNAL-observations.md)).

**Interruption — divergence nette, pas une nuance.** Répond rarement pendant la consultation (« j'aime
pas ça »), traite les appels en fin de journée ; la décision de répondre ou non se prend *avant* la
consultation (ancienne montre connectée pour identifier l'appelant), jamais en pleine séance. N'exprime
aucun besoin de "pause" ni de reprise d'état. Ce n'est pas une absence de signal — c'est un signal
opposé à celui des sessions 1 et 2. Le besoin de Mode Interruption/Recovery (ADR-0023 §4) n'est donc pas
universel tel que formulé jusqu'ici ; il pourrait dépendre du rythme de la profession (rendez-vous
espacés vs suivi rapproché) plutôt que d'être un besoin générique de "tout praticien en consultation".

**Préférence pour l'épure — pertinent pour l'hypothèse structure WS-003.** Elle apprécie explicitement
la simplicité et juge redondant de revoir les mêmes éléments de menu après un clic (voir
[OBS-M2-010](../../product/M2-JOURNAL-observations.md), sur WS-002 mais du même esprit). C'est un signal
qui va plutôt *contre* l'idée d'ajouter un accès permanent latéral dans WS-003 (déjà demandé par la
session 1) — encore une tension à garder ouverte, pas à trancher.

---

### Session du 2026-09-03 — biologiste médical, 7 ans, hôpital, logiciel actuel GLIMS

Reçue via questionnaire auto-administré ([CWRM-020-APX-M2-QST](CWRM-020-APX-M2-questionnaire-praticiens-ws002-ws003.md))
— réponses écrites, pas d'observation de comportement.

**Hypothèse terminologie — signal positif de plus, sans confusion rapportée.** Utilise "Dossier"
naturellement pour retrouver une info ancienne (*"on clique sur dossier pour accéder aux
historiques/résultats/traitement/doc"*), sans aucune mention de difficulté de vocabulaire.

**Friction concrète, nouvelle.** Elle voudrait qu'un clic sur "Dossier" mène directement à la page,
sans étape intermédiaire — dans le prototype actuel, le panneau "Dossier" affiche une carte Care Record
avec un bouton "Ouvrir" séparé, soit un clic de plus qu'attendu.

**Demandes hors périmètre actuel, à conserver sans promouvoir :** pouvoir créer un compte-rendu
automatiquement à partir d'un modèle vierge ; pouvoir dicter/enregistrer le compte-rendu directement.
Aucune loi ou PP existant ne couvre ces deux points — nouveaux signaux isolés, pas encore des
hypothèses.

**Interruption — 4ᵉ manifestation distincte.** Veut « pouvoir enregistrer le CR sans le clore
définitivement, avec une alerte comme quoi il n'est pas fini ». Quatre praticiens, quatre nuances
différentes du même besoin (ADR-0023 §4) : bouton pause explicite (médecin) ; auto-save silencieux +
ouverture d'un autre dossier (thérapeute) ; pas de besoin, géré après coup (kiné) ; sauvegarde sans
clôture + alerte visuelle "non fini" (biologiste). Toujours une confirmation terrain d'un besoin déjà
spécifié, jamais présentée comme une découverte — mais la variété des formes attendues suggère que la
solution finale devra couvrir plusieurs mécanismes, pas un seul bouton "pause" unique.

**Portée.** Quatre sessions, quatre professions, aucune paire de même profession — IP-REQ-007 non
atteint pour aucun profil. Rien ici ne doit être traduit en décision produit avant confrontation d'un
second praticien de chaque profession testée.

---

### Design Exploration reçue — WS-003 V2.1 (non testée auprès d'un praticien)

Fichier : [`WS-003-V2.1-design-exploration.html`](WS-003-V2.1-design-exploration.html), reçu le
2026-09-04, marqué par son auteur `DESIGN EXPLORATION — NON FROZÉ`. Accompagné d'une affirmation
explicite de ne pas avoir réouvert l'architecture M2, le split-screen Model C, le rôle de WS-003, ni le
principe d'accès à la profondeur du dossier à la demande.

**Tension non résolue, à signaler plutôt qu'à trancher.** Le panneau "Accès rapide" (Résultats /
Traitements / Antécédents / Documents, avec badges, colonne de droite toujours visible pendant la
consultation) est structurellement un split-screen, et son contenu n'est pas "à la demande" — il reste
affiché en permanence. Ça prend parti, sans le dire, sur exactement la question laissée ouverte par
[OBS-M2-010](../../product/M2-JOURNAL-observations.md) : la session 1 (médecin) demandait un accès
permanent latéral, la session 3 (kiné) trouvait au contraire redondant de revoir les mêmes éléments de
menu (« ça me semble de trop »). L'affirmation de ne pas avoir réouvert "l'accès à la profondeur à la
demande" et le layout proposé ne sont donc pas totalement alignés — à garder en tête avant tout test.

**Alignement positif à noter.** La carte "Continuité" (dernier contact + résumé court) répond
directement au besoin confirmé sur plusieurs sessions d'un résumé condensé pendant la consultation
(voir [OBS-M2-009](../../product/M2-JOURNAL-observations.md), sessions thérapeute et kiné).

**Points non tranchés, à clarifier avant tout test praticien :**
- Le mode "Rappel" (marquer pour suivi) présent dans le prototype actuel (`WS-002-WS-003-parcours-v2.html`)
  a disparu de cette exploration — intentionnel ou omission, à confirmer.
- Deux chemins distincts mènent à "Dossier patient" (item de navigation gauche "Actions → Dossier
  patient" et carte de droite "Ouvrir le dossier") — ambiguïté potentielle, jamais testée.
- Le modèle de navigation (sidebar gauche persistante, jamais masquée) diffère de celui réellement
  testé (topbar avec "⏸ Mettre en pause" apparaissant seulement pendant la consultation) — si cette V2.1
  est retenue, les résultats déjà obtenus sur la compréhension du bouton pause ne se transposent pas
  automatiquement ; ce serait une nouvelle affordance à tester, pas un acquis.

**Statut.** Exploration non testée auprès d'un praticien — à traiter au même niveau de preuve que les
autres hypothèses non corroborées de ce document, pas comme une évolution actée du prototype validé.

---

### Session du 2026-09-08 — médecin généraliste retraitée, installée depuis 1994, cabinet de groupe

Reçue via questionnaire auto-administré, réponse narrative. Logiciels utilisés dans sa carrière :
Medistory (appréciée), Hellodoc depuis 2016 (« bof, brouillon »).

**Friction "clic de trop" — 2ᵉ signal, professions différentes.** Insiste sur le critère "fonctionnel
rapide" pour accéder aux courriers de spécialistes pendant la consultation, dans le même sens que la
demande explicite du biologiste (session 4) de supprimer l'étape "Ouvrir" intermédiaire du panneau
"Dossier". Toujours pas IP-REQ-007 (biologiste ≠ médecin généraliste), mais suffisant pour formuler ceci
comme hypothèse explicite plutôt que remarque isolée :

> `HYPOTHÈSE — À TESTER` (convention ADR-0023 §8) : cliquer "Dossier" pendant la consultation devrait
> mener directement au Care Record, sans étape intermédiaire "Ouvrir". Non actée — à confronter à un
> 2ᵉ praticien de chacune des deux professions déjà favorables avant tout changement du prototype de
> base.

> **Figé le 2026-09-08.** Décision du Product Owner : basculer quand même dans la base réelle avant le
> prochain round (patient dense), plutôt que d'attendre IP-REQ-007 — le risque est jugé faible (on
> retire une étape, on n'ajoute pas de structure) et le prochain test mesure justement la retrouvabilité,
> que cette friction affectait directement. `WS-002-WS-003-parcours-v2.html` : le bouton "Dossier"
> appelle désormais `openRecord('ws3')` directement ; le mode-shell intermédiaire (`#lookup`, bouton
> "Ouvrir") est supprimé. Cette hypothèse n'est donc plus "à tester" au sens strict — elle est actée,
> en gardant la trace qu'elle ne reposait que sur 2 praticiens de professions différentes.

**Ce qui n'est pas une hypothèse produit : la comparaison au DMP.** *"Parfois il faut aller à la pêche
aux infos"* (à propos du Dossier Médical Partagé, système réel qu'elle a utilisé) est une référence
externe, pas une observation du prototype MedLink — à garder comme illustration du problème que MedLink
cherche à résoudre, pas comme donnée de test à elle seule.

---

### Note méthodologique — limite du protocole de test actuel

Cette session (2026-09-08) signale explicitement une limite qu'aucune des 5 sessions précédentes n'a
testée : *"difficile de répondre sur un prototype sans mise en situation quand il y a plein de biologie,
plein de courriers de spécialistes."* Toutes les sessions à ce jour ont été conduites sur un patient
fictif unique avec un volume de données minimal (Michel Rousseau / Jean Dupont, quelques résultats,
quelques traitements). Rien ne dit encore si "Dossier" reste compréhensible, ou si la Lecture A reste
suffisamment rapide, une fois confronté à un dossier réaliste (dizaines de résultats, courriers,
comptes-rendus). C'est une limite du protocole, pas seulement une observation produit — à corriger dans
la conception du prochain round de test (patient fictif "dense" plutôt qu'un patient minimal), avant de
tirer des conclusions plus fortes sur la retrouvabilité en WS-003/Care Record.

> **Corrigé le 2026-09-08.** `WS-002-WS-003-parcours-v2.html` densifié : Michel Rousseau (patient
> unique du prototype) passe de 4 cartes Care Record quasi vides à 9 cartes avec un contenu réaliste
> daté (5 dernières consultations, 6 derniers résultats + mention de 6 antérieurs, 3 ordonnances
> récentes + 11 antérieures, 4 courriers de spécialistes nommés + 3 antérieurs, antécédents/famille/
> vaccins réalistes). Choix délibéré : preview dense de 3 à 6 items par carte + compteur "+N" plutôt
> qu'un dossier illimité ou une barre de recherche — reste cohérent avec Lecture A/profondeur à la
> demande, pas un moteur documentaire. Pas de nouvelle page de détail par item à ce stade (hors scope
> de ce round) — l'objectif est de tester si le praticien retrouve vite une info en scannant la carte,
> pas encore de valider une UI de détail. Patient fictif enrichi plutôt que nouveau patient créé, pour
> ne pas re-câbler tout le parcours (schedule → WS-002 → WS-003 → Care Record) sur un second patient.

---

## Historique

| Date | Version | Nature |
|---|---|---|
| 2026-08-13 | 0.1 | Script initial du Product Owner |
| 2026-08-13 | 0.2 | Complété en supplément CWRM-020-APX-M2 : métadonnées participant, rappel d'enregistrement, ancrage des deux questions de conception déjà ouvertes (densité des tags, sidebar Lecture A/B) dans le Scénario 2, debrief de clôture explicite, section de routage post-session vers CWRM-020-APX-M2-workspace-questionnaires et M2-JOURNAL-observations |
| 2026-08-17 | 0.3 | §8 ajoutée — notes de la première session réalisée (médecin spécialiste) : labels de l'écran de consultation non compris, absence d'accès au dossier pendant la consultation, confirmation spontanée du besoin de Mode Interruption/Recovery |
| 2026-08-17 | 0.4 | §8 précisée — séparation explicite hypothèse terminologie (quasi-certaine, candidats de renommage proposés) / hypothèse structure (encore ouverte, à trancher seulement après test d'un Lookup renommé) |
| 2026-08-27 | 0.5 | Prototype mis à jour (labels renommés Noter/Dossier/Rappel, bouton "Mettre en pause"). §8 restructurée en sessions datées ; ajout de la session thérapeute (hypnose/sophrologie) — première corroboration (cross-profil) de l'hypothèse terminologie, nuance auto-save sur l'hypothèse structure, premier signal CPP-001 |
| 2026-09-03 | 0.6 | §8 complétée avec les sessions 3 (kinésithérapeute) et 4 (biologiste médical, questionnaire auto-administré) : divergence nette (pas nuance) sur le besoin d'Interruption/Recovery côté kiné ; 4ᵉ manifestation distincte du même besoin côté biologiste ; friction "un clic de trop" sur Dossier ; tension explicite entre préférence d'épure (kiné) et demande d'accès latéral (session 1) laissée ouverte |
| 2026-09-04 | 0.7 | Design Exploration WS-003 V2.1 reçue et sauvegardée (`WS-003-V2.1-design-exploration.html`), non testée auprès d'un praticien — tension signalée entre son panneau "Accès rapide" permanent et OBS-M2-010 (préférence d'épure, session kiné) ; disparition non expliquée du mode "Rappel" ; double chemin vers "Dossier patient" ; modèle de navigation différent de celui déjà testé |
| 2026-09-04 | 0.8 | Correction terminologique Lecture A/Lecture B — les labels étaient inversés depuis leur introduction (2026-08-13) par rapport au code (`WS-002-WS-003-parcours-v2.html`) et à ADR-0023 §7 Règle 3/§9. Base réelle adaptée séparément : bloc "À votre attention" du Dashboard relié à des entités nommées (corrige OBS-M2-011) |
| 2026-09-08 | 0.9 | Session 5 ajoutée (médecin généraliste retraitée, questionnaire narratif) : 2ᵉ signal sur la friction "clic de trop" formulé en `HYPOTHÈSE — À TESTER` explicite (convention ADR-0023 §8) ; note méthodologique ajoutée — aucune session à ce jour n'a testé le prototype avec un volume de données réaliste |
| 2026-09-08 | 1.0 | Trois points figés dans la base (clic direct Dossier, Lecture A, filtrage par catégorie du Care Record) ; prototype densifié pour le prochain round — 9 cartes Care Record avec contenu réaliste daté (résultats, ordonnances, courriers de spécialistes nommés, historique), patient unique enrichi plutôt que dupliqué |
