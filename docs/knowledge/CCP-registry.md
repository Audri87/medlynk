# CCP-registry — Registre des Clinical Cognitive Profiles

**Type :** Registre normatif
**Statut :** Draft v0.1
**Date :** 2026-07-30
**Gouverné par :** CCF-01 · CI-registry · MKO-000
**Gouverne :** Design profil-spécifique · Tests utilisateurs ciblés

---

## Principe

Un Clinical Cognitive Profile (CCP) est une configuration stable de l'expression des Invariants pour un contexte de pratique spécifique.

**Ce qu'un CCP fait :**
- Module le *poids* de certains Invariants (CI-04 est central pour CCP-003, périphérique pour CCP-001)
- Module l'*expression* de certains Invariants (CI-01 s'exprime via la mémoire en CCP-001, via les notes en CCP-002)
- Module les *stratégies de compensation* observées (CI-03 → externalisation documentaire en CCP-002, filtrage mnésique en CCP-001)

**Ce qu'un CCP ne fait pas :**
- Ne crée pas de nouveaux Invariants
- Ne supprime pas d'Invariants existants
- Ne modifie pas la définition d'un Invariant

**Relation MKO :** `CCP-xxx --[CONFIGURES]--> Architecture (CCF-01)` et, par inférence IR-004 : `CCP-xxx --[CONFIGURES_EXPRESSION_OF]--> CI-xxx`

---

---

## CCP-001 — Memory-First

**Identifiant :** CCP-001
**Statut :** Draft
**Confiance corpus :** 3/9 profils (F-001, F-003, F-007 partiel)

### Définition

Le praticien Memory-First s'appuie principalement sur sa mémoire à long terme pour la reconstruction de contexte. Les artefacts (notes, dossier) sont des vérifications ou des filets de sécurité, pas des sources primaires. La mémoire *est* le modèle clinique.

### Motivation

CCP-001 a été identifié comme architecture cognitive distincte lors de l'analyse de F-001 (kinésithérapeute dont la mémoire somatic-based structure tout le raisonnement) et F-003 (médecin libéral qui opère la reconstruction en 30 secondes depuis la mémoire). Ce profil produit des besoins de design différents de CCP-002 — notamment, l'interface n'a pas besoin d'être la source primaire d'information.

### Relations

```
CCP-001  --[CONFIGURES]-->               CCF-01
CCP-001  --[OBSERVED_IN]-->              F-001, F-003, F-007 (partiel)
CCP-001  --[CONFIGURES_EXPRESSION_OF]--> CI-01 (mémoire long terme, artefacts = backup)
CCP-001  --[CONFIGURES_EXPRESSION_OF]--> CI-03 (filtrage mnésique dominant)
CCP-001  --[CONFIGURES_EXPRESSION_OF]--> CI-04 (distribution minimale)
```

### Configuration des Invariants

| Invariant | Expression dans CCP-001 | Poids relatif |
|---|---|---|
| CI-01 | Reconstruction via mémoire long terme. Artefacts consultés en cas de doute ou d'absence longue. | Central — mais rapide |
| CI-02 | Delta cognitif : "je sais ce qui a changé depuis". Vérifié en mémoire d'abord. | Très fort |
| CI-03 | Stratégie dominante : filtrage mnésique. Externalisation limitée. Notes peu nombreuses. | Présent — expression compressée |
| CI-04 | Distribution minimale. Peu de notes produites pour le réseau. Travail souvent solo. | Faible |
| CI-05 | Attribution implicite : "c'est ma note donc je lui fais confiance". | Présent — surtout pour sources externes |

### Implications de design (non normatives)

Un Workspace conçu pour CCP-001 peut tolérer une interface plus condensée à l'ouverture. L'Anchor est plus une confirmation qu'une source. L'affichage par défaut peut être plus minimal que pour CCP-002.

### Justification scientifique

**Corpus terrain :** F-001 — *"Je me souviens de tout. Je n'ai pas besoin de relire."* F-003 — *"En 30 secondes je dois savoir où j'en suis."* (depuis la mémoire)

**Limite :** 3 profils, dont 1 partiel. Profil peu diversifié (2 kinésithérapeutes, 1 médecin libéral). Extension requise.

### Dépendances

Aucun document normatif ne dérive de CCP-001 dans l'état actuel. Son influence est sur les décisions de design ciblées — pas sur les WR généraux.

### Historique des révisions

| Date | Version | Nature |
|---|---|---|
| 2026-07-30 | v1.0 | Création — corpus F-001, F-003, F-007 |

---

---

## CCP-002 — Documentation-Centric

**Identifiant :** CCP-002
**Statut :** Draft
**Confiance corpus :** 4/9 profils (F-002, F-004, F-008, F-009)

### Définition

Le praticien Documentation-Centric s'appuie principalement sur ses notes et sa documentation pour la reconstruction de contexte. La documentation *est* le modèle clinique — la mémoire individuelle entre les séances est temporaire et non fiable. Le dossier n'est pas un backup : c'est la source primaire.

### Motivation

CCP-002 est le profil le plus représenté dans le corpus (4/9). Il produit des besoins de design critiques : si la documentation est la source primaire d'information, alors la qualité, la rapidité d'accès et l'organisation de cette documentation sont des conditions directes de la qualité clinique.

### Relations

```
CCP-002  --[CONFIGURES]-->               CCF-01
CCP-002  --[OBSERVED_IN]-->              F-002, F-004, F-008, F-009
CCP-002  --[CONFIGURES_EXPRESSION_OF]--> CI-01 (reconstruction via relecture notes)
CCP-002  --[CONFIGURES_EXPRESSION_OF]--> CI-03 (externalisation documentaire dominante)
CCP-002  --[CONFIGURES_EXPRESSION_OF]--> CI-04 (production de documentation pour le réseau)
```

