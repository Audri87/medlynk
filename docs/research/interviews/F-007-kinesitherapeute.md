# F-007 — Clinical Interview Report
## Kinésithérapeute — Cabinet Libéral

**Type :** Clinical Interview Report
**Statut :** Draft — Analyse initiale
**Date :** 2026-07-29
**Analyste :** MedLink Research Program
**Framework :** F-XXX Clinical Interview Report v1.0

**Note de corpus :** Un second profil de kinésithérapeute libéral — à comparer directement avec F-001. Les deux exercent la même profession dans le même mode d'exercice avec des architectures cognitives différentes. Cette comparaison intra-profession est précieuse.

**Qualité du verbatim :** Très élevée — questions et réponses complètes, citations directes disponibles. C'est l'interview la plus détaillée du corpus.

---

## 1. Executive Summary

Cette interview documente la pratique d'une kinésithérapeute libérale. C'est le deuxième profil de kinésithérapie du corpus après F-001, ce qui permet pour la première fois une **comparaison intra-profession**.

Trois findings principaux.

**Finding 1 — L'information en limbo :** *"Tant que je n'ai pas eu le temps de l'inscrire, elle n'en fait pas vraiment partie."* C'est le finding le plus nouveau du corpus. Une information reçue (SMS, document, appel) n'est pas une information intégrée. Entre la réception et l'intégration, il existe une **zone d'incertitude clinique** : l'information est connue du praticien mais absente du dossier — elle ne peut pas influencer la décision d'un autre praticien et ne sera pas retrouvée dans une recherche. Ce concept mérite une modélisation explicite dans le Domain Model.

**Finding 2 — L'Anchor delta :** *"Ce que je vais faire pendant la séance dépend de ce qu'il s'est passé depuis la dernière consultation."* L'Anchor de ce praticien n'est pas un résumé de la dernière séance — c'est l'évolution depuis la dernière séance. La question clinique est "qu'est-ce qui a changé ?" non "qu'est-ce qui s'est passé ?". C'est une variante delta de l'Anchor, distincte des profils précédents.

**Finding 3 — La clôture de journée à trois conditions :** *"Lorsque le dernier patient est parti, que mes télétransmissions sont faites et que tous les dossiers sont fermés."* C'est la définition la plus précise d'une clôture de journée observée dans le corpus — trois conditions explicites et mesurables.

La septième interview confirme l'Anchor (★★★★★) et révèle une dimension nouvelle du Domain Model : la distinction entre **information reçue** et **information intégrée**.

---

## 2. Interview Context

| Élément | Valeur observée |
|---|---|
| Profession | Kinésithérapeute |
| Mode d'exercice | Libéral |
| Logiciel | Vega (même que F-001) + Doctolib (RDV) |
| Documentation | Sélective — notes en fin de consultation |
| Fréquence de suivi | 1 à 2 fois par semaine |
| Type de travail | Traitement manuel + suivi symptomatique |
| Ancienneté | Non précisée |

---

## 3. Typical Day

### Reconstruction chronologique

| Moment | Activité | Nature |
|---|---|---|
| Arrivée | Blouse, rangement, ordinateur, préparation | Mise en condition physique + numérique |
| Premier patient | Ouverture du dossier, attente du patient | Préparation minimale |
| Pré-consultation | Aucune préparation avancée | [Délibéré — cf. §4] |
| Pendant la consultation | Point sur la semaine écoulée | Chargement du delta clinique |
| Pendant la consultation | Traitement manuel | Soin |
| Pendant la consultation | Notes rarissimes | Exception uniquement |
| Fin de consultation | Rédaction des notes | Documentation sélective |
| Entre deux patients | Traitement des documents si temps disponible | Conditionnel — souvent différé |
| Fin de journée | Facturation + envoi documents + pointage Vega + vérification Doctolib + télétransmission | Batch administratif |
| Clôture | Fermeture de tous les dossiers | Rituel de clôture cognitif |

### Observation sur la structure temporelle

