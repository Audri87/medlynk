# PDR-004 — Product Decision Record — Documentation

| Field | Value |
|---|---|
| ID | PDR-004 |
| Version | 0.3 |
| Status | **GO WITH CHANGES** — un product decision confirmé (EV-401), un candidat rejeté, un scope non tranché reversé en WBD |
| Date | 2026-08-04 |
| Nature | Artefact GOV-000 §5 (Product) — WE → PDR |
| Basé sur | [WE-004](WE-004-documentation.md) |
| Verdict de l'audit critique | GO WITH CHANGES — voir §Audit ci-dessous |
| Frontière WS-003/WS-004 | Reclassée en [WBD-004](WBD-004-consultation-vs-documentation.md) — **RESOLVED en v2.0** (analyse de responsabilité, pas nouvelle preuve corpus) |

> v0.1 numérotait trois décisions "DD-401/402/403" sous un même registre. L'audit critique a montré
> qu'une seule était réellement une décision produit ; les deux autres étaient mal classées. v0.2
> corrige la classification — c'est le changement demandé par le verdict GO WITH CHANGES, pas une
> réécriture du contenu.

---

## Audit — ce qui a changé et pourquoi

| Ancien ID | Nature réelle | Nouveau statut |
|---|---|---|
| DD-401 | Décision de frontière, pas une décision produit | Reclassé → [WBD-004](WBD-004-consultation-vs-documentation.md), verdict UNRESOLVED |
| DD-402 | Mise à jour d'evidence sur des PP déjà décidés (Model C), aucune décision prise ici | Reclassé → **EV-401** (Evidence Update, ci-dessous) |
| DD-403 | Hypothèse explicitement non décidée (2/9 profils) | Reclassée → **HYP-D-001** dans [WE-004](WE-004-documentation.md) |

**Un PDR a le droit de conclure qu'aucune décision ne peut encore être prise (GOV-000 v1.2, Gate 2).**
C'est le cas ici pour le scope de WS-004 : ce PDR ne décide pas de frontière — il la reversait à tort
en décision alors qu'elle ne l'était pas. La reclasser en WBD n'est pas un échec de ce PDR ; c'est ce
qu'un bon PDR est censé révéler.

---

## EV-401 — Renforcement d'evidence de PP-013 et PP-014 (WS-003)

*(anciennement DD-402 — renommé : ceci est une mise à jour d'evidence, pas une Design Decision.)*

**Constat.** PP-013 et PP-014 étaient `evidence: ?` (Model C, sans corpus). WE-004 apporte un ancrage
réel :
- PAT-D-005 (7/9) confirme intégralement PP-013 (capture pendant OU après, "après" par défaut).
- PAT-D-002 (7/9) confirme **une partie seulement** de PP-014 : le fait que la rédaction est reportée
  hors présence patient. Elle **ne confirme pas** le mécanisme d'état traqué + deux rappels non
  bloquants (§11 de WS-003) — pur héritage Model C, resté sans ancrage.

**Action.** PP-013 → `evidence: ≈` (pleinement supporté). PP-014 → **evidence scindée** : le principe
d'état ouvert/fermé passe à `≈`, le mécanisme de rappel reste `?`. Cette correction doit être répercutée
dans WS-003 (actuellement WS-003 affiche `evidence: ≈` pour l'ensemble de PP-014 sans cette nuance —
erreur introduite lors de l'application initiale d'EV-401, à corriger).

**Statut :** → Décidé et déjà appliqué (WS-003 v2.2, PRODUCT-PRINCIPLES.md) — **correction de nuance
requise sur PP-014**, voir Prochaine étape.

---

## Ce que ce PDR n'autorise toujours pas

**Mise à jour du 2026-08-04 (même jour) :** [WBD-004](WBD-004-consultation-vs-documentation.md) est
passé à **RESOLVED v2.0** — la frontière était mal posée (comportement, pas responsabilité). Une fois
reformulée en "quelle responsabilité manque dans la Clinical Loop entre WS-003 et WS-005", la réponse
est devenue claire par analyse architecturale, sans attendre de nouveau corpus. Le Blueprint WS-004
peut désormais être écrit — le nom reste néanmoins à confirmer (collision "Clinical Memory" / Care
Record, voir WBD-004 §Collision de nommage) avant la première ligne.

---

## Prochaine étape

1. **Corriger WS-003** : nuancer l'evidence de PP-014 (état ouvert/fermé = `≈`, mécanisme de rappel =
   `?`) — correction directe, aucune nouvelle recherche requise.
2. **Lancer le Sprint Discovery ciblé de WBD-004** : une question unique, quatre sous-questions
   vérifiables (RQ-WBD-004-1 à 4), critère de sortie explicite. Voir WBD-004 pour le détail.
3. Ne pas rouvrir de PDR-004 tant que WBD-004 n'a pas produit au moins un ≈ MEDIUM sur une
   responsabilité non couverte par WS-003.
