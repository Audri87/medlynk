# F-003 — Clinical Interview Report
## Médecin — Consultation

**Type :** Clinical Interview Report
**Statut :** Draft — Analyse initiale
**Date :** 2026-07-29
**Analyste :** MedLink Research Program
**Framework :** F-XXX Clinical Interview Report v1.0

**Note méthodologique :** Matériau très synthétisé — quelques points clés sans verbatim. Les niveaux de confiance sont ajustés en conséquence. La spécialité du médecin n'est pas précisée (généraliste, spécialiste ?). Cette information est structurante et devra être complétée.

---

## 1. Executive Summary

Cette interview documente la pratique d'un médecin (spécialité non précisée). Le profil révèle une tension centrale : **le médecin a besoin d'information clinique rapide, mais l'ordinateur est perçu comme une contrainte pendant la consultation**.

Ce profil est distinct des deux précédents. Il partage avec F-001 (mkine) le fait que l'ordinateur perturbe la relation patient. Il partage avec F-002 (infirmière/sophrologue) le besoin d'un contexte clinique structuré — mais avec une contrainte de vitesse radicale : **moins de 30 secondes**.

Le finding le plus structurant : ce praticien définit implicitement le **contenu minimal suffisant** de l'Anchor médecin — traitements en cours, allergies, derniers événements importants. Ces trois éléments sont la réponse à la question "qu'est-ce que je dois savoir avant d'entrer en consultation ?"

Avec F-002, la règle des 30 secondes constitue la première **contrainte de performance mesurable** pour le design de MedLink.

---

## 2. Interview Context

| Élément | Valeur observée |
|---|---|
| Profession | Médecin |
| Spécialité | Non précisée — lacune critique |
| Mode d'exercice | Non précisé |
| Organisation | Non précisée |
| Ancienneté | Non précisée |
| Logiciel principal | Non précisé |
| Documentation | Minimale en consultation, complétée après |

**Lacune majeure :** La spécialité médicale est un déterminant fort du workflow cognitif. Un généraliste, un urgentiste et un interniste ont des profils d'accès à l'information radicalement différents. Cette information doit être collectée dans la prochaine interview.

---

## 3. Typical Day

### Reconstruction chronologique (partielle)

| Moment | Activité | Nature |
|---|---|---|
| Pré-consultation | Chargement du contexte patient | Cognitif — moins de 30 secondes |
| Pendant la consultation | Écoute et échange centré patient | Clinique — ordinateur minimisé |
| Pendant la consultation | Écriture minimale | Documentation réduite au strict nécessaire |
| Après la consultation | Complétion administrative | Batch — prescriptions, clôture |

**Observation :** La structure temporelle est la même que F-002 (pré → pendant → après) mais avec des intensités radicalement différentes. La phase pré-consultation est compressée au maximum (30 secondes). La phase pendant est quasi sans ordinateur. La phase après est consacrée à l'administratif.

---

## 4. Clinical Workflow

### Pré-consultation — La règle des 30 secondes

> [SYNTHÈSE RAPPORTÉE] Le médecin veut arriver avec un contexte en moins de 30 secondes. Il ne veut pas ouvrir plusieurs écrans.

**Observation :** Ce n'est pas une préférence — c'est une contrainte opérationnelle. En médecine de consultation, le temps entre deux patients est court. 30 secondes est la fenêtre disponible pour charger le contexte. Au-delà, le praticien entre en consultation sans préparation.

**Interprétation [INTERPRÉTATION] :** La règle des 30 secondes est la première **contrainte de performance quantifiée** identifiée dans le corpus. Elle définit le SLO du Workspace pré-consultation.

### Pendant la consultation — L'ordinateur comme contrainte

> [SYNTHÈSE RAPPORTÉE] Il écrit peu. Il préfère rester concentré sur le patient. L'ordinateur est une contrainte.

**Observation :** Ce pattern est identique à F-001 (mkine) dans son principe — le logiciel perturbe la relation clinique — mais différent dans son mécanisme. Le mkine n'en a pas besoin pendant la séance. Le médecin en aurait besoin mais choisit de ne pas y recourir pour préserver la relation.

**L'ordinateur est perçu comme une barrière à la relation patient.** Ce n'est pas un problème d'interface — c'est un problème de présence.

### Après la consultation — Batch administratif