La journée présente une structure **strictement compartimentée** : le temps de soin est protégé de l'administratif et de la communication externe. Tout ce qui n'est pas le patient est traité en dehors de la consultation — à la pause déjeuner, en fin de journée, voire plus tard.

L'ouverture de la journée est remarquablement sobre : *"Je me réveille, je m'habille, je me brosse les dents et je vais travailler."* Cette description, volontairement prosaïque, reflète une routine non-rituelle — contrairement à F-001 (même profession) dont le rituel matinal est chargé de sens (café + collègue + coordination). Ce n'est pas un oubli — c'est une différence de style cognitif.

---

## 4. Clinical Workflow

### Première consultation

1. Création de la fiche patient
2. Coordonnées
3. Note de la demande du patient
4. Bilan initial

**Observation :** Structure identique à F-006 (sage-femme) et F-002 (infirmière). La première consultation est universellement plus structurée que les suivis.

### Consultations de suivi — L'Anchor delta

> *"En général, je vois mes patients une à deux fois par semaine. Ce que je vais faire pendant la séance dépend de ce qu'il s'est passé depuis la dernière consultation. Si les symptômes ont évolué, si le patient a eu une amélioration ou une aggravation, j'adapte complètement ma prise en charge."*

> *"Je commence toujours par faire le point sur la semaine écoulée. Je demande comment cela s'est passé depuis la dernière séance."*

**Observation :** L'Anchor de ce praticien est **delta-centré** : ce qui change depuis la dernière séance, non ce qui s'est passé lors de la dernière séance. La nuance est cliniquement significative :

| Type d'Anchor | Question clinique | Profils |
|---|---|---|
| Anchor narratif | "Qu'est-ce qui s'est passé la dernière fois ?" | F-002, F-004 |
| Anchor sécuritaire | "Quelles sont les données de sécurité ?" | F-003 |
| Anchor comparatif | "Comment a évolué ce finding ?" | F-005 |
| Anchor protocolaire | "Où en est le protocole ?" | F-006 |
| **Anchor delta** | **"Qu'est-ce qui a changé depuis la dernière fois ?"** | **F-007** |

L'Anchor delta n'est pas la dernière séance — c'est l'espace entre deux séances. La question clinique est celle de l'évolution, non de l'état.

**Note :** Ce type d'Anchor est également présent dans F-006 (*"Ce qui s'est passé depuis la dernière consultation"*) et F-004 (*"Qu'est-ce qui a changé depuis la dernière fois ?"*). L'Anchor delta est une variante commune aux suivis itératifs.

### Prise de notes

> *"Très rarement [pendant la consultation]. Si une information importante apparaît pendant que nous discutons, je retourne rapidement à mon ordinateur pour la noter. Sinon, j'écris tout à la fin de la consultation."*

> *"J'écris uniquement ce qui me paraît pertinent pour suivre l'évolution des symptômes et adapter la prise en charge."*

**Observation :** Documentation sélective et différée — cohérente avec F-004, F-006. La note post-consultation est orientée vers la continuité, non vers l'archive. *"Si une idée me revient pour la séance suivante"* — confirmation de H-F004-03 (note post-consultation = production de l'Anchor futur).

**Cohérence avec H-F004-03 :** Les notes sont écrites *"pour suivre l'évolution des symptômes et adapter la prise en charge"* — formulation prospective. C'est la deuxième confirmation de ce pattern.

### Conservation des informations

> *"En général, je garde tout. Si je l'ai écrit, je ne le supprime pas."*

**Observation :** Ce praticien écrit peu, mais ce qui est écrit est permanent. La sélectivité est à l'entrée (que noter ?), pas à la sortie (que supprimer ?). C'est une politique de conservation qui crée un dossier épars mais complet.

---

## 5. Administrative Workflow

### Fin de journée — Batch administratif

> *"Je termine les facturations. J'envoie les documents si nécessaire. Je pointe mes consultations dans Vega. Je vérifie que cela correspond aux rendez-vous Doctolib. Puis je télétransmets les feuilles de soins pour les remboursements."*

