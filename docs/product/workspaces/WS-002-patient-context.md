# WS-002 — Patient Context Blueprint

| Field | Value |
|---|---|
| ID | WS-002 |
| Version | 0.4 |
| Status | **Prototype — Pending User Test** |
| Lifecycle | ☐ Discovery · ☑ Blueprint · ☑ Prototype · ☐ User Test · ☐ Production |
| Date | 2026-08-04 |
| Sprint | Sprint 1 |
| Depends on | PAT-P-001, PAT-P-002 · PP-005, PP-006, PP-008 |
| Display Rules | DR-001, DR-002, DR-003, DR-004 |
| Prototype | [WS-002-prototype-v0.1.html](WS-002-prototype-v0.1.html) |

---

## 1. Product Question

**Q-002 — Pourquoi ce patient est-il devant moi aujourd'hui ?**

Cette question contient quatre sous-questions imbriquées, qui structurent l'Information Architecture :

1. Qui est ce patient et pourquoi est-il là maintenant ?
2. Où en étions-nous lors de notre dernière interaction ?
3. Qu'avions-nous prévu ?
4. Y a-t-il quelque chose de l'historique qui compte aujourd'hui ?

---

## 2. Evidence

> Ce Blueprint distingue explicitement trois niveaux épistémiques.
> Aucun élément n'est promu d'un niveau à l'autre sans justification.

### Légende

| Symbole | Niveau | Définition |
|---|---|---|
| ✓ | Observation | Directement issu du corpus verbatim |
| ≈ | Pattern | Fortement suggéré — convergent mais non universel |
| ? | Hypothèse produit | Décision de conception à valider empiriquement |

---

### ✓ Observations directes

| ID | Observation | Corpus |
|---|---|---|
| OBS-P-001 | Les praticiens consultent la dernière interaction clinique avant de recevoir le patient | ACT-F004-004, ACT-F004-005, ACT-F008-008, ACT-F006-008 |
| OBS-P-002 | L'échographiste consulte l'ordonnance en premier — pas la dernière consultation | ACT-F005-005, ACT-F005-006 |
| OBS-P-003 | Les praticiens recherchent les intentions ou plans notés en fin de séance précédente | ACT-F004-007, ACT-F002-015 |
| OBS-P-004 | La profondeur de préparation augmente avec le temps écoulé depuis la dernière consultation | ACT-F004-003 |
| OBS-P-005 | Certains praticiens ne documentent pas en fin de séance — la mémoire remplace le dossier | ACT-F001-015, ACT-F001-019 |

---

### ≈ Patterns

| ID | Pattern | Corpus | Profils |
|---|---|---|---|
| PAT-P-001 | La dernière consultation est le point d'entrée privilégié pour les praticiens en suivi longitudinal | ACT-F004-004, ACT-F008-008, ACT-F006-008, ACT-F002-012 | 4–5 / 9 |
| PAT-P-002 | La préparation est proportionnelle à la distance temporelle et à la familiarité avec le patient | ACT-F004-003 | Indirect |
| PAT-P-003 | Pour les profils longitudinaux, le récent précède le complet dans la séquence de lecture | Multi-profils | Longitudinaux uniquement |

---

### ? Hypothèses produit

| ID | Hypothèse | Niveau de risque |
|---|---|---|
| HYP-P-001 | Afficher le contexte récent avant l'historique réduit le temps de préparation | Medium |
| HYP-P-002 | Les intentions inachevées peuvent être automatiquement détectées et surfacées | High — dépend de la qualité de documentation |
| HYP-P-003 | Un résumé de continuité réduit la charge cognitive de reconstruction | Medium — non mesurable sans test |
| HYP-P-004 | Un temps de préparation cible de 30 secondes est atteignable | High — issu d'un seul ACT synthétique non verbatim (ACT-F003-001) |

---

## 3. Product Principles

> Les Product Principles sont des décisions de conception, pas des découvertes.
> Ils dérivent de Patterns et d'Observations. Ils peuvent avoir des exceptions.
> Ces exceptions sont les Display Rules.

