# Hypothesis Register — MedLink Clinical Platform

Dernière mise à jour : 2026-07-09

---

## Légende

| Statut | Signification |
|---|---|
| `active` | Hypothèse en cours — non testée |
| `partial` | Partiellement supportée — en dessous du seuil de validation |
| `validated` | Validée — seuil atteint (≥5 praticiens, ≥3 professions, ≥3 situations) |
| `falsified` | Réfutée par les observations |
| `revised` | Modifiée suite à une observation |

---

## Hypothèses UX / Workspace

| ID | Hypothèse | Statut | Observations |
|---|---|---|---|
| UX-001 | Les praticiens reconnaissent l'organisation tableau de bord (agenda + alertes + tâches en attente) | `partial` | OBS-001, OBS-002 |
| UX-002 | La séquence Pendant → Clôture → Fin de journée correspond à la pratique réelle | `partial` | OBS-001, OBS-002 |
| UX-003 | La barre de sécurité patient en permanence visible est perçue comme un gain | `partial` | OBS-001, OBS-002 |
| UX-004 | La notion de "consultation non terminée rappelée en fin de journée" est comprise et utile | `partial` | OBS-001, OBS-002 |
| UX-005 | Le format dossier (antécédents + chronologie + traitements) correspond à ce que les praticiens cherchent | `partial` | OBS-001, OBS-002 |

**Seuil de validation UX : 5 praticiens / 3 professions / 3 spécialités**
Situation actuelle : 2 praticiens / 1 profil dominant (obstétrique / gynécologie) — **non atteint**

---

## Hypothèses Domaine

| ID | Hypothèse | Statut | Observations |
|---|---|---|---|
| H-004 | Chaque Clinical Activity transforme des informations disponibles en productions cliniques sous la responsabilité d'un praticien | `active` | Non présentée aux praticiens |
| H-CA-001 | La frontière d'une Clinical Activity est définie par l'engagement de responsabilité, pas par la raison clinique | `active` | Non présentée aux praticiens |
| H-CA-002 | Un praticien peut choisir d'élargir le périmètre OU d'ouvrir une nouvelle activité liée | `active` | Non présentée aux praticiens |
| H-CK-001 | Le Care Record est la mémoire clinique longitudinale d'un patient, dérivée de ses Clinical Contributions. Son mode de matérialisation est un choix d'architecture, pas du domaine. | `validated` | ADR-0010 |
| H-VIS-001 | La visibilité des contributions doit être modélisée comme un concept domaine, pas une règle technique | `active` | Non présentée aux praticiens |
| H-CC-001 | Il existe un concept métier transversal "Clinical Continuity" — capacité d'assurer qu'une prise en charge puisse être poursuivie correctement lorsqu'elle passe d'un Practitioner à un autre | `active` | OBS infirmière libérale — [H-CC-001](H-CC-001-clinical-continuity.md) |
| H-CC-002 | Clinical Handover est le principal candidat Aggregate pour matérialiser la Clinical Continuity (conditionnel à H-CC-001) | `active` | Dépend de H-CC-001 — [H-CC-002](H-CC-002-clinical-handover.md) |

---

## Hypothèses Produit

| ID | Hypothèse | Statut | Observations |
|---|---|---|---|
| H-P-001 | Le problème prioritaire à résoudre est "reprendre une consultation en quelques secondes, avec confiance" | `partial` | Validé verbalement — GP, GYN, SF (informel) |
| H-P-002 | Les praticiens veulent tout dans une seule interface (pas d'allers-retours) | `partial` | Observé GP, GYN, SF (informel) |
| H-P01 | Un praticien qui complète un Clinical Activity perçoit suffisamment de valeur pour choisir MedLink à nouveau, même sans historique | `active` | docs/product/H-P01-progressive-clinical-trust.md |

---

## Gaps ouverts (non hypothèses — questions sans réponse)

| ID | Gap | Priorité |
|---|---|---|
| G1 | Contribution Visibility — qui peut lire quoi, sous quelle condition | Bloquant avant MVP |
| G2 | Patient-generated data — mécanisme d'élévation vers Clinical Contribution | Important |
| ~~G3~~ | ~~Stratégie de données MVP — comment l'information entre dans MedLink sans DMP~~ | Fermé — ADR-0011 : les intégrations sont des accélérateurs, pas des prérequis |
| G4 | Identité provisoire du patient (urgences) | Important |
| G5 | Lien entre Clinical Activity et le rendez-vous Scheduling | À spécifier |
| ~~G6~~ | ~~Care Record : agrégat ou projection ?~~ | Fermé — ADR-0010 |

---

## Prochaines observations à planifier

Pour progresser vers le seuil de validation UX (5 praticiens / 3 professions) :

| Profil manquant | Raison |
|---|---|
| Médecin généraliste (en exercice actif) | Profil de référence — absent des validations formelles |
| Psychiatre | Particularités fortes sur la visibilité et la confidentialité |
| Kinésithérapeute | Modèle Enabling Contribution central (ordonnance MK) |

Pour progresser vers la validation domaine :
- Présenter les concepts Clinical Activity / Clinical Contribution en français, sans jargon MedLink
- Observer si les praticiens reconnaissent leur travail dans ces abstractions
- Valider H-CC-001 (Clinical Continuity) sur 5+ profils incluant : médecin généraliste, kiné, sage-femme, psychologue, urgentiste