**Observation :** Le batch administratif de fin de journée est le plus détaillé décrit dans le corpus — cinq étapes séquentielles explicites. Toutes se déroulent après le dernier patient.

**La triple clôture :**

> *"Lorsque le dernier patient est parti, que mes télétransmissions sont faites et que tous les dossiers sont fermés."*

**Observation :** C'est la définition la plus précise d'une clôture de journée observée dans le corpus. Trois conditions nécessaires et suffisantes :
1. Condition clinique : dernier patient parti
2. Condition administrative : télétransmissions faites
3. Condition documentaire : tous les dossiers fermés

Aucune des trois n'est optionnelle.

### Traitement des documents externes

> *"Si j'ai le temps, je consulte le document et je l'ajoute immédiatement au dossier. Si je n'ai pas le temps, je ne l'ouvre pas. Je le traiterai à la pause déjeuner ou en fin de journée."*

**Observation :** Le traitement est binaire : intégration immédiate ou report complet. Pas de traitement partiel ("je le lis mais je l'intègre plus tard"). Un document non intégré n'est pas consulté.

---

## 6. Cognitive Analysis

### Objectifs cognitifs identifiés

1. **Saisir l'évolution depuis la dernière séance** — delta clinique
2. **Adapter le traitement en temps réel** à cette évolution
3. **Protéger le flux de consultation** de toute interruption externe
4. **Fermer la journée complètement** — aucune tâche en suspens

### Le finding central — L'information en limbo

> *"À quel moment cette information fait-elle réellement partie du dossier ? — Lorsqu'elle est saisie dans le dossier. Tant que je n'ai pas eu le temps de l'inscrire, elle n'en fait pas vraiment partie."*

**Observation :** C'est la citation la plus importante de cette interview. Elle décrit un état intermédiaire de l'information clinique :

```
ÉTAT 1 — Reçue      : Le praticien a reçu l'information (SMS, document, appel)
                       Elle est connue du praticien mais pas du système
          ↓
ÉTAT 2 — Intégrée   : L'information est saisie dans le dossier
                       Elle est disponible pour les décisions cliniques
                       Elle est retrouvable par un autre praticien
          ↓
ÉTAT 3 — Utilisée   : L'information a influencé une décision clinique
```

Pendant la durée de l'État 1 (limbo), l'information :
- Existe dans la mémoire de travail du praticien
- N'existe pas pour le système
- Ne peut pas influencer la décision d'un remplaçant
- Ne sera pas retrouvée dans une recherche
- Peut être oubliée si la journée est dense

[INTERPRÉTATION] Ce phénomène est une source potentielle d'incohérences cliniques non détectées. Si le praticien est absent le lendemain, les informations reçues mais non intégrées sont perdues. Le système ne sait pas qu'elles existent.

### Charge cognitive

Stratégies observées :
- Pas de préparation en avance (charge minimale pré-consultation)
- Pas de téléphone pendant les consultations (protection du flux)
- Batch de fin de journée (décharge des tâches administratives)
- Documentation minimale et différée

Ce profil présente la charge cognitive la plus activement gérée du corpus — chaque décision d'organisation peut être interprétée comme une stratégie de réduction de charge.

---

## 7. Collaboration Analysis

| Acteur | Type | Fréquence | Support |
|---|---|---|---|
| Confrères | Information entrante | Ponctuelle | Appel / SMS |
| Patients | Information entrante | Quotidienne | Document papier / SMS |
| Médecins prescripteurs | Coordination | Non précisée | Non précisé |

**Observation :** La collaboration est présentée uniquement comme une source d'informations entrantes, jamais comme un processus bidirectionnel actif. Ce praticien est en mode réception, pas en mode coordination.

**Le problème du timing de l'intégration :**

> *"Si je n'ai pas le temps, je ne l'ouvre pas."*

**Observation :** Cette décision a des conséquences pour la coordination inter-professionnelle. Si un confrère envoie un document urgent, ce document peut rester dans la file d'attente jusqu'au soir. Le confrère ne sait pas si l'information a été reçue, lue, ou intégrée.

