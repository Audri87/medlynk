# CWRM-020-APX-M2 — Questionnaires de validation, un par Workspace

**Document ID :** CWRM-020-APX-M2
**Statut :** Draft — Protocole expérimental, hors core CWRM (même statut que CWRM-020-APX-WS005)
**Date :** 2026-08-06
**Depends on :** [CWRM-020](CWRM-020-interview-protocol.md) — toutes les IP-REQ-001→044 s'appliquent
**Origine :** Sprint 1 M2 (WS-002 "Comprendre"), étendu aux six Workspaces à la demande du Product Owner

---

## 0. Principe commun aux six questionnaires

Aucun de ces questionnaires ne part de zéro là où un artefact existe déjà. Pour chaque Workspace, la
première colonne est : *qu'est-ce qui est déjà écrit, et avec quelle confiance ?* Les questions
posées confrontent ce déjà-écrit au terrain — elles ne cherchent pas à réinventer.

**Critère de sortie commun**, applicable à toute traduction M2 issue de ces entretiens (rappel de la
règle discutée en session) :

1. Cohérente avec les lois de M1 (ACT/OBS/PAT/transformations déjà établies).
2. Confrontée à des praticiens (pas seulement conçue).
3. Non réfutée à ce stade.

Cette règle est l'équivalent, côté M2, de Gate 3 (GOV-000 §4, Design → Engineering) — elle ne le
remplace pas, elle l'applique à l'objet "traduction produit" spécifiquement.

**Format de chaque section :** rappel de l'existant → objectif du round → questions ciblées.

---

## 1. WS-001 — Morning Brief ("Me préparer")

**Existant.** PP-001 (*Signal precedes Horizon*, ancré ACT-F009-001/002 + 7 profils), PP-002
(*Preparation follows Uncertainty*, ACT-F004-003/F007-005/F001-015), PP-003 (*Context reconstruction
unified*, multi-source F001/F002/F009), PP-004 (*Obligations secondary, not invisible*,
ACT-F001-005/006/007). **Constat :** ces quatre Principles n'affichent pas de champ `Statut` avec
confiance chiffrée (contrairement à PP-005/006/008) — à corriger séparément, hors périmètre de ce
questionnaire.

**Objectif du round.** Valider si le triptyque Signal / Horizon / Obligations décrit réellement la
première minute de travail, et si son ordre de priorité (Signal avant tout) résiste à d'autres
profils que ceux déjà cités.

**Questions ciblées.**
- *"Racontez-moi votre arrivée au cabinet hier, ou votre dernier jour de travail."* (ancrage RP-001)
- *"Qu'est-ce que vous regardez en premier — avant même d'ouvrir un dossier patient ?"* (test PP-001)
- *"Qu'est-ce qui vous pousse à préparer un dossier à l'avance, plutôt que d'arriver et de le découvrir ?"* (test PP-002 — incertitude vs temps écoulé)
- *"Combien d'applications ou d'outils différents consultez-vous pour savoir où en est votre journée ?"* (test PP-003)
- *"Les tâches administratives du matin — vous les voyez tout de suite, ou seulement si vous allez les chercher ?"* (test PP-004)

---

## 2. WS-002 — Patient Context ("Comprendre")

**Existant.** PP-005 (*Surface the relevant recent interaction first*, ≈), PP-006 (*Historical depth
follows context gap*, ≈), PP-008 (*Collapse historical detail by default*, ≈) — les trois avec
exception documentée (échographiste). DR-001 à DR-004 — toutes `Draft`, `Validated: false`. La
transformation T2 (AR-001B, `Stable`) — *contexte absent → contexte reconstruit*.

**Objectif du round.** C'est le Workspace prioritaire de M2 (Sprint 1). Confronter les quatre Display
Rules à de vrais praticiens — aucune n'a encore été validée — et trancher, si possible, Challenge 1
et Challenge 3 de la session précédente : *"Reconstruire le contexte" est-il autre chose que T2 ?
Les micro-actes de reconstruction sont-ils universels ou spécifiques au métier ?*

