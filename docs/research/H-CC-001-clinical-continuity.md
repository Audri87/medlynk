# H-CC-001 — Clinical Continuity

**Statut** : Candidate Hypothesis
**Date** : 2026-07-09

---

## Observation

Les interviews révèlent que la continuité de la prise en charge constitue une préoccupation explicite des Practitioners.

Chez une infirmière libérale, la journée est considérée comme terminée uniquement lorsque les transmissions ont été réalisées.

Les erreurs rapportées concernent principalement des ruptures de continuité (information non transmise, protocole incomplet, retour d'hospitalisation mal documenté), et non des erreurs de raisonnement clinique.

**Connexion CCF-001 :** Cette observation confirme et étend O-005 — "la journée se termine lorsque la charge mentale est refermée." Pour les professions de soins continus, la clôture de la charge mentale passe par l'acte de transmission. Candidate à O-007.

---

## Hypothèse

Il existe un concept métier transversal appelé **Clinical Continuity**.

La Clinical Continuity représente la capacité d'assurer qu'une prise en charge puisse être poursuivie correctement lorsqu'elle passe d'un Practitioner à un autre.

Elle est distincte :

* de la Clinical Activity (réalisation d'un acte clinique) ;
* de la Clinical Contribution (production de connaissance clinique) ;
* de la Collaboration (travail simultané entre plusieurs Practitioners).

Elle décrit une **relation séquentielle** de responsabilité.

**Clinical Handover** est le mécanisme principal de la Clinical Continuity : l'acte formel de transfert des informations essentielles d'un Practitioner à un autre.

---

## Invariants candidats

| ID | Invariant |
|---|---|
| I-CC-001 | Tout Clinical Handover a un émetteur identifié et un destinataire identifié |
| I-CC-002 | Tout Clinical Handover est lié à une prise en charge clinique d'un Patient |
| I-CC-003 | Un Clinical Handover ne peut pas être vide — il doit contenir les informations essentielles à la continuité |
| I-CC-004 | Un Clinical Handover doit être accusé réception pour être considéré complet |
| I-CC-005 | Un Clinical Handover complété ne peut pas être supprimé |

**I-CC-003 est l'invariant structurant.** Il transforme la transmission en concept métier : le Handover a une définition de complétude vérifiable.

---

## Distinction avec les concepts existants

| Concept | Nature | Temporalité |
|---|---|---|
| Practitioner Interaction | Sollicitation individuelle explicite | Concurrent / à la demande |
| Clinical Collaboration | Care Teams, RCP, protocoles | Concurrent / structurel |
| **Clinical Continuity** | Transfert séquentiel de responsabilité | **Séquentiel / au relais** |

---

## Positionnement architectural candidat

Clinical Continuity : sous-domaine du **Clinical Platform**.

Le Clinical Handover serait une extension naturelle de la Phase 7 (Closure) du Clinical Activity Lifecycle (CAL-001) — une clôture qui transfère plutôt qu'elle ne ferme.

La coordination (qui prend le relais) reste un référencement simple à un Actor, sans nécessiter la Collaboration Platform à ce stade.

---

## Validation requise

Cette hypothèse devra être confrontée à plusieurs profils :

| Profil | Raison |
|---|---|
| Médecin généraliste | Remplacement vacances, transfert de patients |
| Kinésithérapeute | Continuité en cours de traitement |
| Sage-femme | Passation de garde |
| Psychologue | Transfert thérapeutique (cas complexe) |
| Urgentiste | Relève haute fréquence — test de robustesse |

**Question de validation :** La Clinical Continuity constitue-t-elle un invariant transversal, ou est-elle spécifique aux professions de soins continus ?

---

## Conséquences si validée

* Ajout de O-007 dans CCF-001 (extension de O-005)
* Clinical Handover comme Aggregate candidat dans Clinical Platform
* Mission M-CC-001 : "Permettre à un Practitioner d'assurer une continuité fiable de la prise en charge lors d'un relais"
* Ajout dans UL-001 : Clinical Continuity, Clinical Handover, Transmission

---

## Statut actuel

Clinical Continuity est reconnue comme **concept candidat**.

Aucune décision d'architecture n'est encore prise.

La validation terrain est nécessaire avant toute intégration dans le Domain Model.