| Principe | Énoncé | Source | Statut |
|---|---|---|---|
| PP-005 | Surface the relevant recent interaction first | PAT-P-001 | À valider |
| PP-006 | Historical depth follows context gap | PAT-P-002, PAT-P-003 | À valider |
| PP-008 | Collapse historical detail by default (Display Rules specify exceptions) | PAT-P-003 | À valider |

**PP-007 supprimé de ce Blueprint** — "Expose unfinished intentions" n'a pas de support corpus direct. Reclassé en Open Question OQ-P-003. Voir [PRODUCT-PRINCIPLES.md](../PRODUCT-PRINCIPLES.md) pour le détail.

---

## 4. Display Rules

> Une Display Rule est une adaptation spécialisée d'un Product Principle pour un profil clinique.
> Même Principle. Présentations différentes selon le profil.

| DR | Profil | Point d'entrée primaire | Secondaire | Historique |
|---|---|---|---|---|
| DR-001 | Suivi longitudinal (Psychologue, Infirmière libérale, Kinésithérapeute) | Dernière séance — résumé + plans notés | Intentions documentées (si présentes) | Collapsed |
| DR-002 | Suivi grossesse (Sage-femme) | Terme + stade de grossesse + dernière consultation | Éléments de suivi (poids, TA, mouvements) | Collapsed |
| DR-003 | Acte sur demande (Échographiste) | Ordonnance — motif + prescripteur | Comptes rendus précédents | **NON collapsed** — exception PP-008 |
| DR-004 | Coordination (Infirmière coordinatrice) | Statut des intervenants actifs + dernière note | Transmissions entre praticiens | Collapsed |

> Voir [DISPLAY-RULEBOOK.md](../DISPLAY-RULEBOOK.md) pour la spécification complète et les lifecycles.

---

## 5. Cognitive Transition

```
PERDU
(le patient est devant moi — je n'ai pas de contexte)
    ↓
Reprise de contexte patient
(WS-002 — réponse à Q-002)
    ↓
ORIENTÉ
(je sais pourquoi ce patient est là,
où nous en étions, ce que nous avions prévu)
```

WS-002 ne décide rien. Il réduit le coût de cette transition.

---

## 6. User Outcome

À la fermeture de WS-002, le praticien doit pouvoir dire :

> "Je sais pourquoi ce patient est là, où nous en étions, et ce que je dois aborder."

---

## 7. Information Architecture

Quatre blocs ordonnés par Q-002. Chaque bloc répond à une sous-question.

### Bloc 1 — Présence

**Sous-question :** Qui est ce patient et pourquoi est-il là aujourd'hui ?

Contenu :
- Identité — nom, âge, type de visite (nouveau / suivi / urgence)
- Motif de la consultation du jour (si connu)
- Indicateur de familiarité (première consultation ? retour après longue absence ?)

Comportement : toujours visible. Jamais collapsed.

---

### Bloc 2 — Continuité

**Sous-question :** Où en étions-nous ?

Contenu : Display Rule-dependent (DR-001 à DR-004)

| Profil | Contenu du Bloc 2 |
|---|---|
| DR-001 (longitudinal) | Résumé de la dernière séance |
| DR-002 (grossesse) | Terme + stade + dernière consultation |
| DR-003 (acte) | Ordonnance — motif + prescripteur |
| DR-004 (coordination) | Statut intervenants + dernière note |

Comportement : toujours visible. Jamais collapsed.

---

### Bloc 3 — Intention

**Sous-question :** Qu'avions-nous prévu ?

Contenu : Plans ou intentions notés en fin de dernière séance (si documentés)

Comportement : visible uniquement si des intentions sont documentées (OBS-P-005 : certains praticiens ne documentent pas — le bloc est absent, pas vide).

> **Note de risque (HYP-P-002) :** ce bloc présuppose que les intentions sont écrites dans le dossier. Pour les praticiens qui ne documentent pas (ACT-F001-019), ce bloc est systématiquement absent. Il ne doit pas signifier "rien de prévu" mais "aucune trace écrite."

