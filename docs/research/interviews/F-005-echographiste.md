# F-005 — Clinical Interview Report
## Échographiste — Cabinet de Radiologie / Imagerie

**Type :** Clinical Interview Report
**Statut :** Draft — Analyse initiale
**Date :** 2026-07-29
**Analyste :** MedLink Research Program
**Framework :** F-XXX Clinical Interview Report v1.0

**Note méthodologique :** Interview de qualité intermédiaire — verbatim disponible mais en format questions/réponses condensé. Les citations directes sont fiables. L'environnement d'exercice (cabinet de radiologie, clinique, hôpital) n'est pas précisé.

---

## 1. Executive Summary

Cette interview documente la pratique d'une échographiste. Elle introduit dans le corpus un profil **diagnostique comparatif** — radicalement différent des quatre profils précédents.

Le premier finding est la **cinquième confirmation de l'Anchor**. La question *"Pourquoi ce patient est-il devant moi aujourd'hui ?"* est structurellement identique aux patterns observés dans F-002, F-003 et F-004. Mais son contenu est entièrement différent : motif + dernier contrôle + résultats précédents + évolution. L'Anchor de l'échographiste est **comparatif**, non narratif.

Le deuxième finding est nouveau dans le corpus : **la comparaison temporelle est une dimension clinique centrale**. La plus grosse difficulté identifiée est de retrouver les anciens examens et de savoir depuis combien de temps une anomalie existe. Ce n'est pas un problème de recherche (F-004) — c'est un problème de **comparaison temporelle d'un finding clinique**.

Le troisième finding est le protocole d'urgence explicite : *"Je ne laisse jamais repartir un patient sans solution."* C'est la première déclaration d'invariant de sécurité clinique rencontrée dans le corpus. Elle révèle qu'un logiciel clinique doit supporter des protocoles de coordination urgente, pas seulement des workflows nominaux.

Le quatrième finding est un point d'infrastructure : les **images médicales** sont un artefact clinique central pour ce profil. Leur accès, leur stockage et leur comparaison sont hors du périmètre MVP de MedLink, mais doivent être anticipés dans le modèle de données.

La conclusion inter-interviews proposée dans le matériau source est confirmée : **quel que soit le métier, le praticien cherche le contexte utile à la décision clinique du moment, pas un dossier complet**. La nature de ce contexte est role-specific.

---

## 2. Interview Context

| Élément | Valeur observée |
|---|---|
| Profession | Échographiste |
| Mode d'exercice | Non précisé (cabinet / clinique / hôpital) |
| Logiciel principal | Logiciel métier non précisé + Doctolib (gestion RDV) |
| Documentation | Progressive — débute pendant l'examen pour les actes longs |
| Relation amont | Médecin prescripteur (ordonnance) |
| Relation aval | Médecin prescripteur (compte rendu + appel si urgent) |
| Type d'acte | Échographie + Doppler |
| Gestion urgences | Protocole explicite : contact immédiat du prescripteur |

---

## 3. Typical Day

### Reconstruction chronologique

| Moment | Activité | Nature |
|---|---|---|
| Début de journée | Ouverture logiciel + planning | Planification |
| Début de journée | Revue des patients de la journée | Préparation cognitive |
| Pré-examen | Ouverture du dossier | Compréhension du motif de venue |
| Pré-examen | Lecture : ordonnance + motif + comptes rendus précédents + images | Chargement du contexte diagnostique |
| Pendant l'examen | Prise de notes en temps réel | Capture des findings |
| Pendant l'examen (actes longs) | Début de rédaction du compte rendu | Documentation progressive |
| Après l'examen | Finalisation du compte rendu | Rédaction + vérification mesures |
| Après l'examen | Validation des images | Contrôle qualité |
| Après l'examen | Envoi au médecin prescripteur | Coordination inter-professionnelle |
| Si anomalie urgente | Appel direct au prescripteur | Escalade immédiate |
| Si urgence | Organisation de la prise en charge | Coordination active |
| Suivi | Contact avec prescripteur (ordonnance / téléphone / logiciel) | Coordination continue |