- Complétion des informations administratives
- Rédaction des prescriptions
- Clôture rapide

**Observation :** Le "rapidement" est significatif. Il n'y a pas d'appétence pour un temps long de post-consultation. Le médecin veut clôturer vite pour passer au patient suivant.

### Besoin principal identifié

> [SYNTHÈSE RAPPORTÉE] Pouvoir retrouver immédiatement : les traitements, les allergies, les derniers événements importants.

**Observation :** Ces trois éléments définissent le **contenu minimal de l'Anchor médecin**. Ce n'est pas un résumé de la dernière séance (F-002) — c'est un tableau de bord clinique de sécurité.

---

## 5. Administrative Workflow

- Complétion administrative différée (après la consultation, non pendant)
- Prescriptions rédigées en post-consultation
- Clôture rapide

**Observation :** Le modèle batch est cohérent avec F-001 et F-002. Les trois praticiens traitent l'administratif hors de la relation patient.

---

## 6. Cognitive Analysis

### Objectifs cognitifs identifiés

1. **Charger le contexte patient** avant la consultation (< 30 secondes)
2. **Rester présent** pendant la consultation — minimiser les interactions logiciel
3. **Clôturer rapidement** après la consultation

### Informations recherchées pré-consultation

Triptyque de sécurité clinique :
1. **Traitements en cours** — risque d'interaction médicamenteuse
2. **Allergies** — risque d'événement indésirable
3. **Derniers événements importants** — contexte de la situation clinique actuelle

**Interprétation [INTERPRÉTATION] :** Ces trois éléments ne sont pas équivalents. Traitements et allergies sont des **données de sécurité** — leur absence peut causer un préjudice immédiat. Les derniers événements importants sont du **contexte clinique** — leur absence dégrade la qualité du raisonnement sans risque immédiat. Cette distinction devrait se refléter dans la hiérarchie visuelle de l'Anchor.

### Charge cognitive

- Minimisée par la contrainte de 30 secondes
- L'écriture pendant la consultation est réduite pour préserver la capacité attentionnelle
- Le post-consultation est court — pas de charge cognitive lourde acceptée

### La contrainte de performance comme donnée cognitive

La règle des 30 secondes n'est pas une préférence esthétique. Elle reflète le **budget cognitif disponible** entre deux consultations dans un contexte de flux élevé. Ce budget est réel et non extensible.

---

## 7. Collaboration Analysis

Aucune information disponible dans cette interview sur :
- Les échanges avec d'autres professionnels
- Les adressages
- Les transmissions d'information inter-professionnelles
- La relation avec les infirmières ou le personnel médical

**À explorer dans une prochaine interview.**

---

## 8. Pain Points

### Pain Point 1 — Contexte insuffisamment rapide

**Description :** Le médecin ne dispose pas d'un accès instantané au contexte clinique minimal nécessaire avant la consultation.

**Citation :** [SYNTHÈSE RAPPORTÉE] *"Veut arriver avec un contexte en moins de 30 secondes."*

**Impact :** Entrée en consultation sans préparation, ou temps pris sur la consultation elle-même pour consulter le dossier.

### Pain Point 2 — Multiplication des écrans

**Description :** L'accès à l'information nécessite d'ouvrir plusieurs écrans.

**Citation :** [SYNTHÈSE RAPPORTÉE] *"Ne veut pas ouvrir plusieurs écrans."*

**Impact :** Friction cognitive et temporelle. Rupture de la concentration.

### Pain Point 3 — L'ordinateur perturbe la relation patient

**Description :** La présence de l'ordinateur pendant la consultation est perçue comme une contrainte à la relation.

**Citation :** [SYNTHÈSE RAPPORTÉE] *"L'ordinateur est une contrainte."*

**Impact :** Arbitrage systématique entre documentation et relation patient. Le praticien choisit la relation — et documente moins.

---

## 9. Positive Practices

### Pratique 1 — Concentration sur le patient pendant la consultation

La décision de minimiser l'usage de l'ordinateur pendant la consultation est une protection délibérée de la relation patient — même au coût d'une documentation incomplète.

### Pratique 2 — Batch post-consultation

La complétion administrative différée (après la consultation) protège le temps de consultation de toute interruption administrative.

---

## 10. Opportunities for MedLink

### Opportunité 1 — Anchor médecin : triptyque de sécurité en un seul écran, en moins de 30 secondes