---

## 8. Pain Points

### Pain Point 1 — Information reçue mais non intégrée : la zone limbo

**Description :** Les informations reçues pendant la journée (SMS, documents) ne sont pas intégrées immédiatement faute de temps. Elles existent dans un état intermédiaire — connues du praticien, inconnues du système.

**Citation :** *"Tant que je n'ai pas eu le temps de l'inscrire, elle n'en fait pas vraiment partie."*

**Impact :** Risque d'oubli. Incohérence temporelle entre la réalité clinique et le dossier. Impossibilité pour un tiers de savoir ce qui a été reçu.

### Pain Point 2 — Gestion du timing des documents externes

**Description :** Les documents reçus pendant la journée ne peuvent pas toujours être traités immédiatement. La gestion de cette file d'attente est manuelle et informelle.

**Citation :** *"Si je n'ai pas le temps, je ne l'ouvre pas. Je le traiterai à la pause déjeuner ou en fin de journée."*

**Impact :** Retard d'intégration. Information cliniquement pertinente qui n'atteint pas le dossier en temps réel.

---

## 9. Positive Practices

### Pratique 1 — Protection absolue du temps de consultation

Ni téléphone, ni messages, ni documents pendant les consultations. La protection est totale et consciente.

### Pratique 2 — Documentation sélective et permanente

Écrire uniquement ce qui est pertinent, mais ne jamais supprimer. La sélectivité à l'entrée évite le bruit documentaire sans risquer de perdre de l'information utile.

### Pratique 3 — Triple clôture de journée

Les trois conditions de clôture (dernier patient + transmissions + dossiers) garantissent qu'aucune tâche n'est laissée en suspens. La journée est réellement terminée quand les trois conditions sont remplies.

### Pratique 4 — Intégration immédiate si temps disponible

*"Si j'ai le temps, je consulte le document et je l'ajoute immédiatement au dossier."* — la règle d'or de l'intégration : si le contexte le permet, intégrer immédiatement pour éviter le limbo.

---

## 10. Opportunities for MedLink

### Opportunité 1 — File d'attente des informations non intégrées

**Problème :** Les informations reçues mais non intégrées n'ont pas de représentation dans le système. Elles existent dans un état invisible.
**Justification :** *"Tant que je n'ai pas eu le temps de l'inscrire, elle n'en fait pas vraiment partie."*
**Direction :** Une file d'attente visible dans le Workspace — "À intégrer" — liste les informations reçues (documents, messages) en attente d'intégration dans le dossier. Elle est traitée par le praticien quand il a le temps, sans urgence.

### Opportunité 2 — Anchor delta : afficher l'évolution, pas la dernière séance

**Problème :** L'Anchor de ce praticien n'est pas le contenu de la dernière séance — c'est l'évolution depuis.
**Justification :** *"Ce que je vais faire dépend de ce qui s'est passé depuis la dernière consultation."*
**Direction :** Pour les suivis symptomatiques à fréquence élevée, l'Anchor peut inclure une vue delta — surlignant ce qui a changé par rapport à la dernière séance plutôt que restituant la séance entière.

### Opportunité 3 — Tableau de bord de clôture journalière

**Problème :** La clôture de journée implique plusieurs conditions vérifiées manuellement (transmissions, dossiers).
**Justification :** Triple clôture explicite dans le verbatim.
**Direction :** Une vue "Clôture" en fin de journée affiche l'état des trois conditions : dossiers fermés (✓/✗), transmissions faites (✓/✗), documents envoyés (✓/✗). Le praticien voit d'un coup d'œil ce qui reste à faire.

---

## 11. Candidate Hypotheses

### H-F007-01 — Les informations cliniques existent dans trois états distincts : reçue, intégrée, utilisée

**Description :** Entre la réception d'une information (SMS, document) et son utilisation dans une décision clinique, il existe un état intermédiaire — l'intégration dans le dossier. Pendant cet intermédiaire, l'information est connue du praticien mais invisible au système.

