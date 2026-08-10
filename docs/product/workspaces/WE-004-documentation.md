# WE-004 — Workspace Evidence — Documentation

| Field | Value |
|---|---|
| ID | WE-004 |
| Version | 0.4 |
| Status | Discovery — Corpus Partial. Workspace parent : frontière **RESOLVED** (2026-08-04, voir [WBD-004](WBD-004-consultation-vs-documentation.md) v2.0) |
| Date | 2026-08-04 |
| Nature | Artefact GOV-000 §5 (Discovery → Product) — ACT → OBS → PAT → **Tension** → WE |
| Corpus | ACT-F001 à ACT-F009 (corpus existant, aucun nouvel entretien) |
| Product Question visée | Retirée — le scope WS-003/WS-004 est tranché par [WBD-004](WBD-004-consultation-vs-documentation.md) v2.0, verdict RESOLVED (WS-004 = préservation/persistance, pas "documentation") |

> Cette extraction ne part pas de "éditeur de texte" mais de 8 questions comportementales posées par
> le porteur produit. Aucune de ces questions n'a fait l'objet d'un entretien dédié — c'est une
> relecture ciblée du corpus F001–F009 existant. Conséquence : les réponses sont réelles et ancrées,
> mais partielles.
>
> Convention de marqueurs : [GOV-000](../../process/GOV-000-medlink-governance-v1.0.md) v1.1
> (✓ confirmé · ≈ pattern, confiance explicite · ? gap/inconnue · ⚡ tension · → décision · ⚠ à
> valider). Chaque Pattern porte désormais sa confiance (HIGH/MEDIUM/LOW) — calculée, jamais laissée
> au lecteur.

---

## Executive Summary

**8 questions posées, 8 réponses — en un coup d'œil :**

| # | Question | Réponse en une phrase | Confiance |
|---|---|---|---|
| Q1 | Quand commence-t-il à écrire ? | Pendant, seulement si risque de perdre l'information — sinon après | ≈ MEDIUM (4/9) |
| Q2 | Que retarde-t-il volontairement ? | La rédaction formelle, systématiquement, jusqu'au départ du patient | ≈ HIGH (7/9) |
| Q3 | Que mémorise-t-il sans noter ? | Le contenu de l'échange, quand la relation est déjà établie | ≈ MEDIUM (4/9) |
| Q4 | Que note-t-il immédiatement ? | Ce qui risque d'être oublié avant la fin — renvoie à Q1 | ≈ MEDIUM (4/9) |
| Q5 | Que complète-t-il après ? | Un aide-mémoire pour la prochaine fois, pas un compte-rendu exhaustif | ≈ LOW (2/9) |
| Q6 | Qu'oublie-t-il ? | Inconnu — un seul indice indirect | ? GAP quasi complet |
| Q7 | Qu'est-ce qui déclenche la rédaction ? | La fin de la consultation, par défaut | ≈ HIGH (7/9) |
| Q8 | Comment sait-il qu'il a terminé ? | Inconnu au niveau de la note — seulement au niveau de la journée | ? GAP complet |

**Les 2 résultats solides (HIGH) :** PAT-D-002 (rédaction toujours hors présence patient) et PAT-D-005
(fin de consultation = déclencheur par défaut). Déjà reversés dans WS-003 (PP-013/014 passées à
`evidence: ≈`, voir PDR-004 DD-402).