**Problème :** Pas d'accès rapide et agrégé aux informations critiques pré-consultation.
**Justification :** Triptyque explicite : traitements + allergies + derniers événements importants.
**Direction :** Un écran unique, chargeable en moins de 30 secondes, affichant uniquement ces trois éléments. Rien d'autre par défaut.

### Opportunité 2 — Mode consultation "écran effacé"

**Problème :** L'ordinateur est une contrainte pendant la consultation.
**Justification :** [SYNTHÈSE RAPPORTÉE] — ordinateur perçu comme barrière à la relation.
**Direction :** Un mode consultation minimal — seule l'information absolument nécessaire est visible. L'interface "disparaît" autant que possible. Ce mode s'active au début de la consultation et se désactive après.

### Opportunité 3 — Clôture rapide post-consultation

**Problème :** La clôture post-consultation doit être rapide.
**Justification :** [SYNTHÈSE RAPPORTÉE] — *"il clôture rapidement."*
**Direction :** La saisie post-consultation est une checklist courte, non un formulaire long. Les prescriptions sont le point central — le reste est minimal.

---

## 11. Candidate Hypotheses

### H-F003-01 — Il existe un seuil temporel psychologique pour le chargement du contexte clinique

**Description :** Le médecin a défini 30 secondes comme seuil acceptable pour accéder au contexte pré-consultation. Au-delà, la préparation est abandonnée ou empiète sur la consultation.

**Justification :** [SYNTHÈSE RAPPORTÉE] — contrainte explicite.

**Niveau de confiance :** Observation unique
**Questions ouvertes :** Ce seuil est-il universel ? Varie-t-il selon la spécialité, le volume de patients, l'organisation ? Peut-on le mesurer empiriquement ?

---

### H-F003-02 — La présence physique de l'ordinateur pendant la consultation perturbe la relation patient, indépendamment de son usage effectif

**Description :** Même si le médecin n'utilise pas l'ordinateur, sa présence crée une distraction ou une barrière perçue dans la relation. C'est un problème de présence physique autant que d'interface.

**Justification :** [SYNTHÈSE RAPPORTÉE] — *"L'ordinateur est une contrainte."*

**Niveau de confiance :** Observation unique — à confirmer
**Questions ouvertes :** Est-ce que les patients perçoivent également l'ordinateur comme une barrière ? Y a-t-il des dispositifs (tablette, écran orienté patient) qui réduisent cet effet ?

---

### H-F003-03 — L'information clinique minimale suffisante pré-consultation = traitements + allergies + derniers événements importants

**Description :** Ces trois éléments constituent la réponse à la question "qu'est-ce que je dois absolument savoir avant d'entrer en consultation ?" Ils définissent l'Anchor médecin.

**Justification :** [SYNTHÈSE RAPPORTÉE] — besoin principal explicitement formulé.

**Niveau de confiance :** Observation unique
**Questions ouvertes :** Cette triade varie-t-elle selon la spécialité ? Un urgentiste a-t-il les mêmes priorités qu'un généraliste ? Qu'est-ce qu'un "dernier événement important" — qui en décide la sélection ?

---

### H-F003-04 — L'Anchor est role-specific : son contenu varie selon le profil du praticien

**Description :** Le contenu de l'Anchor diffère selon le rôle clinique. F-002 (sophrologue) : état émotionnel + décisions + objectif. F-003 (médecin) : traitements + allergies + événements récents. L'Anchor n'est pas un résumé générique — c'est une vue configurée par rôle.

**Justification :** Contraste direct entre F-002 et F-003 — même concept (Anchor), contenu différent.

**Niveau de confiance :** Pattern émergent — 2 profils convergents sur le concept, divergents sur le contenu
**Questions ouvertes :** Le contenu de l'Anchor est-il configurable par le praticien ou définissable par rôle ? Existe-t-il un socle commun (date de naissance, motif de consultation) ?

---

## 12. Candidate Design Principles

### DP-F003-01 — Le contexte pré-consultation doit être accessible en un seul écran, en moins de 30 secondes

**Principe :** L'Anchor médecin est une vue unique, non paginée, chargeable en moins de 30 secondes depuis l'ouverture du dossier.

**Justification :** H-F003-01 — contrainte temporelle réelle et mesurable.