---

### Bloc 4 — Historique

**Sous-question :** Y a-t-il quelque chose de l'historique qui compte aujourd'hui ?

Contenu : Display Rule-dependent

| Profil | Comportement Historique |
|---|---|
| DR-001 (longitudinal) | Collapsed par défaut — une interaction révèle les séances précédentes |
| DR-002 (grossesse) | Collapsed par défaut — éléments de suivi longitudinaux disponibles |
| DR-003 (acte) | **Déployé par défaut** — comptes rendus et images précédents sont le contexte primaire |
| DR-004 (coordination) | Collapsed par défaut |

---

## 8. Scope Limitations

> Section obligatoire dans tout Blueprint.
> La transparence sur les limites évite les généralisations abusives.

**Ce Blueprint est valide pour :**
- Praticiens ambulatoires et communautaires (libéral, ville)
- Relations de soin longitudinales (suivi régulier)
- Praticien lisant ses propres notes

**Ce Blueprint n'a PAS été validé pour :**
- Médecine intra-hospitalière (aucun profil corpus)
- Médecine d'urgence (aucun profil corpus)
- Première consultation — nouveau patient (aucun état initial défini)
- Reprise de contexte inter-praticien (handoff, remplacement, référé)
- Soins partagés multi-spécialistes simultanés
- Praticiens lisant les notes d'un collègue

---

## 9. Explicit Non-Goals

WS-002 n'est pas :
- un visualisateur de dossier patient complet ;
- un remplaçant du dossier clinique ;
- un outil d'aide à la décision ;
- un résumé IA du patient.

Son objectif est uniquement la reprise de contexte pré-consultation.

---

## 10. Success Metrics

| Métrique | Nature | Baseline requis |
|---|---|---|
| Temps pour atteindre l'état ORIENTÉ | Comportemental | Oui |
| Nombre d'interactions avec le dossier avant de se sentir prêt | Comportemental | Oui |
| **Context Confidence** — "Avant d'entrer dans cette consultation, à quel point avez-vous l'impression de comprendre où en est ce patient ?" (échelle 1–5) | Qualitatif — déclaratif | Test utilisateur pré-consultation |
| Taux d'expansion du Bloc 4 (falsification PP-008) | Comportemental — prototype observable | Non |
| Praticiens ayant ouvert le dossier complet après WS-002 | Indicateur de défaillance | Non |

> **Context Confidence** est la métrique principale de WS-002. C'est exactement ce que ce Workspace cherche à améliorer. Baseline à mesurer avec les outils actuels avant tout test du prototype.

---

## 11. Open Questions

| # | Question | Impact | Ancre | Status |
|---|---|---|---|---|
| OQ-P-001 | Comment MedLink définit-il "dernière interaction clinique" quand plusieurs praticiens interviennent sur le même patient ? | Architecture — Read Model | HYP-P-002 | Open |
| OQ-P-002 | Quelle est la durée réelle de préparation avec les outils actuels ? | Baseline — HYP-P-004 | ACT-F003-001 (synthétique) | Experiment Planned |
| OQ-P-003 | Les praticiens souhaitent-ils que les intentions inachevées soient surfacées automatiquement, ou préfèrent-ils les chercher eux-mêmes ? | PP-007 future — comportement du Bloc 3 | OBS-P-003, OBS-P-005 | Open |
| OQ-P-004 | Comment WS-002 se comporte-t-il lors d'une première consultation (aucune interaction précédente) ? | Edge case non couvert | Scope limitation | Open |
| OQ-P-005 | La Display Rule change-t-elle au sein du même praticien selon le type de patient (nouveau vs suivi long) ? | Segmentation DR | PAT-P-002 | Open |

> Statuts possibles : Open · Experiment Planned · Validated · Rejected

---

## 12. Evidence Quality Summary

