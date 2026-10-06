# MedLink — Questionnaire de test (à envoyer aux praticiens)

> Document prêt à copier tel quel dans un email, un Google Form ou un PDF. Pas de jargon interne,
> pas d'identifiant CWRM visible pour le praticien — ce texte s'adresse directement à lui.
> Version modérée/en face à face équivalente : [CWRM-020-APX-M2-USA](CWRM-020-APX-M2-usability-script-ws002-ws003.md).
> Les réponses collectées doivent être reversées dans le corpus — voir §7 de ce document en interne
> (non inclus dans la version envoyée au praticien).

---

## À envoyer tel quel au praticien, à partir d'ici

Bonjour,

Merci de prendre quelques minutes pour tester un prototype de MedLink, une nouvelle approche du
logiciel de travail des professionnels de santé.

**Ce que nous cherchons à comprendre :** pas si vous savez utiliser un logiciel, mais si ce que nous
avons conçu correspond à votre façon réelle de travailler — ce que vous comprenez spontanément, ce
qui vous semble utile, ce qui vous semble inutile ou en trop, et ce qui vous manque.

**Ce que vous allez tester** n'est pas un dossier patient complet. Il représente trois niveaux de
travail :

- **Mon Espace** — votre point d'entrée quotidien : votre journée, vos patients, ce qui mérite votre attention.
- **Patient Context** — quand vous ouvrez un patient, le contexte nécessaire pour comprendre pourquoi il est devant vous aujourd'hui.
- **Consultation** — un espace volontairement épuré une fois la consultation commencée, pour vous laisser vous concentrer sur le patient. Le dossier complet reste accessible si vous en avez besoin, mais n'est jamais imposé.

Les informations et le patient (Michel Rousseau) sont fictifs. Certains éléments sont volontairement
simplifiés — ce n'est pas la version finale.

**Comment répondre :** merci de tester d'abord librement (5 minutes), puis de répondre aux questions
ci-dessous en gardant le prototype ouvert dans un autre onglet pour vérifier vos réponses si besoin.
Comptez 15–20 minutes au total. Il n'y a pas de bonne ou de mauvaise réponse — une réponse honnête
"je n'ai pas compris" ou "je n'aurais pas cherché ça ici" est exactement ce qui nous est utile.

**Accès au prototype :** [lien à insérer]
Identifiant : `medlink` · Mot de passe : `[à insérer]`

Vos réponses sont utilisées uniquement pour la conception de MedLink, de façon anonymisée.

---

### Vous, en quelques mots

1. Quelle est votre profession ?
2. Depuis combien de temps exercez-vous ?
3. Dans quel cadre exercez-vous (cabinet seul, cabinet de groupe, hôpital, autre) ?
4. Quel logiciel utilisez-vous actuellement pour votre pratique quotidienne ?

---

### Première impression (après exploration libre)

5. Sans réfléchir : en une phrase, à quoi sert cet outil selon vous ?
6. Qu'est-ce qui vous a semblé clair d'emblée ?
7. Qu'est-ce qui vous a semblé confus, ou vous a fait hésiter ?

---

### Mon Espace (l'écran d'accueil)

8. Si vous commenciez réellement votre journée avec cet écran, que regarderiez-vous en premier ?
9. Est-ce que ce que vous voyez pour chaque patient (l'heure, le motif, la petite note en dessous) vous suffit pour savoir si ce rendez-vous demande une préparation particulière ?
10. Qu'est-ce qui manque à cet écran pour que vous puissiez vraiment démarrer votre journée avec ?

---

### Fiche du patient (avant de commencer la consultation)

11. Ouvrez la fiche de Michel Rousseau. Avant de démarrer la consultation, qu'est-ce que vous cherchez à savoir ?
12. Les informations affichées en haut (allergie, diabète, HTA) — sont-elles suffisantes, excessives, ou insuffisantes pour vous, à ce stade ? Qu'est-ce qui devrait apparaître immédiatement, sans avoir à le chercher — et qu'est-ce qui peut attendre que vous alliez le consulter ?
13. En dehors du bouton "Démarrer la consultation", vous voyez un menu à gauche (Résumé, Historique, Résultats…). Si vous cliquez sur l'un de ces éléments, à quoi vous attendez-vous ? (Rester sur cet écran avec un contenu différent, ou passer dans le dossier complet du patient ?)
14. Le bouton "Démarrer la consultation" — est-ce l'action que vous auriez faite spontanément, ou en cherchiez-vous une autre ?

---

### Pendant la consultation

15. Une fois la consultation commencée, l'écran devient beaucoup plus simple. Qu'en pensez-vous — cela vous convient, ou quelque chose vous manque à ce moment précis ?
16. Imaginez que vous avez besoin de retrouver une information ancienne sur ce patient pendant la consultation. Montrez/racontez comment vous procéderiez avec ce prototype. Est-ce que cela correspond à ce que vous auriez fait naturellement ?
17. Vous arrive-t-il d'être interrompu pendant une consultation (appel, urgence) ? Si oui, qu'attendriez-vous du logiciel à ce moment-là ? *(cette situation n'est pas encore représentée dans le prototype — votre réponse nous intéresse quand même)*

---

### Pour conclure

18. Qu'est-ce qui vous a semblé inutile, ou trop présent, dans ce que vous avez vu ?
19. Qu'est-ce qui vous a manqué ?
20. Ce parcours (Mon Espace → fiche patient → consultation) ressemble-t-il à votre façon réelle de travailler ? Si non, en quoi est-ce différent ?
21. Autre chose que vous voudriez nous dire ?

Merci beaucoup pour votre temps.

---

## Fin du texte à envoyer au praticien

---

## 7. Routage interne des réponses reçues (ne pas envoyer cette section)

Chaque réponse reçue doit être reversée dans le corpus, pas laissée dans une boîte mail :

- Questions 12 et 13 répondent directement aux deux questions déjà ouvertes du corpus (densité des
  tags du bandeau, comportement attendu de la sidebar "Dossier" — Lecture A). Consigner les réponses
  dans [CWRM-020-APX-M2-workspace-questionnaires](CWRM-020-APX-M2-workspace-questionnaires.md) §2.
- Question 17 (interruption) documente le Mode Interruption/Recovery absent du prototype (ADR-0023
  §4) — consigner en note libre dans `WS-003-consultation.md`, pas dans le Journal M2 (WS-003 est
  hors périmètre du gel M2, ADR-0022).
- Toute difficulté imprévue ou contradiction avec ce que WS-002 dit faire → nouvelle entrée
  `OBS-M2-[NNN]` dans le [M2-JOURNAL-observations](../../product/M2-JOURNAL-observations.md).
- Un seul questionnaire rempli ne valide rien (CWRM-020 IP-REQ-007 — minimum 2 participants par
  profession avant toute promotion en Invariant, appliqué ici par analogie).

---

## Historique

| Date | Version | Nature |
|---|---|---|
| 2026-08-13 | 0.1 | Création — questionnaire auto-administré, dérivé du script modéré CWRM-020-APX-M2-USA, pour envoi asynchrone aux praticiens testant le lien hébergé |