**Conséquences :** Performance technique non négociable. Le SLO du Workspace pré-consultation est p95 < 30 secondes (probablement bien moins). Aucune navigation, aucun scroll nécessaire pour les trois éléments critiques.

---

### DP-F003-02 — L'interface pendant la consultation doit s'effacer

**Principe :** Un mode consultation minimise l'interface au strict nécessaire. L'ordinateur doit "disparaître" visuellement autant que possible pendant la relation patient.

**Justification :** H-F003-02 — l'ordinateur est une contrainte à la relation.

**Conséquences :** Mode dédié (consultation active vs post-consultation). En mode consultation : seule l'information critique reste visible. La navigation est masquée.

---

### DP-F003-03 — Les données de sécurité (traitements, allergies) sont hiérarchiquement supérieures aux données de contexte (événements récents)

**Principe :** Dans l'Anchor, traitements et allergies sont affichés en priorité absolue — jamais cachés, jamais déprioritisés. Les événements récents sont du contexte clinique — importants mais de priorité secondaire.

**Justification :** H-F003-03 — distinction entre données de sécurité et données de contexte.

**Conséquences :** L'Anchor a une hiérarchie visuelle fixe : sécurité d'abord, contexte ensuite.

---

### DP-F003-04 — L'Anchor est configuré par rôle clinique, non générique

**Principe :** Le contenu de l'Anchor n'est pas identique pour tous les praticiens. Il est défini par le rôle (médecin, sophrologue, infirmière) et potentiellement ajustable par le praticien.

**Justification :** H-F003-04 — contraste F-002 / F-003 sur le contenu de l'Anchor.

**Conséquences :** Le Domain Model doit permettre des vues Anchor configurables. La configuration est par rôle, pas par utilisateur individuel (sauf personnalisation optionnelle).

---

## 13. Questions for Future Interviews

1. **Quelle est la spécialité du médecin interviewé ?** Cette information manque et est structurante pour l'interprétation.
2. **Comment le médecin gère-t-il les consultations pour des patients qu'il ne connaît pas ?** La règle des 30 secondes tient-elle pour les nouveaux patients ?
3. **Que se passe-t-il quand le contexte ne peut pas être chargé en 30 secondes ?** Le médecin entre-t-il quand même en consultation ? Improvise-t-il ?
4. **Qu'est-ce qu'un "dernier événement important" pour ce médecin ?** Qui décide qu'un événement est important ? Comment est-il identifié dans le dossier aujourd'hui ?
5. **Comment se passe la collaboration avec les infirmières, les spécialistes ?** Quelles informations sont transmises et comment ?
6. **Le médecin utilise-t-il un logiciel pendant la consultation, même peu ?** Si oui, pour quoi ?
7. **Comment gère-t-il les prescriptions ?** Dictée vocale, saisie manuelle, template ? Ce point est mentionné mais non développé.

---

## 14. Impact on MedLink Blueprint

| Domaine | Observation | Hypothèse | Proposition |
|---|---|---|---|
| **Workspaces** | Contexte pré-consultation en 30 secondes, un seul écran | H-F003-01 | Workspace pré-consultation = Anchor médecin — SLO p95 < 30s |
| **Workspaces** | Mode consultation "écran effacé" | H-F003-02 | Mode consultation distinct du mode navigation — interface minimale |
| **Domain Model** | L'Anchor varie selon le rôle | H-F003-04 | L'Anchor est une Projection configurable par rôle, pas une entité fixe |
| **Domain Model** | Traitements + allergies = données de sécurité | H-F003-03 | Ces données ont un statut prioritaire dans le Domain Model — non optionnelles |
| **Clinical Reasoning** | Peu d'écriture pendant la consultation | H-F003-02 | La saisie pendant la consultation doit être quasi-nulle ou voice-first |
| **Navigation** | Un seul écran, pas de navigation pré-consultation | DP-F003-01 | L'Anchor est une page, non un flux de navigation |
| **IA** | "Derniers événements importants" — sélection contextuelle | H-F003-03 | La sélection des événements importants est un candidat fort pour l'IA — filtrage contextuel |
| **Performance** | SLO pré-consultation < 30 secondes | H-F003-01 | Contrainte technique non négociable — à intégrer dans ADR-SA-027 |

---

## 15. Confidence Assessment

