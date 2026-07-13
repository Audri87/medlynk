# H-CC-002 — Clinical Handover

**Statut** : Candidate Aggregate
**Date** : 2026-07-09
**Dépend de** : H-CC-001 — Clinical Continuity

---

## Contexte

Si l'hypothèse H-CC-001 est confirmée, MedLink devra disposer d'un mécanisme permettant de matérialiser une transmission de continuité entre Practitioners.

Le principal candidat identifié est **Clinical Handover**.

---

## Définition candidate

Un Clinical Handover représente un transfert explicite des informations nécessaires à la poursuite d'une prise en charge clinique entre deux Practitioners.

Le Clinical Handover est un mécanisme possible de la Clinical Continuity.

---

## Pourquoi un candidat Aggregate ?

Le concept semble posséder les caractéristiques d'un Aggregate :

* identité propre ;
* cycle de vie ;
* invariants métier ;
* responsabilité clairement délimitée.

---

## Lifecycle candidat

```
Créé
  │
  ▼
Préparé       ← l'émetteur valide que le contenu est suffisant (I-CC-003)
  │
  ▼
Transmis      ← acte explicite d'envoi
  │
  ▼
Accusé réception  ← le destinataire confirme
  │
  ▼
Clos
```

---

## Invariants candidats

Alignés sur H-CC-001 :

| ID | Invariant |
|---|---|
| I-CC-001 | Un émetteur identifié |
| I-CC-002 | Un Patient concerné |
| I-CC-003 | Contenu suffisant pour assurer la continuité (vérifiable à l'état Préparé) |
| I-CC-004 | Un destinataire identifié, un état de transmission explicite |
| I-CC-005 | Non supprimable une fois clos |

---

## Questions ouvertes

Le Clinical Handover est-il :

* un **Aggregate** — il possède une identité, un lifecycle, des invariants à protéger ?
* un **Domain Service** — si la logique de transmission est procédurale sans état propre ?
* un **Process Manager** — si la coordination entre émetteur et destinataire requiert une orchestration ?
* un autre mécanisme de modélisation ?

Cette décision sera prise uniquement après validation terrain de H-CC-001 et pendant l'Event Storming (ES-001).

---

## Positionnement architectural candidat

Si confirmé comme Aggregate : Clinical Platform, sous-domaine Clinical Continuity.

Relation avec CAL-001 : le Clinical Handover est une extension de la Phase 7 (Closure) — une clôture qui transfère la responsabilité plutôt qu'elle ne la ferme.

---

## Statut actuel

Clinical Handover est aujourd'hui le **principal candidat Aggregate** permettant de matérialiser la Clinical Continuity.

Cette qualification reste une hypothèse d'architecture, conditionnelle à la validation terrain de H-CC-001.

Aucune décision d'implémentation ne sera prise avant l'Event Storming.