**Questions ciblées.**
- *"Avant d'entrer voir ce patient, qu'est-ce que vous avez besoin de savoir ?"* (ancrage T2)
- *"Est-ce que vous diriez que vous 'reconstruisez le contexte', ou est-ce que ce terme ne correspond à rien de précis pour vous ?"* (test direct Challenge 1/7 — poser la question frontalement plutôt que déduire)
- *"Qu'est-ce que vous cherchez en premier — la dernière visite, ou autre chose ?"* (test DR-001/002 selon profil)
- *"Pour ce patient-là spécifiquement, l'historique complet vous sert-il, ou seulement le plus récent ?"* (test PP-006/008 et exception DR-003)
- *"Quand vous ouvrez ce patient, quelles informations d'identité ou de sécurité avez-vous besoin de voir immédiatement, sans les chercher — et lesquelles pouvez-vous retrouver seulement si nécessaire ?"* (ajoutée le 2026-08-06 — trois prototypes successifs ont fait osciller ce point entre 1 et 3 tags sans jamais le confronter au terrain ; à trancher en entretien, pas en itération de design)
- *"Si je vous demandais de me lister, dans l'ordre, ce que vous vérifiez systématiquement avant un patient — que diriez-vous ?"* (test de l'universalité des micro-actes, Challenge 3 — comparer la réponse entre profils "suivi" et profils "checklist")

**Réponses recueillies.**

*Session du 2026-08-17 — médecin spécialiste, 7 ans d'expérience, cabinet seul, logiciel actuel Vita
(test d'utilisabilité, [CWRM-020-APX-M2-USA](CWRM-020-APX-M2-usability-script-ws002-ws003.md), un seul
praticien — ne corrobore rien à ce stade, IP-REQ-007).*

- *"Avant d'entrer voir ce patient, qu'est-ce que vous avez besoin de savoir ?"* → antécédents et
  allergies (déjà visibles en tête de fiche), le dernier résultat reçu, la date et le contenu de la
  dernière consultation (« qu'est-ce qui s'est passé »), et si les examens complémentaires demandés sont
  revenus.
- *Densité du bandeau (identité/sécurité immédiate vs à la demande)* → le contenu actuel (allergies,
  diabète, HTA) est jugé suffisant « s'il n'y a que ça comme antécédent », mais la praticienne veut
  pouvoir choisir elle-même quels antécédents apparaissent dans le bandeau plutôt que de recevoir une
  sélection fixe, avec un lien vers la liste complète, et un indicateur de nouveauté non vue si un
  confrère a ajouté un antécédent depuis sa dernière visite. → au-delà de la question posée ; voir
  [OBS-M2-006](../../product/M2-JOURNAL-observations.md).
- *Sidebar (Lecture A / Lecture B)* → réponse sans ambiguïté pour Lecture A : cliquer "Résultats"
  doit montrer tous les résultats du patient, "Traitement" toutes les ordonnances triées
  chronologiquement, "Historique clinique" tout le dossier médical qui déroule — sortie de la page,
  pas un onglet qui change de contenu sur place. Nuance ajoutée en debrief : une fois sur une catégorie,
  elle ne veut pas revoir les autres catégories mélangées (« il y a aucun intérêt que je revoie les
  autres trucs [...] c'est relou ») — vue filtrée par catégorie, pas une fusion.
- *Bouton "Démarrer la consultation"* → comportement spontané, aucune hésitation.
- *Navigation retour vers "Mon Espace"* → difficulté non anticipée par ce questionnaire : après avoir
  ouvert la fiche patient, la praticienne a mis du temps à retrouver comment revenir en arrière avant de
  repérer le bouton en haut de l'écran. Voir mise à jour
  [OBS-M2-005](../../product/M2-JOURNAL-observations.md).

*Session du 2026-08-27 — thérapeute (hypnose, sophrologie), 5 ans d'expérience (depuis 2021), cabinet
seule, aucun logiciel actuel. Profil hors corpus médical classique — première confrontation de WS-002 à
une pratique non médicale ; ne corrobore rien vis-à-vis de la session précédente (profession différente,
IP-REQ-007), mais teste directement CPP-001 (Cross-Practitioner Principle).*

- *"Avant d'entrer voir ce patient, qu'est-ce que vous avez besoin de savoir ?"* → rapidement : quand
  vue la dernière fois, et quels soins effectués (contenu des séances passées) — même structure de
  besoin que la session médecin (T2), contenu différent (soins d'hypnose, pas d'antécédents médicaux).
- *Densité du bandeau* → jugé « le minimum », suffisant, rien à ajouter — mais avec une réserve
  explicite : *"si je devais avoir une synthèse, ce serait les textes que j'utilise en hypnose [...]
  mais c'est encore autre chose"*. Elle reconnaît elle-même que le bandeau médical ne correspond pas à
  ce dont elle aurait besoin pour sa pratique. Voir [OBS-M2-007](../../product/M2-JOURNAL-observations.md).
- *Sidebar (catégories Résultats / Ordonnances / Historique)* → hésitation nouvelle, absente de la
  session médecin : elle imagine son "historique" comme une synthèse ultra-condensée séance par séance
  (« Hypnose 1 : estime de soi, Hypnose 2 : [...] »), mais ne sait pas si ça devrait vivre dans
  "Historique" ou "Résultats" — les catégories elles-mêmes ne lui parlent pas nettement. Voir
  [OBS-M2-007](../../product/M2-JOURNAL-observations.md).
- *Bouton "Démarrer la consultation"* → comportement spontané, aucune hésitation (« totalement
  instinctivement »).
- *Dashboard — ce qui suffirait par rendez-vous* → heure, note, type (premier contact / suivi), âge ;
  ce qui manque : depuis quand elle n'a pas vu ce patient (« il y a un mois, deux ans, une semaine »).
- *Item "Planning" de la sidebar* → clique dessus et ne trouve rien, alors que "Mon espace" affiche
  déjà le planning du jour — perçu comme incohérent (« ça m'a perturbée »). Probable lacune
  d'implémentation du prototype plutôt qu'un problème de conception, à vérifier avant d'en tirer une
  conclusion.

*Session du 2026-09-03 — kinésithérapeute, 28 ans d'expérience, cabinet (ouvert seule, exercice à deux
avec un collègue depuis 3 ans), logiciel actuel Vega. Profil paramédical, 3ᵉ profession distincte testée
sur WS-002 — apporte à la fois une convergence (CPP-001, cf. OBS-M2-007) et une divergence directe avec
la session 1 sur l'interaction de la sidebar (voir plus bas — à ne pas lisser).*

- *Impression générale* → apprécie explicitement la simplicité et l'épure (*"j'aime pas trop les
  logiciels qui en font trop [...] j'aime quand c'est clair [...] des éléments vraiment clés, tout de
  suite, en visu"*) ; le bandeau du haut est jugé bien, suffisant, sans réserve.
- *Avant d'entrer voir ce patient* → privilégie d'abord l'échange verbal avec le patient ; suggère un
  "petit espace" listant les techniques déjà utilisées à la dernière séance, pour construire la séance
  du jour. Contenu différent des deux sessions précédentes (ni antécédents médicaux, ni synthèse
  d'hypnose) — 3ᵉ manifestation du même besoin structurel (T2), voir
  [OBS-M2-009](../../product/M2-JOURNAL-observations.md).
- *Dashboard — ce qui manque, spécifique au métier* → le nombre de séances déjà faites sur le total
  prescrit (ex. « 4 sur 20 »), et un signal de renouvellement d'ordonnance à venir. Justifié
  explicitement par une différence de rythme avec la médecine (*"nous, on les voit vraiment
  régulièrement"*). Voir [OBS-M2-009](../../product/M2-JOURNAL-observations.md).
- *Bloc "À votre attention" du Dashboard* → ambiguïté : ne sait pas s'il s'agit d'éléments en plus du
  planning ou liés aux patients déjà listés. Rejoint OBS-M2-004 (le même besoin "signaler du nouveau"
  déjà en tension à plusieurs échelles) — voir
  [OBS-M2-011](../../product/M2-JOURNAL-observations.md).
- *Sidebar (Résumé/Historique/Résultats...) — DIVERGENCE avec la session 1.* Attendait qu'un clic sur un
  élément fasse grossir cet élément sur place, avec possibilité d'annoter dedans — pas revenir sur "les
  mêmes éléments qui sont déjà à gauche", jugé redondant (*"pour moi, ça me semble de trop"*). C'est
  l'inverse de la Lecture A sans ambiguïté observée en session 1 (sortir vers le dossier complet). Ne
  pas trancher entre les deux sur cette seule paire de sessions — voir
  [OBS-M2-010](../../product/M2-JOURNAL-observations.md), statut `NON CORROBORÉ` explicitement.
- *Bouton "Démarrer la consultation"* → confirmé une 3ᵉ fois, aucune hésitation.

*Session du 2026-09-03 — biologiste médical, 7 ans d'expérience, hôpital, logiciel actuel GLIMS
(gestion de laboratoire). Reçue via [CWRM-020-APX-M2-QST](CWRM-020-APX-M2-questionnaire-praticiens-ws002-ws003.md)
(questionnaire auto-administré, 21 questions numérotées), pas la session modérée — pas d'observation de
comportement, seulement les réponses écrites.*

- *Q11 — avant la consultation* → « date de la dernière consultation, traitement en cours et résultat
  dernier bilan ». Même structure T2 que les trois sessions précédentes, contenu à nouveau différent
  (bilans biologiques).
- *Q12 — bandeau* → « informations principales présentes », jugé suffisant, sans réserve.
- *Q13 — sidebar (Lecture A/B)* → Lecture A sans ambiguïté sur les quatre items testés : Historique
  (« toutes les précédentes consultations avec les comptes-rendus »), Résultats (« résultats biologiques
  ou à minima les comptes-rendus »), Ordonnances (« toutes les précédentes ordonnances »), Documents
  (« CR imagerie, +/- anapath, des autres spécialistes, des hospitalisations »). Aligné avec la session 1
  (médecin), en tension avec la session 3 (kiné, accordéon en place) — voir mise à jour
  [OBS-M2-010](../../product/M2-JOURNAL-observations.md) : 2 votes Lecture A (médecin, biologiste) contre
  1 vote accordéon (kiné). Toujours pas de seuil IP-REQ-007 atteint, et les deux votes Lecture A sont des
  professions médicales stricto sensu, pas paramédicales — hypothèse à vérifier, pas une conclusion.
- *Q16, Q18, Q19 — "Antécédents"* → contradiction confirmée dans le code du prototype : cliquer sur
  "Antécédents" (comme sur tout autre item de la sidebar) ouvre le même Care Record générique que
  "Résultats" ou "Historique" (`openRecord('patient')` pour tous les items, `WS-002-WS-003-parcours-v2.html`
  lignes 390-400) — il n'existe aucune fiche résumée dédiée (antécédents médicaux, chirurgicaux,
  familiaux, allergies). C'est exactement ce qui lui manque le plus (Q19 : « la fiche résumée du
  patient »). Voir [OBS-M2-012](../../product/M2-JOURNAL-observations.md).
- *Q14 — "Démarrer la consultation"* → confirmé une 4ᵉ fois, aucune hésitation (« oui directement »).

*Session du 2026-09-08 — médecin généraliste, installée depuis 1994 (retraitée depuis l'été 2026),
cabinet de groupe. Logiciels utilisés dans sa carrière : Medistory (Mac, appréciée), puis Hellodoc
depuis 2016 (« bof, brouillon, parfois difficile de s'y retrouver ») ; connaît Doctolib de réputation
seulement. Reçue via questionnaire auto-administré, réponse narrative plutôt que numérotée
question-par-question — 5ᵉ profil, 1ᵉʳ praticien retraité du corpus, profession "médecin généraliste"
distincte de la session 1 ("médecin spécialiste", non précisée).*

- *Q8 — Mon Espace, ce qui est regardé en premier* → « le nom de la personne et le motif ». Cohérent
  avec les 4 sessions précédentes, aucun élément nouveau.
- *Q11/Q12 — fiche patient avant consultation* → « motif de la demande, traitement en cours, dernière
  biologie, synthèse dossier/antécédents/allergie ». 5ᵉ confirmation de la structure T2, contenu
  spécifique au généraliste (biologie, traitement en cours) proche de la session 1 (médecin spécialiste).
- *Q16 — information pendant la consultation* → « derniers courriers des spécialistes ». Rejoint le
  besoin d'accès à la profondeur pendant la consultation déjà noté sessions 1/2/3/4, contenu
  spécifique (correspondance de confrères).
- *Q6/Q7 — clair/confus* → « le début me paraît clair et facile d'utilisation », rien signalé comme
  confus. Positif sur Mon Espace → fiche patient, cohérent avec les sessions précédentes.
- *Réserve méthodologique explicite, à ne pas ignorer* → elle signale elle-même la limite du test :
  *"difficile de répondre sur un prototype sans mise en situation quand il y a plein de biologie, plein
  de courriers de spécialistes"*, et insiste sur le critère *"fonctionnel rapide"* dans ce contexte de
  densité réelle. Aucune des 5 sessions à ce jour n'a testé le prototype avec un volume de données
  réaliste (patient fictif unique, peu de données). C'est une limite du protocole de test lui-même, pas
  seulement une observation produit — voir note méthodologique ajoutée en
  [§8 du script](CWRM-020-APX-M2-usability-script-ws002-ws003.md).
- *Référence externe (hors prototype, à ne pas confondre avec une observation MedLink)* → à propos du
  DMP (Dossier Médical Partagé) : *"parfois il faut aller à la pêche aux infos"*. C'est une comparaison
  avec un système existant qu'elle a réellement utilisé, pas une observation du prototype MedLink —
  utile comme illustration vivante du problème que MedLink cherche à résoudre (coût cognitif d'accès à
  une information qui existe mais est mal retrouvable), à conserver comme référence, pas comme donnée
  de test.

---

## 3. WS-003 — Consultation (Gold Standard)

**Existant.** PP-009 à PP-015, toutes `Founder-Driven` (Model C). Evidence actuelle : PP-013 et
PP-014 renforcées à `≈` par WE-004 (7/9 profils). PP-009, 010, 011, 012, 015 restent `evidence: ?` —
décidées, jamais confrontées au corpus.

**Objectif du round.** Ne pas rouvrir tout le Workspace — Gold Standard, déjà stable en pratique.
Cibler exclusivement les cinq Principles encore sans ancrage empirique, pour savoir s'ils se
corroborent ou s'ils doivent être révisés en tant que décisions fondateur.

**Questions ciblées.**
- *"Pendant la consultation, où est votre ordinateur — physiquement, dans votre attention ?"* (test PP-009 — le logiciel s'efface)
- *"Pouvez-vous faire deux choses à la fois pendant une consultation — écouter et noter en même temps — ou est-ce que l'un chasse l'autre ?"* (test PP-010 — un seul focus cognitif)
- *"Si vous êtes interrompu en pleine consultation, comment reprenez-vous ensuite ?"* (test PP-011)
- *"Préférez-vous écrire librement, ou remplir des champs structurés ?"* (test PP-012)
- *"Comment savez-vous que la consultation est vraiment terminée, côté administratif ?"* (test PP-015)

**Questions reprises de l'ex-§4 (WS-004, 2026-09-08)** — voir renvoi complet en §4 ci-dessous. WS-004
n'étant plus démontré comme Workspace (`WBD-004` v2.2, Erratum), ces deux questions rejoignent le test
de PP-015/Mode Clôture, qu'un écran réel permet enfin de tester (`WS-002-WS-003-parcours-v5.html`,
section clôture) :
- *"Qu'est-ce qui fait qu'une note que vous avez écrite est vraiment utilisable la prochaine fois — et
  qu'est-ce qui la rend inutilisable ?"* (critère de fiabilité de Mode Clôture, jamais documenté)
- *"À quel moment considérez-vous qu'une note est 'finie' ?"* (recoupe PP-015 — *"Rien à signaler"* —
  et GAP-D-003/WE-004)

**Réponses recueillies.**

*Même session (2026-08-17) — voir notes complètes en
[§8 du script d'utilisabilité](CWRM-020-APX-M2-usability-script-ws002-ws003.md#8-notes-de-session-ws-003-hors-gel-m2).
Rappel : WS-003 est hors gel M2 (ADR-0022) — ces réponses n'entrent pas dans le critère de sortie
ACT/OBS/PAT du gel, elles restent une première donnée non corroborée.*

- *"Si vous êtes interrompu en pleine consultation, comment reprenez-vous ensuite ?"* (PP-011) → pas
  posée telle quelle, mais réponse spontanée en fin de session : besoin explicite de distinguer
  « clôturer » et « mettre en pause » la consultation, avec retour possible à l'état exact après être
  allée traiter l'urgence sur un autre dossier. Confirme PP-011 et le besoin du Mode
  Interruption/Recovery (ADR-0023 §4), absent du prototype testé.
- Écran de consultation (labels "Capturer" / "Look up" / "Suivi") → non compris (« c'est du chinois »),
  attente d'atterrir directement dans l'espace de rédaction de la consultation.

*Session du 2026-08-27 — thérapeute (hypnose, sophrologie), 5 ans, cabinet seule. Testée après
renommage des labels ("Noter" / "Dossier" / "Rappel", cf. §8 v0.4 du script) — première corroboration
de l'hypothèse terminologie, sur un profil différent.*

- Écran de consultation (labels "Noter" / "Dossier" / "Rappel") → compris sans difficulté : *"on peut
  noter, on peut regarder notre dossier et l'ouvrir éventuellement [...] ou éventuellement faire un
  rappel. Moi, je trouve que c'est pas mal."* Contraste net avec la session précédente sur les anciens
  labels — voir mise à jour de l'hypothèse terminologie en §8 du script.
- *"Si vous êtes interrompu en pleine consultation, comment reprenez-vous ensuite ?"* (PP-011) → jugé
  rare pour son activité, mais réponse claire : elle attend d'abord un enregistrement automatique de ce
  qu'elle a commencé à noter, puis la possibilité d'ouvrir la fiche de suivi d'un autre patient et son
  planning, sans perdre ce qui était en cours. Confirme à nouveau PP-011 et le besoin d'Interruption/
  Recovery, avec une nuance par rapport à la session précédente : l'attente porte d'abord sur la
  sauvegarde automatique, pas explicitement sur un bouton "pause" dédié — à vérifier si le bouton
  "⏸ Mettre en pause" ajouté au prototype répond à ce besoin ou si l'auto-save implicite est attendue en
  plus.
- Pendant la consultation, besoin réaffirmé d'un résumé très condensé des séances passées, visible
  pendant la prise de notes, sans quitter l'écran — recoupe la demande d'accès au dossier pendant la
  consultation déjà notée en session 1 (voir hypothèse structure, §8 du script).

*Session du 2026-09-03 — kinésithérapeute, 28 ans, cabinet à deux, logiciel actuel Vega.*

- Écran de consultation → « ça me convient, je trouve ça bien, il n'y a pas de souci » — réception
  positive, mais sans nommer les labels individuellement ; ne pas la compter comme une corroboration
  aussi forte que la session thérapeute (qui, elle, citait "noter"/"dossier"/"rappel" explicitement).
- Information ancienne pendant la consultation → souhaite une « case note » listant les techniques déjà
  utilisées, dans le même sens que le résumé condensé demandé en session 2 — 3ᵉ occurrence du même
  besoin structurel avec un contenu différent à chaque fois (voir
  [OBS-M2-009](../../product/M2-JOURNAL-observations.md)).
- *"Si vous êtes interrompu en pleine consultation, comment reprenez-vous ensuite ?"* (PP-011) →
  **divergence nette avec les deux sessions précédentes.** Elle répond rarement pendant la consultation
  (déteste être dérangée) et traite les appels en fin de journée ; quand elle décide de répondre, c'est
  un jugement fait *avant* la consultation (ancienne montre connectée pour savoir qui appelle), pas une
  interruption gérée *pendant*. N'exprime aucun besoin de "pause" ni de reprise d'état — tempère le
  caractère universel du besoin de Mode Interruption/Recovery. Statut du croisement : `NON CORROBORÉ`
  vis-à-vis des sessions 1 et 2 sur ce point précis — à traiter comme une vraie divergence de profil,
  pas comme du bruit à lisser.

*Session du 2026-09-03 — biologiste médical, 7 ans, hôpital, logiciel actuel GLIMS. Questionnaire
auto-administré — pas d'observation de comportement.*

- *Q14 — "Démarrer la consultation"* → confirmé spontané.
- *Q15/Q16 — écran de consultation* → utilise "Dossier" naturellement pour retrouver une info ancienne
  (« on clique sur dossier pour accéder aux historiques/résultats/traitement/doc ») — 3ᵉ/4ᵉ confirmation
  positive de l'hypothèse terminologie, aucune confusion de vocabulaire rapportée. Friction concrète
  signalée en plus : elle voudrait que cliquer "Dossier" mène *directement* à la page, sans étape
  intermédiaire (le panneau "Dossier" actuel affiche une carte Care Record avec un bouton "Ouvrir" —
  un clic de plus qu'attendu).
  Deux demandes hors du périmètre actuel du corpus, à conserver sans les promouvoir : pouvoir créer un
  compte-rendu automatiquement à partir d'un modèle vierge, et pouvoir dicter/enregistrer le
  compte-rendu directement.
- *Q17 — interruption* → veut « pouvoir enregistrer le CR sans le clore définitivement, avec une alerte
  comme quoi il n'est pas fini ». 4ᵉ manifestation distincte du même besoin (ADR-0023 §4, Mode
  Interruption/Recovery) — encore une nuance différente des trois précédentes (médecin : bouton pause
  explicite ; thérapeute : auto-save silencieux + ouverture d'un autre dossier ; kiné : pas de besoin de
  pause, gère après coup ; biologiste : sauvegarde sans clôture + alerte visuelle "non fini"). Toujours
  pas présenté comme une découverte — confirmation terrain d'un besoin déjà spécifié.

*Session du 2026-09-08 — médecin généraliste retraitée, installée depuis 1994, cabinet de groupe.
Réponse narrative, questionnaire auto-administré.*

- *Q16 — information pendant la consultation* → « derniers courriers des spécialistes ». Rejoint la
  demande d'accès à la profondeur pendant la consultation déjà exprimée sous 4 formes différentes
  (sessions 1 à 4) — 5ᵉ manifestation du même besoin structurel, contenu spécifique (correspondance de
  confrères).
- *Friction "clic de trop" sur "Dossier" — 2ᵉ signal, professions différentes.* Sans tester
  explicitement l'écran (réponse narrative, pas d'observation de comportement), elle insiste sur le
  critère *"fonctionnel rapide"* dès qu'il y a un volume réaliste de documents/résultats — dans le même
  sens que la demande explicite du biologiste (session 4) de supprimer l'étape "Ouvrir" intermédiaire.
  Toujours pas IP-REQ-007 (professions différentes : biologiste, médecin généraliste), mais commence à
  ressembler à une hypothèse UX prioritaire à tester plutôt qu'une remarque isolée — à formuler comme
  `HYPOTHÈSE — À TESTER` (convention ADR-0023 §8), pas encore comme une décision.
- *Réserve méthodologique* → elle signale explicitement la limite de tester sur un patient fictif avec
  peu de données, alors que sa vraie préoccupation porte sur la vitesse de retrouvabilité *avec* un
  volume réaliste de biologie et de courriers. Aucune session à ce jour n'a testé cette dimension — voir
  note ajoutée en [§8](CWRM-020-APX-M2-usability-script-ws002-ws003.md).

---

## 4. Persistance de la mémoire clinique (ex-WS-004 — plus un Workspace, voir WBD-004 v2.2 Erratum)

> **Reclassé le 2026-09-08.** WS-004 n'est plus démontré comme Workspace au sens de `WSP-001` — audit
> falsificateur [OBS-M2-013](../../product/M2-JOURNAL-observations.md), décision
> [ADR-0024](../../adr/ADR-0024-ws004-nature-et-proof-set-m2.md) (Option A), amendement
> [WBD-004](../../product/workspaces/WBD-004-consultation-vs-documentation.md) v2.2. La responsabilité
> (transformer la capture brute en mémoire fiable, structurée, réutilisable) reste valide — c'est le
> statut de Workspace praticien-facing qui est retiré, pas la responsabilité elle-même. Cette section
> n'est donc plus un round d'entretien praticien autonome — elle documente où vont ses questions.

**Existant.** Mandat confirmé (WBD-004 v2.2) : *"transformer la capture brute en mémoire clinique
fiable, structurée, réutilisable — pour soi-même."* Transformation T4 (AR-001B, `Stable`) — *capture
brute → mémoire consolidée*.

**Ce que deviennent les quatre questions d'origine :**
- Les deux questions sur la fiabilité/le critère de fin d'une note → **déplacées en §3**, posées dans
  le cadre du test de Mode Clôture (WS-003), qu'un écran réel permet désormais de tester.
- *"Si vous deviez donner un nom à ce moment..., quel mot utiliseriez-vous ?"* → **retirée**. Elle
  visait à trancher le nom d'un Workspace ; il n'y a plus de Workspace à nommer. Sans objet tant que la
  responsabilité reste interne.
- *"Cette mémoire, vous la relisez vous-même — jamais quelqu'un d'autre ?"* → **conservée, mais
  différée**, hors round de test praticien prioritaire. Elle informe le mandat *"pour soi-même"* de la
  responsabilité de persistance et la territoire PDX-001/G1 (validation IA, visibilité) si ces
  hypothèses progressent un jour — pas une question à poser au prochain round WS-003/WS-006.

---

## 5. WS-005 — nom candidat *Clinical Coordination* (partage)

**Existant.** [CWRM-020-APX-WS005](CWRM-020-APX-WS005-coordination-guide.md) — grille déjà écrite,
ne pas la reconstruire. [Finding-005](../../AR-001-architecture-review.md) a mesuré la corroboration
réelle de chacune des quatre composantes du mandat : Transmission `Evidence` (5 profils), Avis
`Unsupported` (0 occurrence, corpus entier), Délégation `Observation` (1 profil, pas de verbatim
direct), Reprise de patient `Evidence — mais mal rattaché` (relève de T2, pas de WS-005).

**Objectif du round.** Ce n'est pas une nouvelle grille — c'est un complément ciblé sur exactement ce
que Finding-005 a laissé ouvert. Sonder frontalement "avis" plutôt que d'attendre qu'il émerge,
élargir "délégation" à d'autres profils que F009, et clarifier le store de sortie de la transmission
(non précisé même après correction de WBD-004).

**Questions ciblées.**
- *"Vous arrive-t-il de demander l'avis d'un confrère avant de décider quelque chose pour un patient ? Dans quelles circonstances ?"* (sonde directe — jamais posée telle quelle jusqu'ici, ce qui peut expliquer l'absence totale dans le corpus)
- *"Vous arrive-t-il de transférer une tâche ou un patient à un collègue ? Comment décidez-vous à qui, et comment le collègue sait-il quoi faire ?"* (élargir Délégation au-delà de F009)
- *"Quand vous transmettez une information à quelqu'un — patient ou confrère — est-ce que ça repart dans le dossier du patient, ou est-ce que ça part par un autre canal complètement ?"* (store de sortie, question laissée ouverte par AR-001 Finding-004)
- **Ne pas sonder** *"reprise de patient"* dans ce questionnaire — déjà rattaché à T2/WS-002 (Finding-005), y revenir ici recréerait la confusion déjà corrigée.

---

## 6. WS-006 — "Je termine" (clôture)

**Existant.** Aucun Blueprint. Statut `Research Workspace` (GOV-000 §4). Evidence éparse :
ACT-F001-024→027 (vérification matériel, sauvegarde, tour du cabinet, sortie), ACT-F007-025
(fermeture des dossiers), ACT-F009-033 (report des tâches non terminées). WE-004 (Q8) documente déjà
un *"GAP quasi complet"* : aucun praticien n'a formulé de critère de fin pour une note isolée — le
même flou existe probablement pour la journée entière.

**Objectif du round.** Le plus exploratoire des six — découverte pure, pas validation. Deux questions
non résolues à couvrir en priorité : le critère de fin de journée lui-même, et la frontière avec
WS-001 du lendemain (jamais spécifiée — signalée comme Finding candidat non formalisé, REV-001 §8).

**Questions ciblées.**
- *"Comment savez-vous que votre journée est vraiment terminée ?"* (comble directement le GAP Q8 de WE-004, appliqué à l'échelle de la journée)
- *"Qu'est-ce qui vous empêcherait de partir tranquille, ce soir ?"* (critère négatif — ce qui bloque la clôture, pas ce qui la permet)
- *"Le lendemain matin, est-ce que vous repensez à ce qui restait en suspens la veille — et comment vous en souvenez-vous ?"* (sonde directement la frontière WS-006 → WS-001, jamais spécifiée)
- *"Les tâches reportées — vous les retrouvez où, le lendemain ?"* (mécanisme concret du report, ACT-F009-033)

---

## Historique

| Date | Version | Nature |
|---|---|---|
| 2026-08-06 | 0.1 | Draft initial — six questionnaires, chacun ancré dans l'existant (PP-NNN, DR-NNN, WBD-004, Finding-005) plutôt que construit à partir de zéro |
| 2026-08-17 | 0.2 | Réponses recueillies ajoutées (§2/§3) — session 1, médecin spécialiste |
| 2026-08-27 | 0.3 | Réponses recueillies ajoutées (§2/§3) — session 2, thérapeute (hypnose/sophrologie) |
| 2026-09-03 | 0.4 | Réponses recueillies ajoutées (§2/§3) — session 3, kinésithérapeute ; divergence sidebar (session 1 vs 3) et divergence interruption (sessions 1/2 vs 3) marquées explicitement, non lissées |
| 2026-09-03 | 0.5 | Réponses recueillies ajoutées (§2/§3) — session 4, biologiste médical (questionnaire auto-administré) |
| 2026-09-04 | 0.6 | Correction terminologique Lecture A/Lecture B (voir M2-JOURNAL-observations, OBS-M2-010) — les labels étaient inversés par rapport au code et à ADR-0023 §7 |
| 2026-09-08 | 0.7 | Réponses recueillies ajoutées (§2/§3) — session 5, médecin généraliste retraitée ; réserve méthodologique sur la densité de données non testée |
| 2026-09-08 | 0.8 | §4 reclassée (WBD-004 v2.2 Erratum, ADR-0024) — WS-004 n'est plus un round d'entretien Workspace autonome. Deux questions déplacées en §3 (fiabilité/critère de fin, Mode Clôture) ; question de nommage retirée (sans objet) ; question de relecture personnelle conservée mais différée, hors round prioritaire |