**Justification :** *"Tant que je n'ai pas eu le temps de l'inscrire, elle n'en fait pas vraiment partie."* — formulation explicite et spontanée.

**Niveau de confiance :** Observation unique — mais conceptuellement robuste et généralisable
**Questions ouvertes :** Combien d'informations restent en limbo en moyenne par journée ? Ce phénomène est-il plus fréquent dans les cabinets à fort volume ? Quelle est la durée moyenne du limbo ?

---

### H-F007-02 — Pour les suivis itératifs symptomatiques, l'Anchor est le delta depuis la dernière séance, non son contenu

**Description :** Quand le suivi est fréquent (1-2 fois par semaine) et piloté par les symptômes, la question clinique centrale est l'évolution — pas l'état à la dernière séance. L'Anchor est donc un delta, non un résumé.

**Justification :** *"Ce que je vais faire dépend de ce qui s'est passé depuis la dernière consultation."* + *"Faire le point sur la semaine écoulée."*

**Niveau de confiance :** Pattern émergent — présent en F-004, F-006, F-007 sous des formes légèrement différentes
**Questions ouvertes :** Le delta est-il calculable automatiquement (comparaison des notes de deux séances) ou seulement observable par le praticien lors du questionnement ?

---

### H-F007-03 — La clôture de journée est un rituel cognitif à conditions explicites, pas un simple arrêt du travail

**Description :** La fin de journée n'est pas définie par l'heure mais par la réalisation de conditions spécifiques. Ces conditions varient selon le praticien mais sont toujours explicites pour le praticien lui-même.

**Justification :** Triple condition explicite : dernier patient + transmissions + dossiers.

**Niveau de confiance :** Pattern émergent — présent dans F-001 (tour du cabinet) et F-007 (triple condition)
**Questions ouvertes :** Toutes les professions ont-elles un rituel de clôture ? Quelles sont les conditions typiques par profil ?

---

### H-F007-04 — La comparaison intra-profession révèle que le style cognitif est individuel, pas professionnel

**Description :** F-001 et F-007 exercent la même profession dans le même mode d'exercice. F-001 : mémoire pure, zéro notes, raisonnement embodied. F-007 : notes sélectives, delta-centré, batch administratif structuré. Les différences cognitives sont individuelles, non professionnelles.

**Justification :** Contraste direct entre F-001 et F-007.

**Niveau de confiance :** Pattern émergent — 2 profils de même profession
**Questions ouvertes :** L'ancienneté explique-t-elle cette différence ? L'environnement (cabinet solo vs binôme) ? La personnalité ? Le type de patientèle ?

---

## 12. Candidate Design Principles

### DP-F007-01 — Le Domain Model distingue "information reçue" et "information intégrée"

**Principe :** Une information externe (document, résultat, message) a un statut "reçue" dès qu'elle entre dans le système, et un statut "intégrée" quand elle est associée à un dossier et disponible pour les décisions cliniques. Ces deux états sont distincts et visibles.

**Justification :** H-F007-01 — le limbo est réel et a des conséquences cliniques.

**Conséquences :** Le Domain Model inclut une entité `InformationEntrante` avec les statuts `REÇUE`, `EN_ATTENTE`, `INTÉGRÉE`. La file d'attente "À intégrer" est une vue sur les informations en statut `REÇUE` ou `EN_ATTENTE`.

---

### DP-F007-02 — L'Anchor peut être configuré en mode "delta" pour les suivis fréquents

**Principe :** Pour les suivis à fréquence ≥ 1 par semaine et pilotés par les symptômes, l'Anchor peut afficher le delta depuis la dernière séance plutôt que le contenu de la dernière séance. La configuration est optionnelle — le praticien choisit son mode d'Anchor.

**Justification :** H-F007-02 — l'Anchor delta est un pattern cliniquement distinct.

**Conséquences :** L'Anchor a plusieurs modes de présentation configurables. Le mode delta est calculé en comparant les notes de deux séances successives sur les mêmes dimensions.

---

### DP-F007-03 — La vue de clôture journalière affiche l'état des conditions restantes