| Élément | Niveau | Ancre corpus |
|---|---|---|
| OBS-P-001 | ✓ Direct | ACT-F004-004, F004-005, F008-008, F006-008 |
| OBS-P-002 | ✓ Direct | ACT-F005-005, F005-006 |
| OBS-P-003 | ✓ Direct | ACT-F004-007, F002-015 |
| OBS-P-004 | ✓ Direct | ACT-F004-003 |
| OBS-P-005 | ✓ Direct | ACT-F001-015, F001-019 |
| PAT-P-001 | ≈ Pattern | 4/9 profils — longitudinal uniquement |
| PAT-P-002 | ≈ Pattern | ACT-F004-003 + inference convergente |
| PAT-P-003 | ≈ Pattern | Profils longitudinaux — non testé acte/demande |
| PP-005 | 💡 Décision produit | Dérivée de PAT-P-001 + OBS-P-002 |
| PP-006 | 💡 Décision produit | Dérivée de PAT-P-002, PAT-P-003 |
| PP-008 | 💡 Décision produit | Dérivée de PAT-P-003, exceptions via Display Rules |
| DR-001 à DR-004 | 💡 Adaptation produit | Dérivées de OBS-P-001, OBS-P-002 par profil |
| HYP-P-001 à P-004 | ? Hypothèse | À valider — non testées |

---

## 13. Fiche d'implémentation (Phase 2 — Freeze V1, 2026-10-05)

> Ce Blueprint date du 2026-08-04 — **avant** les 6 sessions de test praticien du round M2
> (2026-08-17 → 2026-09-15, voir [M2-JOURNAL-observations](../M2-JOURNAL-observations.md)). §2
> (Evidence), §4 (Display Rules) et §12 (Evidence Quality Summary) ci-dessus n'ont **jamais été mis à
> jour** pour intégrer ce que le terrain a depuis appris. Cette fiche documente l'implémentation
> réelle (`WS-002-WS-003-parcours-v8.html`) telle qu'elle est aujourd'hui — pas une relecture du
> Blueprint d'origine.

**Objectif.** Inchangé — Q-002, §1.