**Les 2 trous nets :** Q6 (oubli) et Q8 (critère de fin d'une note) — aucun Pattern construit dessus,
volontairement laissés en Gap.

**Les 2 tensions identifiées (nouveau — voir §Tensions) :** des comportements directement opposés dans
le corpus, sur le même axe, qui ne peuvent pas être résolus par un seul Product Principle universel.
TEN-D-001 (volume de documentation — jamais vs beaucoup) et TEN-D-002 (présence vs prise de notes en
temps réel, y compris entre deux profils relationnels similaires).

**Ce que ça bloque :** DD-401 (PDR-004) — le scope même de WS-004 reste à trancher avant d'aller plus
loin. Cette WE ne suffit pas à franchir Gate 1 pour Q6/Q8.

---

## Q1 — Quand le praticien commence-t-il à écrire ?

**Evidence Summary :** L'écriture pendant la consultation reste l'exception — déclenchée par le risque
de perdre une information, pas par une habitude. **PAT-D-001 — ≈ MEDIUM (4/9 profils).**

**OBS**

| ID | Profil | Observation | Ancre |
|---|---|---|---|
| OBS-D-001 | F002 | Prend des notes en temps réel, "au fil de l'échange" | ACT-F002-016 |
| OBS-D-002 | F003 | Écrit peu pendant la consultation | ACT-F003-006 |
| OBS-D-003 | F004 | Note quelques mots-clés PENDANT la séance — uniquement pour ne pas perdre d'éléments importants | ACT-F004-009 |
| OBS-D-004 | F005 | Pour les examens longs (Doppler), commence la rédaction du compte rendu PENDANT l'examen | ACT-F005-012 |
| OBS-D-005 | F006 | Prend des notes (constantes, observations) pendant la consultation de suivi | ACT-F006-014 |
| OBS-D-006 | F007 | Écrit en général à la FIN de la consultation, sauf si une information importante émerge en cours (retour immédiat à l'ordinateur) | ACT-F007-015, 016 |
| OBS-D-007 | F008 | Prend des notes minimales pendant la visite, uniquement si nécessaire | ACT-F008-013 |
| OBS-D-008 | F009 | Remplit une grille de suivi structurée en temps réel (patient diabétique sous pompe) — vs points de repère seulement pour patient connu (Parkinson) | ACT-F009-025 vs 017 |
| OBS-D-009 | F001 | Ne prend AUCUNE note clinique, jamais | ACT-F001-019 |

**PAT-D-001 — ≈ MEDIUM — Confidence 4/9 (44%)**
L'écriture pendant la consultation est déclenchée par le risque perçu de perdre une information, pas
par une habitude de documentation. Verbatims quasi identiques : *"pour ne pas perdre les éléments
importants"* (F004) · *"une information importante… je retourne… la noter"* (F007) · *"je note
uniquement ce qui est important"* (F008) · *"si je ne note pas, j'oublie"* (F009).

---

## Q2 — Que retarde-t-il volontairement ?

**Evidence Summary :** La rédaction formelle est toujours reportée hors présence du patient — le
Pattern le plus solide de cette extraction avec Q7. **PAT-D-002 — ≈ HIGH (7/9 profils).**

**OBS**

| ID | Profil | Observation | Ancre |
|---|---|---|---|
| OBS-D-010 | F002 | Finalise les notes après la séance, pas en clôture immédiate | ACT-F002-019 |
| OBS-D-011 | F004 | Complète les notes après la séance "tant que c'est encore frais" — délai court mais volontaire, pas immédiat | ACT-F004-010 |
| OBS-D-012 | F007 | Reporte le traitement des documents reçus si pas de temps disponible, jusqu'à la pause déjeuner ou la fin de journée | ACT-F007-018, 019 |
| OBS-D-013 | F009 | Rédige TOUJOURS les comptes rendus au bureau, jamais devant le patient ; reporte explicitement les tâches non terminées au lendemain | ACT-F009-032, 033 |

**PAT-D-002 — ≈ HIGH — Confidence 7/9 (78%)**
La rédaction formelle (compte rendu, dossier complet) est systématiquement reportée hors de la présence
du patient, y compris chez les profils qui notent pendant la séance. 7 profils convergents : F002, F004,
F005, F006, F007, F008, F009.

---

## Q3 — Que mémorise-t-il (sans noter) ?

**Evidence Summary :** La mémorisation remplace la documentation quand la relation praticien-patient est
déjà établie. **PAT-D-003 — ≈ MEDIUM (4/9 profils).**

**OBS**

| ID | Profil | Observation | Ancre |
|---|---|---|---|
| OBS-D-014 | F001 | S'appuie explicitement sur sa mémoire des séances précédentes au lieu de notes — *"j'ai une bonne mémoire, donc je me souviens"* | ACT-F001-015 |
| OBS-D-015 | F004 | Reste présente avec le patient pendant la séance — choix explicite de ne pas noter le contenu en temps réel, *"je préfère être présente avec lui"* | ACT-F004-008 |
| OBS-D-016 | F008 | Préfère être avec le patient ; mémorise/observe l'essentiel de la visite | ACT-F008-013 |
| OBS-D-017 | F009 | Pour un patient connu (Parkinson), privilégie complètement l'échange sur la documentation — s'appuie sur la relation établie | ACT-F009-016 |

**PAT-D-003 — ≈ MEDIUM — Confidence 4/9 (44%)**
La mémorisation remplace la documentation en temps réel précisément quand la relation praticien-patient
est déjà établie (suivi longitudinal, patient connu). 4 profils convergents (F001, F004, F008, F009) —
tous en relation de suivi, aucun profil "acte sur demande" dans ce groupe.

---

## Q4 — Que note-t-il immédiatement ?

**Evidence Summary :** Ce qui risque d'être perdu avant la fin de l'acte. Renvoie directement à
**PAT-D-001 (≈ MEDIUM, 4/9)** — pas de nouveau Pattern.

**OBS**

| ID | Profil | Observation | Ancre |
|---|---|---|---|
| OBS-D-018 | F006 | Note immédiatement les inquiétudes EXPRIMÉES PAR LA PATIENTE | ACT-F006-015 |
| OBS-D-019 | F009 | Prend un rappel immédiat pour toute information non urgente, explicitement pour ne pas l'oublier | ACT-F009-030 |

---

## Q5 — Que complète-t-il après la consultation ?

**Evidence Summary :** Un aide-mémoire sélectif pour la prochaine rencontre, pas un compte-rendu
exhaustif — mais sur un échantillon trop faible pour généraliser. **PAT-D-004 — ≈ LOW (2/9 profils).**

**OBS**

| ID | Profil | Observation | Ancre |
|---|---|---|---|
| OBS-D-020 | F004 | Écrit précisément ce qui permettra de reprendre facilement la PROCHAINE séance — contenu tourné vers le futur, pas un compte rendu exhaustif | ACT-F004-011 |
| OBS-D-021 | F007 | Écrit uniquement ce qui est pertinent pour suivre l'évolution des symptômes et adapter la prise en charge | ACT-F007-017 |
| OBS-D-022 | F005/F006/F009 | Complètent un compte rendu destiné à un tiers (médecin prescripteur) — fonction de communication externe, distincte d'un aide-mémoire personnel | ACT-F005-013/016, ACT-F006-016, ACT-F009-026 |

**PAT-D-004 — ≈ LOW — Confidence 2/9 (22%)**
Pour les profils en suivi longitudinal du même praticien avec le même patient (psychologue,
kinésithérapeute), le contenu post-consultation est un aide-mémoire pour **soi-même** au prochain
rendez-vous — sélectif, jamais exhaustif. Seulement F004 et F007 — échantillon trop faible pour
dépasser LOW, malgré des verbatims presque identiques dans leur logique.

**GAP-D-001 (?)** — Pour les profils "acte sur demande" avec compte rendu à un tiers (échographiste,
sage-femme, coordination), le corpus ne précise pas si un aide-mémoire personnel distinct du compte
rendu officiel existe également.

**HYP-D-001 (?)** — *(reclassée depuis PDR-004 v0.1, anciennement "DD-403" — c'est une hypothèse, pas
une décision, voir audit PDR-004)*. Si PAT-D-004 se confirmait avec plus de profils, un principe du
type *"WS-004 SHALL NOT prompt for exhaustive session recall — it SHALL prompt for what matters for the
next encounter"* deviendrait défendable. Bloquée par GAP-D-001 et par [WBD-004](WBD-004-consultation-vs-documentation.md)
(le territoire "contenu" a été écarté comme base de frontière, faute de preuve suffisante). Ne pas
promouvoir en Product Principle sans confirmation via RQ-WBD-004-1.

---

## Q6 — Qu'oublie-t-il ?

**Evidence Summary :** Inconnu. Un seul indice indirect dans tout le corpus — **? GAP quasi complet.**

**OBS**

| ID | Profil | Observation | Ancre |
|---|---|---|---|
| OBS-D-023 | F009 | Seul indice direct du corpus : *"Oui. Tout le temps. Si je ne note pas, j'oublie."* — admission explicite que l'oubli survient sans prise de rappel, pour les informations non urgentes reçues entre les visites | ACT-F009-030 |

**GAP-D-002 (?) — Gap quasi-complet.** Aucun praticien du corpus ne rapporte un cas concret et
rétrospectif de "ce qui a été oublié et pourquoi cela a compté." OBS-D-023 documente la **prévention**
de l'oubli, pas l'oubli lui-même ni ses conséquences. Ne pas construire de Pattern dessus.

---

## Q7 — Qu'est-ce qui déclenche la rédaction ?

**Evidence Summary :** La fin de la consultation, par défaut — le signal le plus fort de toute cette
extraction. **PAT-D-005 — ≈ HIGH (7/9 profils).**

**Synthèse croisée** (agrégation des observations Q1–Q6, aucune nouvelle OBS) :

| Déclencheur | Profils | Confiance |
|---|---|---|
| Fin de la consultation (déclencheur par défaut) | F002, F003, F004, F006, F007, F008, F009 | HIGH — 7/9 |
| Risque perçu de perdre une information | F004, F007, F008, F009 | MEDIUM — 4/9 (= PAT-D-001) |
| Durée de l'acte (acte long → rédaction pendant) | F005 uniquement | LOW — 1/9, non généralisable |
| Protocole structuré imposant une saisie temps réel | F009 (grille diabétique) uniquement | LOW — 1/9, cas structuré |
| Inquiétude explicitement exprimée par le patient | F006 uniquement | LOW — 1/9 |
| Disponibilité de temps entre deux patients | F007 (conditionnel) | LOW — 1/9 |
| Aucun déclencheur — pas de rédaction clinique | F001 | Cas limite explicite |

**PAT-D-005 — ≈ HIGH — Confidence 7/9 (78%)**
La fin de la consultation est le déclencheur par défaut de la rédaction pour la majorité des profils.
L'écriture pendant la consultation reste l'exception, réservée aux cas où l'information risque d'être
perdue avant la fin.

---

## Q8 — Comment sait-il qu'il a terminé ?

**Evidence Summary :** Inconnu au niveau d'une note isolée. Les seuls signaux trouvés concernent la fin
de journée. **? GAP complet.**

**OBS**

| ID | Profil | Observation | Ancre |
|---|---|---|---|
| OBS-D-024 | F001 | Signal de fin explicite, mais au niveau JOURNÉE, pas au niveau d'une note — *"Ma journée est vraiment terminée quand je sors la porte du cabinet"* | ACT-F001-027 |
| OBS-D-025 | F007 | Signal de clôture également au niveau journée — *"Que tous les dossiers sont fermés"* | ACT-F007-025 |
| OBS-D-026 | F009 | Les tâches non terminées sont explicitement reportées au lendemain plutôt que forcées à leur terme le jour même | ACT-F009-033 |

**GAP-D-003 (?) — Gap complet sur la question posée.** Aucun profil ne décrit de critère de complétude
pour **une** note ou **un** compte rendu isolé. "Terminé" semble borné par le temps disponible plutôt
que par un sentiment de complétude du contenu (OBS-D-026 va dans ce sens) — mais c'est une inférence,
pas une observation directe. Traiter comme hypothèse (?), pas comme pattern.

---

## Tensions

> Nouvelle catégorie GOV-000 v1.1 — une Tension est une divergence de comportement directement opposée
> entre deux profils sur le même axe. Ce n'est ni un Gap (absence de donnée — ici les deux profils
> **ont** des données, contradictoires) ni un Pattern (convergence — ici c'est l'inverse). Une Tension
> signale qu'un Product Principle universel est probablement le mauvais outil ; une Display Rule ou un
> choix de conception assumé (avec un camp perdant) l'est davantage. Marqueur : ⚠.

**TEN-D-001 — Volume de documentation : jamais vs beaucoup ⚠**

F001 (kinésithérapeute) ne rédige **aucune** note clinique, jamais (ACT-F001-019 — clôture systématique
sans notes, appuyée sur la mémoire, OBS-D-014). F009 (infirmière coordinatrice) documente de façon
intensive et structurée en temps réel pour certains patients (grille de suivi diabétique, ACT-F009-025).
Les deux sont pleinement légitimes dans leur contexte — suivi manuel relationnel simple pour F001,
coordination multi-intervenants à haut risque pour F009. **Aucun seuil de "volume de documentation
correct" ne peut être universel.** Toute future Display Rule sur la densité de documentation doit
partir de cette tension, pas la lisser.

**TEN-D-002 — Présence vs prise de notes en temps réel, même famille de profils ⚠**

F004 (psychologue) ne note jamais pendant la séance — *"je préfère être présente avec lui"*
(ACT-F004-008). F002 (infirmière/sophrologue, profil également relationnel) prend des notes en temps
réel *"au fil de l'échange"* (ACT-F002-016). Ces deux profils sont proches par la nature de l'acte
(écoute, relation, peu de geste technique), ce qui rend la divergence plus significative qu'entre deux
métiers éloignés : **la variable qui explique le comportement n'est probablement pas le type d'acte,
mais un choix individuel ou une formation** — hypothèse non testée, à vérifier avant toute Display
Rule basée sur le "profil métier" pour ce point précis.

---

## Prochaine étape

Cette WE a ouvert [PDR-004](PDR-004-documentation.md), qui a confirmé PP-013/PP-014 (WS-003) sur la
base de PAT-D-002/005, et a révélé — via audit critique — que le comportement seul ne suffit pas à
fonder un Workspace WS-004 séparé. [WBD-004](WBD-004-consultation-vs-documentation.md) v2.0 a
finalement tranché par une question différente ("quelle responsabilité manque dans la Clinical Loop ?")
plutôt qu'en cherchant davantage de preuve comportementale — verdict **RESOLVED**. WS-004 devient la
responsabilité de préservation/persistance de la mémoire clinique (nom provisoire, "Clinical Memory"
écarté pour collision avec Care Record — voir WBD-004). TEN-D-001/002 et OQ-WBD-004-1 à 4 restent des
questions ouvertes pour informer le contenu du futur Blueprint, plus des blocages de frontière.
