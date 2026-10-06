# Care Record — Fiche d'implémentation (Phase 2 — Freeze V1)

| Field | Value |
|---|---|
| Objet | Care Record — **pas un Workspace** (ADR-0023 §5, WSP-001) |
| Version | 0.3 |
| Date | 2026-10-05 |
| Sources normatives | [ADR-0010](../../adr/ADR-0010-care-record.md) (définition Domain) · [ADR-0023](../../adr/ADR-0023-patient-context-consultation-care-record.md) (structure produit, `Frozen`) |
| Prototype | `WS-002-WS-003-parcours-v8.html`, section `#record` |

> Le Care Record n'a pas de Blueprint Discovery propre, contrairement à WS-001/002/003 — il n'est
> pas un Workspace. Ce document est donc uniquement la fiche d'implémentation Phase 2, adossée aux
> deux ADR ci-dessus, qu'il ne duplique pas et ne modifie pas.

---

## Objectif

ADR-0023 §6 : *"Care Record = approfondir."* ADR-0010 : *"la mémoire clinique longitudinale d'un
patient"* — conséquence du travail clinique, pas un prérequis. Principe (ADR-0023 §5) : *"La
profondeur est disponible, mais elle n'est jamais imposée."*

## Entrée

| Depuis | Mécanisme | Conforme ? |
|---|---|---|
| WS-002 — "Consulter le dossier complet" + 9 items de la sidebar Dossier | `openRecord('patient', section)`, ancrage + surlignage | ✓ ADR-0023 §5 |
| WS-003 — bandeau patient, carte contexte, bouton "Dossier" | `openRecord('ws3')` | ✓ ADR-0023 §5 (Lookup) |
| WS-003 — onglet Historique, "Voir le dossier complet" | `openRecord('ws3')` | ✓ |
| Liste "Patients" (annuaire) | `openRecord('search')` | ✓ — décision de session : annuaire ≠ patient vu aujourd'hui, donc pas WS-002 |

## Sortie