**Entrée.** Depuis "Patients du jour" (Mon Espace) uniquement — `openPatient()`. Depuis la liste
"Patients" (annuaire général), l'entrée a été délibérément redirigée vers le **Care Record**, pas
WS-002 (décision prise pendant cette session : annuaire général ≠ patient vu aujourd'hui). Aucune autre
entrée n'existe.

**Sortie.** → WS-003 ("Démarrer la consultation", réel) · → Care Record ("Consulter le dossier
complet", réel) · → Mon Espace ("← Retour", "Annuler" avec note, réel) · "Décaler" reste décoratif
(alerte de prototype, aucun calendrier connecté).

**Actions (réelles vs décoratives).** Réelles : Démarrer la consultation, Consulter le dossier complet,
Annuler (ouvre un encart de motif), Retour à Mon espace. Décorative : Décaler le rendez-vous.

**Données nécessaires — écart avec le Blueprint d'origine.** Le Blueprint prévoit 4 blocs
(Présence/Continuité/Intention/Historique, §7) dont le contenu varie **par Display Rule (DR-001 à
DR-004, par profil)**. **Le prototype n'implémente aucune des 4 Display Rules** — un seul format fixe
est testé, quelle que soit la profession du praticien connecté (toujours Dr Durand / Michel Rousseau).
Ajout non prévu au Blueprint : l'encart "Dernière note", introduit en session, absent des 4 blocs
d'origine.

**Règles — ce qui est confirmé depuis par le terrain, au-delà du Blueprint d'origine.**
- PP-005 (surface recent first) — cohérent avec "2 · Continuité", mais désormais **beaucoup mieux
  corroboré** que ce que §12 indique : confirmé sur 5+ sessions (OBS-M2-006 à 012), pas seulement les
  4-5 profils du corpus `CWRM-001` d'origine.
- **"Lecture A" (quitter la page vers le Care Record complet)** — comportement entièrement absent du
  Blueprint §4/§7 (qui ne parle que de Display Rules par profil), mais **gelé dans le code depuis le
  2026-09-08** suite à 2 confirmations nettes (médecin, biologiste) contre 1 divergence non lissée
  (kiné, accordéon — `NON CORROBORÉ`, voir OBS-M2-010). Ce n'est pas une Display Rule DR-00N du
  Blueprint — c'est un comportement de navigation transversal, découvert en test, jamais intégré au
  document d'origine.
- **Filtrage du Care Record par catégorie** (ancrage + surlignage, OBS-M2-012, gelé le 2026-09-08) —
  également absent du Blueprint, également une réponse directe à un problème observé en session, pas
  anticipée par le document d'origine.
- DR-001 à DR-004 (par profil : longitudinal/grossesse/acte/coordination) — **non implémentées, jamais
  testées telles quelles**. Les 6 sessions M2 ont testé des professions différentes de celles citées en
  exemple dans ces DR (médecin spécialiste, thérapeute, kiné, biologiste, généraliste, infirmière PSAD
  — aucune sage-femme ni échographiste ni infirmière coordinatrice). CPP-001 (Cross-Practitioner
  Principle) suggère que la variation est plutôt *par contenu* que par Display Rule structurelle
  (OBS-M2-007/009) — une lecture différente de celle du Blueprint d'origine, jamais réconciliée avec
  lui.

**États.** Patient connu avec historique riche — seul état testé (toujours Michel Rousseau). **Première
consultation / nouveau patient (OQ-P-004, toujours `Open`)** — aucun état construit, ni dans le
Blueprint ni dans le prototype. Patient sans intentions documentées (Bloc 3 absent, §7) — non
implémenté explicitement dans le prototype actuel (le bloc Intention est toujours présent pour Michel
Rousseau).

**Erreurs / cas limites non couverts.**
- Reprise de contexte inter-praticien (hors scope Blueprint §8) — non testée, non implémentée.
- Première consultation (OQ-P-004) — non testée, non implémentée.
- Divergence Lecture A/accordéon non résolue pour les professions paramédicales au-delà du kiné
  (OBS-M2-010, `NON CORROBORÉ`, pas encore un 3ᵉ/4ᵉ praticien).

**UX.** Renvoi au prototype v8 — avec l'avertissement inverse de WS-001 : ici, le prototype est **plus
riche et plus validé** que le Blueprint §2/§4/§12 ne le reflète. Avant Phase 3/4, les sections Evidence
et Display Rules de ce document devraient être réécrites à partir du corpus M2 réel, pas conservées
telles quelles depuis le 2026-08-04.

### Requalification ADR-0025 (2026-10-06)

> Lecture [ADR-0025](../../adr/ADR-0025-innovations-produit-non-observees.md). Ici, le prototype est
> **en avance** sur le Blueprint : Lecture A et le filtrage par catégorie du Care Record ont été
> testés en session M2 (OBS-M2-010, OBS-M2-012) — ce ne sont pas des hypothèses, ce sont des
> décisions `→` à reporter dans §2/§4 lors de leur réécriture. Seuls les éléments jamais confrontés
> au terrain reçoivent une fiche HYP. "Majorité" = plus de la moitié des praticiens du round.

| HYP | Élément | Origine | Problème visé |
|---|---|---|---|
| 001 | Encart "Dernière note" | Founder-Driven | PP-005 (*surface recent first*), OBS-M2-006 à 012 |
| 002 | Format unique sans Display Rules par profil | Founder-Driven (de fait) — lecture CPP-001 | OBS-M2-007, OBS-M2-009 (`≈`) |
| 003 | "Annuler" (avec motif) et "Décaler" dans WS-002 | Founder-Driven | Aucun ancrage — à documenter |
| 004 | Annuaire "Patients" → Care Record, pas WS-002 | Founder-Driven (décision de session) | ADR-0023 §7 R1 |

```
HYP-002-001 — Encart "Dernière note"
Hypothèse:          La dernière note du praticien est le moyen le plus rapide de reprendre le fil
Risque si faux:     Doublon avec le bloc "Continuité" — deux endroits pour la même information récente
Test:               "Qu'avez-vous regardé pour vous rappeler où vous en étiez avec ce patient ?"
Critère d'abandon:  La majorité utilise le bloc Continuité et ignore l'encart → encart fusionné dans
                    Continuité
Statut:             ? ⚠ — À tester

HYP-002-002 — Format unique (variation par contenu, pas par Display Rule)
Hypothèse:          Un seul format dont le contenu varie suffit pour toutes les professions (CPP-001),
                    sans les Display Rules DR-001 à DR-004 du Blueprint
Risque si faux:     Une profession ne trouve pas son information clé (grossesse, série d'actes…)
Test:               Recruter au moins une profession citée par DR-001 à DR-004 et absente des 6 sessions
                    (sage-femme, échographiste, infirmière coordinatrice) : trouve-t-elle son
                    information clé en moins de 30 s ?
Critère d'abandon:  Une profession échoue → la Display Rule correspondante est réintroduite pour cette
                    profession (pas pour toutes)
Statut:             ? ⚠ — À tester (DR-001 à DR-004 restent dans le Blueprint jusqu'au résultat)

HYP-002-003 — Annuler / Décaler depuis WS-002
Hypothèse:          Le praticien gère lui-même l'annulation d'un rendez-vous au moment où il regarde le
                    patient, et veut en garder le motif
Risque si faux:     WS-002 glisse vers la gestion d'agenda — ADR-0023 lui donne "comprendre", pas
                    "planifier"
Test:               "Quand un rendez-vous est annulé, qui s'en occupe, et où ?"
Critère d'abandon:  Annulation gérée par un secrétariat ou un agenda externe pour la majorité → actions
                    retirées de WS-002
Statut:             ? ⚠ — À tester

HYP-002-004 — Annuaire → Care Record
Hypothèse:          Un patient cherché dans l'annuaire n'est pas un patient vu aujourd'hui : on veut
                    son dossier, pas sa préparation
Risque si faux:     Le praticien cherche un patient pour préparer une visite non planifiée et arrive
                    sur un dossier complet trop dense
Test:               Tâche : "Retrouvez Michel Rousseau depuis la recherche" — l'écran d'arrivée
                    correspond-il à ce qu'il attendait ?
Critère d'abandon:  La majorité attendait la synthèse → l'annuaire ouvre WS-002 (toujours sans démarrer
                    de consultation, ADR-0023 §7 R1)
Statut:             ? ⚠ — À tester
```

**Manque, pas hypothèse** : état "première consultation / nouveau patient" (OQ-P-004).

---

## 14. Évolution

| Version | Date | Nature |
|---|---|---|
| 0.1 | 2026-08-04 | Blueprint initial post-revue critique — Sprint 1.1 consolidation |
| 0.1 | 2026-08-04 | Prototype v0.1 créé — 4 profils Display Rule |
| 0.2 | 2026-08-04 | Suppression Invariants · PR→PP · Context Confidence · OQ Status |
| 0.3 | 2026-10-05 | §13 ajoutée — Fiche d'implémentation (Phase 2, freeze V1). Constat : §2/§4/§12 datent d'avant le round M2 (6 sessions) et n'ont jamais été mis à jour ; Lecture A et le filtrage par catégorie du Care Record (gelés en code depuis le 2026-09-08) sont absents du Blueprint d'origine ; DR-001 à DR-004 ne sont pas implémentées et n'ont pas été testées telles que définies |
| 0.4 | 2026-10-06 | Requalification [ADR-0025](../../adr/ADR-0025-innovations-produit-non-observees.md) (§13) : Lecture A et filtrage par catégorie reconnus comme décisions testées (`→`), pas hypothèses. 4 fiches HYP-002-001 à 004 (Dernière note, format unique vs DR-001 à 004, Annuler/Décaler, annuaire → Care Record). HYP-002-002 exige de recruter une profession citée par les DR et absente des 6 sessions. |