### Configuration des Invariants

| Invariant | Expression dans CCP-002 | Poids relatif |
|---|---|---|
| CI-01 | Reconstruction via relecture des notes. La séance précédente est la clé d'entrée. Mémoire = complément. | Central — dépend de l'interface |
| CI-02 | Delta cherché dans les notes : "qu'est-ce qui a changé dans ma dernière note ?". | Très fort — souvent documenté |
| CI-03 | Stratégie dominante : externalisation documentaire. Notes = mémoire de travail externe. | Fort — l'interface est la stratégie |
| CI-04 | Production de documentation pour le réseau. Notes et transmissions = contribution distribuée. | Moyen à fort |
| CI-05 | Attribution forte : "c'est ma note d'il y a 3 semaines, je me rappelle le contexte". | Fort — surtout pour les propres notes |

### Implications de design (non normatives)

Un Workspace conçu pour CCP-002 doit faire de la note précédente un point d'entrée central. L'interface *est* la stratégie de gestion de la charge. La qualité de la documentation produite dans l'interface se répercute directement sur la qualité de la reconstruction suivante.

### Justification scientifique

**Corpus terrain :** F-002 — *"Je ne dis presque jamais 'je me souviens'. Je relis rapidement mes notes."* F-004 — *"La note post-consultation, c'est la production du prochain Anchor."* F-008 — confirmation intra-profession de F-002.

### Dépendances

Aucun document normatif ne dérive de CCP-002 dans l'état actuel.

### Historique des révisions

| Date | Version | Nature |
|---|---|---|
| 2026-07-30 | v1.0 | Création — corpus F-002, F-004, F-008, F-009 |

---

---

## CCP-003 — Coordinator

**Identifiant :** CCP-003
**Statut :** Draft — profil unique, confirmation requise
**Confiance corpus :** 1/9 profils (F-009 uniquement)
**Avertissement :** Ce profil est fondé sur un seul entretien. Il est plausible mais non confirmé. Il ne doit pas fonder de décisions de design critiques sans validation supplémentaire.

### Définition

Le praticien Coordinateur est le nœud actif d'un réseau de soin. Son travail n'est pas de soigner directement — c'est de faire circuler la bonne information entre les bons acteurs au bon moment. Les interruptions ne perturbent pas son cycle cognitif : elles *sont* ses cycles, en parallèle, pour N patients simultanés.

### Motivation

CCP-003 révèle une architecture cognitive structurellement différente des deux premières. Le coordinateur ne lit pas le réseau de soin — il *produit* le réseau de soin. Cette distinction est importante pour le design : une interface conçue pour CCP-001 ou CCP-002 (un patient à la fois, séquentiellement) échouera pour CCP-003 (N patients en parallèle, interruptions continues).

### Relations

```
CCP-003  --[CONFIGURES]-->               CCF-01
CCP-003  --[OBSERVED_IN]-->              F-009
CCP-003  --[CONFIGURES_EXPRESSION_OF]--> CI-04 (production synchrone, nœud du réseau)
CCP-003  --[CONFIGURES_EXPRESSION_OF]--> CI-03 (partitionnement temporel hebdomadaire)
CCP-003  --[CONFIGURES_EXPRESSION_OF]--> CI-01 (reconstruction minimale — anchor sécurité 3 éléments)
```

### Configuration des Invariants

| Invariant | Expression dans CCP-003 | Poids relatif |
|---|---|---|
| CI-01 | Reconstruction réduite au minimum de sécurité (identité + pathologie + traitement). N'entre pas dans le détail — délègue à d'autres. | Présent — très compressé |
| CI-02 | Delta hebdomadaire : "qu'est-ce qui a changé cette semaine pour ce patient ?" L'unité temporelle est différente. | Fort — horizon différent |
| CI-03 | Partitionnement temporel extrême. File d'attente prioritisée. Délégation comme stratégie première. | Central — le plus visible |
| CI-04 | Architecture tout entière orientée vers la production distribuée. N patients en parallèle. | Dominant — définit le profil |
| CI-05 | Attribution critique pour les transmissions sortantes. Moins critique pour la reconstruction (confiance dans le réseau). | Fort sortant, moyen entrant |

### Implications de design (non normatives)

Un Workspace pour CCP-003 est fondamentalement différent d'un Patient Workspace classique. Il n'est pas centré sur un patient — il est centré sur une file. Il gère des priorités, des délégations, des statuts de transmission. WR-09 (file de triage coordinateur) est le requirement central pour ce profil.

### Question ouverte

CCP-003 est-il une variation de CCP-002 (documentation-centrique avec échelle N patients) ou une architecture cognitive distincte ? Cette question détermine s'il faut un Workspace séparé ou une configuration du Patient Workspace. Un deuxième entretien coordinateur est prioritaire pour trancher.

### Justification scientifique

**Corpus terrain :** F-009 uniquement — *"Tout le monde m'appelle. Je fais le lien entre les médecins, les infirmières, les pharmaciens et les patients."*

**Minimum de sécurité observé :** identité et contact, pathologie principale active, traitement en cours. (Documenté dans CC-000 sous H-09.)

### Dépendances

- **WR-09** — File de triage pour profils coordinateurs

### Historique des révisions

| Date | Version | Nature |
|---|---|---|
| 2026-07-30 | v1.0 | Création — F-009 uniquement — confirmation requise |

---

*Registre CCP — Draft v0.1 — 2026-07-30*
*Prochain profil candidat : profil urgentiste (aucun patient connu, reconstruction en mode état exclusif).*
*Tout nouveau CCP doit être fondé sur au minimum 2 entretiens convergents.*