**Principe :** En fin de journée, le Workspace affiche les conditions de clôture non remplies : dossiers ouverts, transmissions en attente, documents non envoyés. La journée est "terminée" quand toutes les conditions sont remplies.

**Justification :** H-F007-03 — la clôture est multi-conditions, non temporelle.

**Conséquences :** Un badge ou indicateur de clôture visible en fin de journée. Il disparaît quand toutes les conditions sont satisfaites.

---

## 13. Questions for Future Interviews

1. **Le phénomène du limbo est-il universel ?** Tester avec d'autres praticiens à fort volume si cette zone d'incertitude entre réception et intégration existe et est perçue comme un problème.
2. **Combien d'informations restent en limbo par journée ?** Quantification nécessaire pour évaluer l'impact réel.
3. **Que se passe-t-il quand le praticien est absent le lendemain ?** Les informations en limbo sont-elles perdues ? Transmises oralement ?
4. **La comparaison F-001 / F-007 — qu'est-ce qui explique les différences ?** Ancienneté ? Type de patientèle ? Personnalité ? Formation ?
5. **Le rituel de clôture de journée est-il universel ?** Identifier les conditions de clôture dans les prochaines interviews.
6. **La documentation sélective est-elle une pratique consciente ou émergente ?** Ce praticien a-t-il décidé d'écrire peu, ou cela s'est-il installé progressivement ?

---

## 14. Impact sur le MedLink Blueprint

| Domaine | Observation | Hypothèse | Proposition |
|---|---|---|---|
| **Domain Model** | Information en limbo entre réception et intégration | H-F007-01 | Entité `InformationEntrante` avec statuts REÇUE / EN_ATTENTE / INTÉGRÉE |
| **Domain Model** | L'information n'existe cliniquement que quand elle est intégrée | H-F007-01 | La clé de requête du dossier porte sur les informations INTÉGRÉES — pas REÇUES |
| **Workspaces** | File d'attente "À intégrer" — informations reçues non traitées | H-F007-01 | Section "En attente d'intégration" dans le Workspace praticien |
| **Workspaces** | Anchor delta pour suivis fréquents symptomatiques | H-F007-02 | Mode Anchor configurable — contenu de la dernière séance OU delta depuis la dernière séance |
| **Workspaces** | Clôture de journée multi-conditions | H-F007-03 | Vue Clôture — indicateur de statut des conditions de fin de journée |
| **Clinical Reasoning** | Style cognitif individuel dans la même profession | H-F007-04 | MedLink ne peut pas présupposer le style cognitif depuis la profession — la configuration est individuelle |
| **Collaboration** | Document reçu mais non intégré = invisible pour un tiers | H-F007-01 | La collaboration inter-professionnelle doit notifier la réception, pas seulement l'envoi |

---

## 15. Confidence Assessment

| Conclusion | Niveau | Justification |
|---|---|---|
| L'information en limbo est un phénomène réel | ★★★★★ | Verbatim direct, spontané, précis — *"elle n'en fait pas vraiment partie"* |
| L'Anchor delta est un pattern pour les suivis fréquents | ★★★★ | Confirmé sur F-004, F-006, F-007 sous des formes proches |
| La clôture est multi-conditions | ★★★★ | Verbatim direct + cohérent avec F-001 (tour du cabinet) |
| Le style cognitif est individuel, non professionnel | ★★★★ | Contraste direct F-001 / F-007 — même profession, deux architectures cognitives |
| La documentation sélective est consciente | ★★★ | Verbatim cohérent — manque d'interrogation sur le pourquoi |

---

## 16. CC-000 Cross-Reference