| Conclusion | Niveau | Justification |
|---|---|---|
| La règle des 30 secondes est une contrainte réelle | ★★★★ | Synthèse rapportée explicite — cohérente avec le contexte de consultation médicale |
| L'ordinateur est perçu comme une contrainte pendant la consultation | ★★★★ | Pattern cohérent avec F-001 — confirmé par deux profils distincts |
| Le triptyque traitements/allergies/événements est l'Anchor médecin | ★★★★ | Réponse directe à une question sur le besoin principal |
| L'Anchor est role-specific | ★★★ | Pattern émergent sur 2 interviews — à confirmer |
| Le mode consultation "effacé" est un besoin universel | ★★★ | Deux profils convergent (F-001, F-003) — F-002 diverge |

---

## 16. CC-000 Cross-Reference

| Hypothèse CC-000 | Statut après cette interview | Évidence | Recommandation |
|---|---|---|---|
| **H-01** Pertinence contextuelle | ✅✅ Fortement confirmée | Triptyque explicite = définition précise de la pertinence pré-consultation | Maintenir. Ajouter : la pertinence doit être accessible en < 30 secondes |
| **H-02** Discontinuité contextuelle | ✅ Confirmée | "Pas d'écrans multiples" = refus de la discontinuité de navigation | Maintenir |
| **H-03** Cognition distribuée | ⚪ Non adressée | Aucun élément sur la collaboration | À explorer |
| **H-04** Expertise et fluidité | ✅ Confirmée | Écriture minimale pendant la consultation pour rester concentré — même logique que F-001 | Maintenir |
| **H-05** Ancrage par transmission | ✅ Confirmée | Les "derniers événements importants" = ancrage contextuel. L'Anchor médecin est role-specific | Révision H-F003-04 à intégrer dans CC-000 : l'Anchor est role-specific |
| **H-06** Attribution et confiance | ⚪ Non adressée | Pas d'information | À explorer |
| **H-07** Charge cognitive et progressivité | ✅✅ Fortement confirmée | 30 secondes = contrainte de charge cognitive maximale acceptée pré-consultation | Maintenir. Ajouter : la progressivité a une contrainte temporelle mesurable |

### Mise à jour CC-000 recommandée

**H-01 — Précision à intégrer :**
> La pertinence contextuelle a une contrainte temporelle : elle doit être accessible en moins de 30 secondes. Une information pertinente accessible en 5 minutes n't est pas pertinente — elle est inaccessible dans le contexte de flux réel.

**H-05 — Confirmation de la révision initiée en F-002 :**
> L'Anchor est role-specific. Son contenu varie selon le profil clinique du praticien. Un socle commun existe probablement (identité patient, date de naissance, motif) — le contenu clinique est configuré par rôle.

---

## Comparaison inter-interviews

| Dimension | F-001 Mkine | F-002 Infirmière/Sophrologue | F-003 Médecin |
|---|---|---|---|
| Besoin d'info pré-consultation | Nul (mémoire) | Modéré (dossier ouvert) | Fort (30 secondes) |
| Usage ordinateur pendant le soin | Nul | Intensif (notes temps réel) | Minimal (contrainte) |
| Type d'Anchor | Aucun (mémoire) | Dernière séance | Traitements + allergies + événements |
| Batch post-consultation | Admin soir | Admin immédiat | Admin immédiat |
| Principal pain point | Charge admin | Friction documentaire | Vitesse d'accès au contexte |
| Logiciel = | Outil admin | Outil clinique central | Contrainte relationnelle |

**Conclusion inter-interviews :** Trois profils, trois rapports au logiciel radicalement différents. Le seul invariant commun est le **batch post-consultation** — tous trois traitent l'administratif hors de la relation patient. C'est le seul point de convergence comportementale sur les trois interviews.

---

## Références

- Interview brute F-003 — 2026-07-29 (synthèse très condensée — verbatim absent)
- F-001 — Masseur-kinésithérapeute libéral
- F-002 — Infirmière / Sophrologue
- CC-000 Clinical Cognitive Architecture v1.0 — 2026-07-29
- ADR-SA-027 — Performance & Scalability (SLO — à mettre à jour avec contrainte 30 secondes)
- Endsley, M. (1995) — Situation Awareness — pertinent pour le chargement de contexte pré-consultation
- Norman, D. (1988) — *The Design of Everyday Things* — le logiciel comme contrainte vs outil