### Observation sur la structure temporelle

La journée de l'échographiste est **cadrée par des actes techniques discrets** (un examen = un cycle complet : préparation → réalisation → compte rendu → transmission). C'est une structure différente de tous les profils précédents qui opèrent dans la durée (suivi long terme) ou en flux continu (consultations).

Chaque acte a sa propre boucle de préparation-exécution-clôture. Le logiciel doit supporter cette structure cyclique, pas un suivi longitudinal.

---

## 4. Clinical Workflow

### Pré-examen — Anchor diagnostique

> *"Je cherche : l'ordonnance, le motif de l'examen, les comptes rendus précédents, les anciennes images si elles existent."*

> *"Pourquoi ce patient est-il devant moi aujourd'hui ? Quel est le motif ? Quel était le dernier contrôle ? Qu'est-ce qui avait été retrouvé ? Est-ce qu'il y a une évolution ?"*

**Observation :** L'Anchor de l'échographiste est structuré en quatre dimensions :
1. **Motif actuel** — pourquoi ce patient vient aujourd'hui
2. **Date du dernier contrôle** — temporalité du suivi
3. **Résultats précédents** — baseline comparative
4. **Évolution** — delta entre l'état précédent et l'état attendu

C'est un Anchor **comparatif** — son utilité n'est pas de connaître l'état actuel du patient mais de comprendre la **trajectoire** d'un finding clinique dans le temps.

**Comparaison avec les Anchors précédents :**

| Profil | Nature de l'Anchor |
|---|---|
| F-002 Sophrologue | Narratif + intentionnel (état émotionnel, décision, objectif) |
| F-003 Médecin | Sécuritaire (traitements, allergies, événements récents) |
| F-004 Psychologue | Narratif + émotionnel (thèmes, marquants, intention) |
| F-005 Échographiste | Comparatif + diagnostique (motif, baseline, évolution) |

### Pendant l'examen — Documentation progressive

> *"J'écris les éléments importants au fur et à mesure. Pour les examens longs, comme un Doppler, je peux commencer le compte rendu pendant l'examen."*

**Observation :** C'est le profil de documentation **le plus intensif en temps réel** du corpus. Contrairement à F-004 (mots-clés uniquement) ou F-003 (quasi rien), l'échographiste peut initier le document final pendant l'acte lui-même. La documentation est **coextensive** à l'acte, non postérieure.

**Interprétation [INTERPRÉTATION] :** Cette pratique est possible parce que les findings d'une échographie sont descriptibles en temps réel de façon standardisée (mesures, topographie, caractéristiques). Ce n'est pas du raisonnement tacite (F-001) — c'est de la description technique structurée.

### Protocole d'urgence — Invariant de sécurité clinique

> *"Je ne laisse jamais repartir un patient sans solution. J'appelle directement le médecin prescripteur si nécessaire. S'il faut une prise en charge urgente, je l'organise immédiatement."*

**Observation :** C'est la première déclaration d'un **invariant de sécurité clinique explicite** dans le corpus. Ce n'est pas une préférence ou une pratique — c'est une règle absolue. Elle révèle un workflow d'escalade :

```
Finding anormal détecté
        ↓
Évaluation de la gravité
        ↓
[Urgent] → Appel prescripteur → Organisation prise en charge immédiate
[Non urgent] → Compte rendu → Envoi au prescripteur
```

Ce workflow existe dans la pratique réelle mais n'est pas outillé de façon intégrée dans les logiciels actuels.

---

## 5. Administrative Workflow

### Compte rendu et transmission