Retour à l'écran d'origine uniquement (`show(recordOrigin)`). **Aucune sortie vers WS-003** — le
bouton "Démarrer une consultation" proposé par une maquette externe a d'abord été ajouté non branché,
puis retiré (ADR-0023 §7 Règle 1 : *"La sélection d'un patient ne crée jamais automatiquement une
consultation"*). Conforme.

## Actions (réelles vs décoratives)

- **Réelles** : "Voir"/"Voir tout" de la Vue générale (`scrollToRecordSection`), "Plus ▾"/"Moins ▴"
  (`toggleRecordMore`), retour.
- **Décoratives** : "+ Ajouter" (personnes de confiance — déplacé dans la fiche patient le 2026-10-06).
- Libellé du bouton retour imprécis quand l'origine est la liste "Patients" (*"← Retour à Michel
  Rousseau"* alors qu'on retourne à l'annuaire) — défaut mineur, pré-existant à la nouvelle entrée.

## Données nécessaires

**Vue générale** (ajoutée 2026-10-04) : Informations principales, Personnes de confiance, Dernière
consultation, Traitement en cours, Derniers résultats.

**9 cartes catégorisées** : Historique, Résultats, Ordonnances, Documents (visibles) · Antécédents,
Famille, Vaccins, Mes notes, Courriers (derrière "Plus ▾", révélées automatiquement si on y arrive par
ancrage — pas de cul-de-sac).

## Règles — vérification contre les sources normatives

| Règle | Source | Prototype |
|---|---|---|
| Sélection d'un patient ≠ consultation | ADR-0023 §7 R1 | ✓ respectée |
| WS-002 ne devient pas un dossier complet | ADR-0023 §7 R3 | ✓ deux écrans distincts |
| Care Record consulté à la demande | ADR-0023 §7 R4 | ✓ pour le Care Record lui-même — ⚠ voir tension ci-dessous |
| Ne pas fusionner WS-002 et Care Record | ADR-0023 §9 | ✓ |
| Dérivé exclusivement de Clinical Contributions | ADR-0010 Invariant 2 | ⚠ non vérifiable en prototype (données statiques) |
| **Ne contient jamais d'information hors connaissance clinique** | **ADR-0010 Invariant 3** | ✓ depuis 2026-10-06 (était ✗ — voir ci-dessous) |
| Pas responsable des règles de visibilité | ADR-0010 Non-Responsibilities | ✓ aucune règle implémentée (cohérent avec HR-001 H-G1, `Open`) |
| Pas responsable de l'acquisition/import de documents | ADR-0010 Non-Responsibilities | ✓ |

### Déviation confirmée — Invariant 3 d'ADR-0010

La carte "Informations principales" contient **téléphone, email, adresse postale**, et la carte
"Personnes de confiance" un **contact familial**. Ce sont des données administratives et de
contact, pas de la connaissance clinique. ADR-0010 est explicite : le Care Record *"never contains
information outside the scope of clinical knowledge."*

Origine : maquette externe intégrée le 2026-10-04 (Vue générale), puis enrichie le même jour
(personnes de confiance). **Aucun signalement de cette contradiction au moment de l'intégration** —
la revue s'était concentrée sur ADR-0023 (bouton "Démarrer une consultation"), pas sur ADR-0010.

Lecture : ces données ont une place légitime dans le produit, mais pas *dans le Care Record* au sens
du Domain. Elles relèvent plutôt de l'identité/administratif du patient (hors Clinical Platform au
sens strict, ou d'un autre Bounded Context). Deux options avaient été posées en v0.1 : (a) déplacer ces cartes hors de l'écran Care Record ; (b)
renommer l'écran.

**Résolu par décision le 2026-10-06 — option (a).** `Architecture Constraint` (ADR-0010) + `Product
Decision`. Les données administratives quittent le Care Record pour une **fiche patient** distincte
(voir section suivante). La décision n'interdit pas l'accès à ces données : elle en déplace la place.

## Fiche patient — décision du 2026-10-06

**Contenu** : identité, téléphone, email, adresse, personne(s) à contacter, autres données
administratives. **Pas** de connaissance clinique.

**Accès** — `Product Decision` : depuis WS-003 (bandeau patient, carte de contexte), WS-002 (bandeau)
et le Care Record (en-tête). Le praticien ne quitte pas la consultation pour la consulter ; le retour
est immédiat.

**Forme** :
- **Dans WS-003 — déjà fixée par PP-010** (*"replace the primary view — not layer over it [...]
  returning SHALL require one action only"*) : Lookup plein écran, état de consultation conservé. Un
  drawer, modal ou panneau superposé serait une hypothèse en concurrence avec PP-010 — aucune n'est
  ouverte.
- **Hors WS-003 (WS-002, Care Record) — question UX ouverte** : drawer, modal, page, panneau latéral ou
  autre, non tranché. Le prototype utilise provisoirement la même page que dans WS-003, avec une
  mention explicite "forme non décidée" — pas un choix.

**Terrain** — `Evidence` (faible) : ACT-F007-006 *"Créer la fiche patient"* et ACT-F007-007
*"Recueillir les coordonnées"* (1 profil, synthèse rapportée) — les données administratives font partie
du travail réel. L'accès **pendant** la consultation n'est pas observé : Founder-Driven.

**Questions d'architecture ouvertes — non tranchées** (`Architecture Constraint`) :
- **Propriétaire des données administratives.** Ni le Care Record (ADR-0010), ni le Kernel (*"must NOT
  know Patient"*, `CLAUDE.md`). Candidats : Identity Platform, Patient Engagement (ADR-0012), ou un
  autre contexte. Aucun concept Domain créé ; "Fiche patient" est du vocabulaire Product (GOV-000
  §1ter-a).
- **Personne de confiance.** Peut ne pas être un simple contact : c'est une notion juridique (Code de
  la santé publique — à vérifier), qui pourrait relever de Trust / consentement plutôt que de
  l'administratif. Signalé, non classé. Le prototype la place provisoirement dans la fiche patient,
  avec cette mention.

### Tension (non une violation) — Règle 4 et principe "jamais imposée"

Le Care Record lui-même reste consulté à la demande. Mais la carte **"Contexte patient" permanente
de WS-003** (allergie, pathologies, traitement en cours) est une projection condensée de ce même
contenu, affichée sans action explicite. Ce n'est pas formellement le Care Record — c'est un dérivé —
mais elle éprouve directement le principe d'ADR-0023 §5. Décision consciente du Product Owner, déjà
tracée côté WS-003 (§16 de son Blueprint, PP-009/PP-010) ; signalée ici pour que la tension soit
visible des deux côtés.

## États

- Patient avec historique riche — seul état testé (Michel Rousseau).
- **Care Record vide** — ADR-0010 : *"A Care Record may initially contain no clinical knowledge."*
  **Aucun état vide construit** dans le prototype. C'est pourtant exactement le cas du *cold start*
  identifié comme critique dans le bilan d'octobre (nouveau praticien, aucun historique importé). À
  construire avant Phase 4.
- Patient autre que Michel Rousseau — aucun Care Record (l'annuaire n'ouvre que Michel Rousseau).

## Erreurs / cas limites non couverts

- Documents externes non issus d'une Clinical Activity — **HR-001 H-ES-002**, `Open` : la relation
  entre artefacts importés et Care Record est explicitement non définie. La carte "Documents" du
  prototype (CR d'échographie, radiographie) affiche ce type de contenu sans trancher cette question.
- Contribution ajoutée après clôture d'une activité — **HR-001 H-ADD-001**, `Open`.
- Règles de visibilité multi-praticiens — **HR-001 H-G1**, `Open`.

## UX

ADR-0023 §8 laisse explicitement libre la *présentation* du Care Record. La structure "Vue générale
+ cartes ancrées + Plus ▾" est donc dans le périmètre de liberté. Ce qui ne l'est pas : le contenu
administratif (Invariant 3, ci-dessus) — c'est une question de Domain, pas de présentation.

---

## Requalification ADR-0025 (2026-10-06)

> Lecture [ADR-0025](../../adr/ADR-0025-innovations-produit-non-observees.md). **Ce que la
> requalification ne couvre pas** : la violation de l'Invariant 3 d'ADR-0010 (données
> administratives/contact). ADR-0025 §2 : l'innovation est libre au niveau Product/UX, jamais au
> niveau Domain — ces cartes ne deviennent pas une "hypothèse". Résolue par décision le 2026-10-06
> (option a, fiche patient). "Majorité" = plus de la moitié des praticiens du round.

| HYP | Élément | Origine | Problème visé |
|---|---|---|---|
| CR-001 | Vue générale (synthèse en tête du dossier) — sans cartes administratives depuis 2026-10-06 | Founder-Driven (maquette externe, 2026-10-04) | PP-005 (*surface recent first*) |
| CR-002 | Catégories repliées derrière "Plus ▾" | Founder-Driven | Densité du dossier complet |
| — | Annuaire → Care Record | voir [WS-002 HYP-002-004](WS-002-patient-context.md) | — |

```
HYP-CR-001 — Vue générale
Mise à jour:        (2026-10-06) Ne contient plus que du clinique : dernière consultation, traitement en
                    cours, derniers résultats. L'identité minimale (nom, âge) reste dans le bandeau,
                    comme référence au patient
Hypothèse:          Une synthèse en tête oriente avant de descendre dans les catégories
Risque si faux:     Le Care Record refait le travail de WS-002 (ADR-0023 : WS-002 comprendre, Care
                    Record approfondir) ; arrivée par Lecture A ralentie par un écran intermédiaire
Test:               Arrivée par Lecture A (catégorie précise) : le praticien lit-il la Vue générale ou
                    va-t-il directement à la catégorie ?
Critère d'abandon:  La majorité la saute → retirée ; l'ancrage par catégorie (OBS-M2-012) suffit
Statut:             ? ⚠ — À tester

HYP-CR-002 — Catégories repliées ("Plus ▾")
Hypothèse:          Masquer les catégories moins consultées allège sans perte (ouverture automatique si
                    on y arrive par ancrage)
Risque si faux:     Information cherchée et non trouvée — antécédents, vaccins, courriers
Test:               Tâche : "Retrouvez les antécédents familiaux" sans passer par la sidebar
Critère d'abandon:  Un seul praticien échoue à trouver une catégorie repliée → toutes visibles
                    (seuil volontairement bas : une information clinique introuvable coûte plus cher
                    qu'un écran chargé)
Statut:             ? ⚠ — À tester
```

**Manque, pas hypothèse** : l'état vide (cold start) — ADR-0010 le prévoit explicitement.

---

## Évolution

| Version | Date | Nature |
|---|---|---|
| 0.1 | 2026-10-05 | Création — fiche d'implémentation Phase 2. Pas de Blueprint Discovery préalable (le Care Record n'est pas un Workspace). Conformité ADR-0023 §7 confirmée. **Violation d'ADR-0010 Invariant 3 identifiée** (données administratives/contact dans la Vue générale), non signalée au moment de son intégration, non corrigée ici — deux options posées. État vide (cold start) absent du prototype. |
| 0.2 | 2026-10-06 | Requalification [ADR-0025](../../adr/ADR-0025-innovations-produit-non-observees.md) : HYP-CR-001 (Vue générale) et HYP-CR-002 (catégories repliées, seuil d'abandon volontairement bas). La violation de l'Invariant 3 d'ADR-0010 reste hors du champ d'ADR-0025 (Domain) — décision (a)/(b) toujours à prendre. |
| 0.3 | 2026-10-06 | **Invariant 3 d'ADR-0010 résolu par décision (option a)** : données administratives sorties du Care Record vers une fiche patient distincte, accessible depuis WS-003 (forme fixée par PP-010 : Lookup plein écran), WS-002 et le Care Record (forme hors WS-003 : question UX ouverte). Propriétaire des données administratives et nature de la personne de confiance : questions d'architecture ouvertes, non tranchées. HYP-CR-001 mise à jour (vue générale clinique uniquement). |