| Hypothèse CC-000 | Statut après cette interview | Évidence | Recommandation |
|---|---|---|---|
| **H-01** Pertinence contextuelle | ✅ Confirmée — 7e profil | Elle ouvre le dossier du premier patient = accès au contexte avant l'action | Maintenir |
| **H-02** Discontinuité contextuelle | ✅ Confirmée | Pas de téléphone pendant les consultations = protection active | Maintenir |
| **H-03** Cognition distribuée | ⚪ Partiellement | Informations reçues de confrères — mais traitement individuel différé | H-F007-01 ajoute une dimension : la coordination échoue quand l'info reste en limbo |
| **H-04** Expertise et fluidité | ✅ Confirmée | Adaptation complète selon l'évolution — raisonnement dynamique, non protocolaire | Maintenir |
| **H-05** Ancrage par transmission | ✅ Confirmée — 7e profil | *"Faire le point sur la semaine écoulée"* = Anchor delta | Maintenir |
| **H-06** Attribution et confiance | ⚪ Non adressée | | À explorer |
| **H-07** Charge cognitive et progressivité | ✅ Confirmée | Batch, protection, documentation minimale = gestion active de la charge | Maintenir |

### Nouveau concept pour CC-000 — L'information en limbo

**Proposition d'ajout à CC-000 :**

> **H-08 — L'information clinique peut exister dans un état intermédiaire entre réception et disponibilité**
>
> *Hypothèse :* Entre le moment où un praticien reçoit une information externe (résultat, document, message) et le moment où cette information est intégrée dans le dossier et disponible pour les décisions cliniques, il existe une zone d'incertitude. Pendant cette période, l'information est connue du praticien mais invisible pour le système et pour tout autre acteur.
>
> *Confirme :* Les praticiens décrivent spontanément une distinction entre "recevoir" et "intégrer". Des informations importantes sont temporairement perdues lors des absences ou des remplacements.
>
> *Réfute :* Tous les praticiens intègrent les informations immédiatement dans la pratique réelle. La zone limbo est négligeable en durée.
>
> *Relation :* H-F007-01 — impact sur le Domain Model et la collaboration inter-professionnelle.

---

## Comparaison F-001 vs F-007 — Même profession, deux architectures cognitives

| Dimension | F-001 — Mkine (1ère interview) | F-007 — Mkine (cette interview) |
|---|---|---|
| Système de continuité | Mémoire | Notes sélectives |
| Raisonnement en séance | Embodied / tactile | Delta clinique + adaptation |
| Notes | Quasi-nulles | Sélectives, fin de consultation |
| Anchor | Aucun (mémoire) | Delta depuis dernière séance |
| Rituel de clôture | Tour physique du cabinet | Triple condition (patient + transmissions + dossiers) |
| Rapport aux documents externes | Non problématique | Phénomène du limbo identifié |
| Collaboration | Réseau informel (psychologue, médecins) | Informations entrantes différées |
| Logiciel | Administratif uniquement | Clinique + administratif |

**Conclusion :** La profession ne détermine pas l'architecture cognitive. Les deux profils sont également valides et également efficaces dans leur contexte. MedLink doit accommoder les deux — et tous les intermédiaires.

---

## Comparaison inter-interviews — État complet après F-007

| Dimension | F-001 | F-002 | F-003 | F-004 | F-005 | F-006 | F-007 |
|---|---|---|---|---|---|---|---|
| Anchor | Aucun | Narratif | Sécuritaire | Narratif/émotionnel | Comparatif | Protocolaire | **Delta** |
| Limbo informationnel | Non | Non | Non | Non | Non | Non | **Oui — 1ère identification** |
| Clôture rituelle | Oui (tour) | Non précisée | Non précisée | Non précisée | Non précisée | Non précisée | **Oui (triple condition)** |
| Style cognitif | Embodied | Analytique | Stratégique | Analytique/narratif | Technique | Protocolaire | Delta-adaptatif |

---

## Références

- Interview brute F-007 — 2026-07-29 (verbatim complet disponible)
- F-001 — Premier profil kinésithérapeute (comparaison directe)
- CC-000 Clinical Cognitive Architecture v1.0 — 2026-07-29
- UX-000 Product Experience Principles — 2026-07-29
- Hutchins, E. (1995) — *Cognition in the Wild* — pertinent pour H-F007-01 (artefacts en transit)
- Suchman, L. (1987) — *Plans and Situated Actions* — pertinent pour H-F007-04 (style cognitif situé)