- Rédaction du compte rendu (pendant et après l'examen)
- Vérification des mesures
- Validation des images
- Envoi au médecin prescripteur

**Observation :** Le compte rendu est à la fois un document clinique (résultats) et un document de coordination (transmis au prescripteur). Il joue le rôle de Contribution Clinique formelle dans ce contexte.

### Gestion des rappels et du suivi

> *"Les rappels sont gérés via Doctolib ou par le secrétariat."*

**Observation :** La gestion du suivi est externalisée (Doctolib ou secrétariat). L'échographiste ne gère pas elle-même les rappels patients — elle délègue. C'est cohérent avec une pratique centrée sur l'acte technique, non sur le suivi longitudinal.

---

## 6. Cognitive Analysis

### Objectifs cognitifs identifiés

1. **Comprendre la question clinique** posée par le prescripteur avant de commencer l'examen
2. **Situer le patient dans une trajectoire** — est-ce la première fois ? Y a-t-il une évolution ?
3. **Décrire techniquement** les findings pendant l'examen
4. **Détecter et traiter les urgences** — jamais laisser partir un patient sans solution

### Informations recherchées pré-examen

| Information | Utilité |
|---|---|
| Ordonnance | Comprendre la question clinique posée |
| Motif | Orienter l'examen |
| Comptes rendus précédents | Établir la baseline comparative |
| Anciennes images | Comparaison visuelle directe |

**Observation :** La **question clinique** (pourquoi ce patient est ici) est la première information cherchée. Ce n'est pas une préférence — c'est une nécessité technique. On ne peut pas réaliser une échographie sans savoir ce qu'on cherche.

### La comparaison temporelle — finding central

> *"Retrouver les anciens examens. Comparer avec les précédents. Savoir rapidement depuis quand une anomalie existe."*

**Observation :** Ce besoin est **fondamentalement temporel** — il ne s'agit pas de trouver une information dans le dossier (F-004) mais de **comprendre l'évolution dans le temps d'un finding clinique**. Deux dimensions :
1. **Comparaison directe** : l'anomalie était-elle là la dernière fois ? A-t-elle changé ?
2. **Datation** : depuis quand existe-t-elle ? (ancienneté d'une anomalie = information diagnostique)

[INTERPRÉTATION] Ces deux dimensions sont des informations diagnostiques directes — pas des informations contextuelles. Elles influencent le diagnostic et potentiellement la prise en charge.

### Charge cognitive

- Réduite par la compréhension préalable du motif
- Augmentée par la difficulté de comparaison avec les anciens examens
- L'examen lui-même est une tâche technique à forte concentration — la charge documentaire doit être minimisée pendant l'acte

---

## 7. Collaboration Analysis

C'est le profil avec la **collaboration inter-professionnelle la plus structurée** du corpus.

| Acteur | Rôle | Direction | Support |
|---|---|---|---|
| Médecin prescripteur | Donne la question clinique | Amont → Échographiste | Ordonnance |
| Médecin prescripteur | Reçoit les résultats | Échographiste → Aval | Compte rendu |
| Médecin prescripteur | Gère l'urgence si nécessaire | Bilatéral | Téléphone direct |
| Secrétariat / Doctolib | Gestion des rappels | Délégué | Logiciel / Humain |

**Observation :** L'échographiste est un **nœud de coordination bi-directionnel** : elle reçoit une prescription et retourne un compte rendu. Elle est dépendante du médecin prescripteur pour la question clinique, et le médecin prescripteur dépend d'elle pour la réponse.

Cette dépendance mutuelle crée un **protocole de communication structuré** — particulièrement visible dans le cas d'urgence (appel direct). C'est la première fois dans le corpus que la collaboration inter-professionnelle est aussi explicitement décrite avec un protocole d'escalade.

---

## 8. Pain Points

### Pain Point 1 — Retrouver et comparer les anciens examens

**Description :** L'accès aux examens précédents et la comparaison des résultats est lent et difficile.

**Citation :** *"Retrouver les anciens examens. Comparer avec les précédents. Savoir rapidement depuis quand une anomalie existe."*

**Impact :** Temps perdu avant et pendant l'examen. Risque de rater une évolution significative faute de comparaison. Potentiellement : sous-détection ou sur-détection d'anomalies.

### Pain Point 2 — Absence d'une vue comparative temporelle intégrée

**Description :** Pas de vue qui montre directement l'évolution d'un finding entre deux examens.

**Citation :** *"Est-ce qu'il y a une évolution ?"* — la question posée spontanément comme besoin prioritaire.

**Impact :** Reconstruction manuelle de la comparaison depuis deux documents séparés.

---

## 9. Positive Practices

### Pratique 1 — Invariant de sécurité clinique

*"Je ne laisse jamais repartir un patient sans solution."* — Cette règle absolue est une pratique de sécurité clinique non formalisée mais universellement appliquée. Elle devrait être supportée par le logiciel.

### Pratique 2 — Documentation progressive (coextensive à l'acte)

Commencer le compte rendu pendant l'examen réduit la charge post-acte et améliore la précision (les observations sont notées au moment où elles sont faites).

### Pratique 3 — Contact direct en cas d'urgence

Le lien direct avec le médecin prescripteur par téléphone est un mécanisme d'escalade rapide et efficace. Il fonctionne sans logiciel mais mérite d'être supporté.

---

## 10. Opportunities for MedLink

### Opportunité 1 — Anchor diagnostique : motif + baseline + évolution

**Problème :** Pas de vue agrégée pré-examen répondant à "pourquoi ce patient est ici et comment a-t-il évolué ?"
**Justification :** Question explicitement formulée comme le besoin prioritaire du logiciel.
**Direction :** Anchor échographiste = ordonnance/motif + dernier examen (date + résultats synthétiques) + delta attendu.

### Opportunité 2 — Vue comparative temporelle pour les findings cliniques

**Problème :** Pas de comparaison directe entre examens successifs.
**Justification :** Principale perte de temps identifiée. Potentiel diagnostic direct.
**Direction :** Vue "Évolution d'un finding" — affiche le même finding sur N examens successifs avec les dates. Applicable aux mesures (taille d'une lésion) et aux caractéristiques qualitatives.

### Opportunité 3 — Support au protocole d'urgence

**Problème :** La coordination urgente repose sur le téléphone direct — non tracée, non outillée.
**Justification :** *"J'appelle directement le médecin prescripteur si nécessaire."*
**Direction :** Notification urgente intégrée au logiciel — alerte le prescripteur avec le finding, la date, la disponibilité pour rappel. La traçabilité de l'alerte est conservée dans le dossier.

### Opportunité 4 — Référencement des images médicales (hors MVP)

**Problème :** Les anciennes images sont difficiles à retrouver et à comparer.
**Justification :** *"Les anciennes images si elles existent."*
**Direction (MVP) :** Référencer les images sans les stocker dans MedLink (référence vers le PACS ou l'archivage externe). Permettre l'accès en un clic depuis l'Anchor.
**Direction (post-MVP) :** Intégration PACS + comparaison d'images dans la vue évolution.

---

## 11. Candidate Hypotheses

### H-F005-01 — Pour les profils diagnostiques, la comparaison temporelle d'un finding est aussi importante que l'état courant

**Description :** L'échographiste ne cherche pas seulement "qu'est-ce qui est là aujourd'hui ?" mais "est-ce que c'était là avant, et comment a-t-il changé ?" Le delta temporel est une information clinique directe.

**Justification :** *"Savoir rapidement depuis quand une anomalie existe"* + *"Est-ce qu'il y a une évolution ?"*

**Niveau de confiance :** Observation unique — très cohérente avec la pratique d'imagerie médicale
**Questions ouvertes :** Ce besoin de comparaison temporelle existe-t-il dans d'autres spécialités diagnostiques (biologie, cardiologie) ? Quelle est la granularité nécessaire (dernier examen seul ? les 3 derniers ?) ?

---

### H-F005-02 — Un finding anormal déclenche un protocole de coordination immédiate qui doit être supporté par le logiciel

**Description :** La gestion des urgences cliniques est un workflow réel et fréquent. Il n'est pas exceptionnel — il fait partie du workflow nominal. Son absence dans les logiciels crée une coordination non tracée.

**Justification :** *"Je ne laisse jamais repartir un patient sans solution. J'appelle directement le médecin prescripteur si nécessaire."*

**Niveau de confiance :** Observation unique — mais cohérente avec les standards de pratique en imagerie
**Questions ouvertes :** Quelle est la fréquence des urgences dans une journée type ? Ce protocole est-il documenté dans la pratique actuelle ? Qui est tenu responsable si le prescripteur est injoignable ?

---

### H-F005-03 — La question clinique (le motif) est la première information nécessaire pour les profils diagnostiques, avant tout contexte patient

**Description :** Contrairement aux profils de suivi (psychologue, médecin), l'échographiste commence par la question posée, pas par l'état du patient. La question cadre l'examen.

**Justification :** L'ordonnance et le motif sont les premières choses consultées — avant les antécédents ou l'historique.

**Niveau de confiance :** Observation unique
**Questions ouvertes :** Cette priorité de la question clinique est-elle spécifique aux profils diagnostiques purs ? Varie-t-elle si l'échographiste connaît le patient de longue date ?

---

### H-F005-04 — L'Anchor est universel comme concept mais divergent comme contenu — confirmation sur 5 profils

**Description :** Cinq profils confirment qu'ils cherchent un contexte condensé avant d'agir. Cinq profils ont un contenu d'Anchor différent. Le concept est invariant ; le contenu est role-specific.

**Justification :** F-002 (état/décision/intention), F-003 (traitements/allergies/événements), F-004 (thèmes/émotions/progression), F-005 (motif/baseline/évolution).

**Niveau de confiance :** Pattern confirmé sur 5 profils — ★★★★★ pour le concept, ★★★★ pour la variabilité du contenu
**Questions ouvertes :** Existe-t-il un socle commun à tous les Anchors (identité patient, date de naissance, motif de la venue) ?

---

## 12. Candidate Design Principles

### DP-F005-01 — L'Anchor diagnostique inclut une dimension comparative temporelle

**Principe :** Pour les profils diagnostiques, l'Anchor contient : motif actuel + dernier résultat (date + synthèse) + évolution attendue ou observée. La comparaison temporelle est une composante de l'Anchor, pas une vue séparée optionnelle.

**Justification :** H-F005-01 — le delta temporel est une information clinique directe.

**Conséquences :** Le Domain Model doit capturer les findings cliniques avec leur temporalité, pas seulement leur valeur courante. La comparaison doit être calculable automatiquement.

---

### DP-F005-02 — Le logiciel supporte le protocole d'urgence, il ne l'ignore pas

**Principe :** Quand un finding urgent est identifié, le logiciel fournit un mécanisme de notification tracée vers le prescripteur. Ce mécanisme est intégré au workflow, pas ajouté comme une fonctionnalité optionnelle.

**Justification :** H-F005-02 — l'urgence fait partie du workflow nominal.

**Conséquences :** Notification urgente intégrée. Traçabilité de l'alerte dans le dossier (qui a été alerté, quand, avec quel finding). Gestion du cas "prescripteur injoignable".

---

### DP-F005-03 — Les images médicales sont référencées, pas stockées dans MedLink MVP

**Principe :** MedLink ne stocke pas les images DICOM. Il référence leur emplacement et permet l'accès depuis l'Anchor. Le stockage et la gestion des images est délégué à un système dédié (PACS).

**Justification :** Réalité technique et réglementaire des images médicales — hors périmètre MVP.

**Conséquences :** Le Domain Model inclut un type `ImageReference` (URL, date, PACS source, description). L'accès aux images se fait via un lien externe depuis MedLink.

---

## 13. Questions for Future Interviews

1. **Quelle est la fréquence des urgences dans une journée type ?** 1 par semaine ? 1 par jour ? Cela détermine la priorité du DP-F005-02.
2. **Comment est géré le cas "prescripteur injoignable" ?** Y a-t-il un protocole de cascade (médecin de garde, urgences) ?
3. **Quelle est la granularité de la comparaison temporelle nécessaire ?** Dernier examen seulement ? Les 3 derniers ? Tous les examens ?
4. **Les images sont-elles toujours disponibles pour comparaison ?** Quel pourcentage des patients ont des examens précédents accessibles ?
5. **L'ordonnance est-elle toujours présente avant l'examen ?** Que se passe-t-il pour les examens sans ordonnance ou avec ordonnance incomplète ?
6. **La collaboration avec le prescripteur est-elle bidirectionnelle en temps réel ?** Le prescripteur peut-il poser des questions pendant l'examen ?

---

## 14. Impact on MedLink Blueprint

| Domaine | Observation | Hypothèse | Proposition |
|---|---|---|---|
| **Workspaces** | Anchor comparatif (motif + baseline + évolution) | H-F005-04 | Workspace pré-examen = Anchor diagnostique avec dimension temporelle |
| **Domain Model** | Les findings ont une temporalité — l'évolution est une information clinique | H-F005-01 | Le Domain Model capture les findings avec leur date et leur valeur — permettant la comparaison |
| **Domain Model** | Images médicales = artefacts cliniques réels | DP-F005-03 | Type `ImageReference` dans le Domain Model dès MVP |
| **Collaboration** | Protocole d'escalade urgente structuré | H-F005-02 | Notification urgente intégrée — traçable dans le dossier |
| **Collaboration** | L'ordonnance est le point d'entrée de la relation prescripteur→échographiste | H-F005-03 | L'ordonnance est une entité du Domain Model — pas seulement un document attaché |
| **Patient Timeline** | Findings comparatifs temporels | H-F005-01 | La Timeline doit afficher la trajectoire d'un finding dans le temps, pas seulement des événements isolés |
| **IA** | "Est-ce qu'il y a une évolution ?" — comparaison automatique | H-F005-01 | Détection automatique d'évolution entre deux valeurs d'un même finding = cas d'usage IA à faible risque |

---

## 15. Confidence Assessment

| Conclusion | Niveau | Justification |
|---|---|---|
| L'Anchor est un invariant universel (5 confirmations) | ★★★★★ | Pattern robuste — 5 profils, 4 verbatim directs |
| La comparaison temporelle est une nécessité diagnostique | ★★★★ | Verbatim direct, cohérent avec pratique clinique en imagerie |
| L'urgence déclenche un protocole de coordination immédiate | ★★★★ | Verbatim direct + invariant clinique de sécurité |
| La question clinique (motif) prime sur l'état patient | ★★★ | Observation unique — logiquement cohérente |
| L'Anchor est role-specific dans son contenu | ★★★★★ | Confirmé sur 4 profils avec contenu différent à chaque fois |

---

## 16. CC-000 Cross-Reference

| Hypothèse CC-000 | Statut après cette interview | Évidence | Recommandation |
|---|---|---|---|
| **H-01** Pertinence contextuelle | ✅✅ Confirmée — 5e profil | *"Pourquoi ce patient est-il devant moi ?"* = demande de pertinence contextuelle immédiate | **Promouvoir vers invariant UX-000** |
| **H-02** Discontinuité contextuelle | ✅ Confirmée | Préparation pré-examen = prévention de la discontinuité | Maintenir |
| **H-03** Cognition distribuée | ✅ Confirmée — premier profil avec collaboration explicite | Workflow prescripteur→échographiste→prescripteur est un système distribué documenté | Maintenir — enrichir avec le protocole d'urgence |
| **H-04** Expertise et fluidité | ⚪ Non adressée directement | Documentation pendant l'examen = raisonnement technique structuré, non tacite | L'expertise de l'échographiste est probablement différente des profils manuels |
| **H-05** Ancrage par transmission | ✅✅ Confirmée — 5e profil | Comptes rendus précédents + images = Anchor comparatif | **Promouvoir vers invariant avec H-F005-04** |
| **H-06** Attribution et confiance | ✅ Partiellement confirmée | La provenance de l'ordonnance (médecin prescripteur) détermine le cadre de l'examen | Maintenir |
| **H-07** Charge cognitive et progressivité | ✅ Confirmée | Compréhension du motif avant l'examen = réduction de la charge pendant l'acte | Maintenir |

---

### Promotions recommandées vers UX-000 — après 5 interviews

Les deux hypothèses identifiées après F-004 sont maintenant confirmées par F-005 :

**H-01 → Invariant UX :**
*"Le praticien a besoin que le logiciel lui présente le contexte utile à la décision clinique du moment. Ce contexte est différent selon le rôle, mais son accessibilité immédiate est universelle."*
Confirmé par : F-002, F-003, F-004, F-005 (verbatim directs).

**H-05 → Invariant UX :**
*"Tout dossier de suivi s'ouvre sur l'Anchor — un résumé condensé du contexte clinique pertinent, configuré selon le rôle du praticien. L'Anchor n'est pas optionnel."*
Confirmé par : F-002, F-003, F-004, F-005 (verbatim directs, contenu différent à chaque fois).

**Nouveau — H-F005-04 → Formulation d'invariant supplémentaire :**
*"L'Anchor est role-specific dans son contenu. Il doit être configurable par rôle clinique, pas imposé comme structure générique."*

---

## Comparaison inter-interviews — État après F-005

| Dimension | F-001 Mkine | F-002 Infirmière | F-003 Médecin | F-004 Psychologue | F-005 Échographiste |
|---|---|---|---|---|---|
| Nature de l'Anchor | Aucun | Narratif/intentionnel | Sécuritaire | Narratif/émotionnel | Comparatif/diagnostique |
| Notes en séance | Nulles | Intensives | Minimales | Mots-clés | Progressives (coextensives) |
| Principal pain point | Charge admin | Friction templates | Vitesse d'accès | Recherche dans dossier | Comparaison temporelle |
| Collaboration | Minimale | Non adressée | Non adressée | Non adressée | **Très structurée (bidir.)** |
| Protocole urgence | Non adressé | Non adressé | Non adressé | Non adressé | **Explicite et absolu** |
| Logiciel | Outil admin | Outil clinique central | Contrainte | Outil de mémoire | Outil diagnostic + coordination |

### Conclusion inter-interviews (F-004 + F-005)

La conclusion formulée dans le matériau source est confirmée et peut être formalisée comme une hypothèse de haut niveau :

**H-CORPUS-001 — Le praticien cherche le contexte utile à la décision, pas un dossier complet**

*Description :* Quel que soit le métier, le praticien ne consulte pas le dossier entier avant d'agir. Il cherche le sous-ensemble d'information qui permet de prendre la décision clinique du moment. Ce sous-ensemble est role-specific dans sa nature mais universellement nécessaire dans son existence.

*Niveau de confiance :* ★★★★★ — confirmé sur 5 profils avec verbatim directs.

*Implication de design :* MedLink ne doit jamais présenter un dossier complet comme vue par défaut. La vue par défaut est toujours l'Anchor — le contexte minimal suffisant pour la décision clinique du moment.

---

## Références

- Interview brute F-005 — 2026-07-29 (verbatim disponible)
- F-001 à F-004 — corpus d'interviews MedLink
- Conclusion inter-interviews F-004 + F-005 — matériau source
- CC-000 Clinical Cognitive Architecture v1.0 — 2026-07-29
- UX-000 Product Experience Principles — 2026-07-29
- Endsley, M. (1995) — Situation Awareness — pertinent pour le chargement du contexte diagnostique
- Reason, J. (1990) — *Human Error* — pertinent pour le protocole d'urgence et la sécurité clinique
