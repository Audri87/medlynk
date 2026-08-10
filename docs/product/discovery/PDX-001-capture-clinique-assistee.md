# PDX-001 — Capture clinique assistée

| Field | Value |
|---|---|
| ID | PDX-001 |
| Version | 0.3 |
| Status | Discovery (PDX) |
| Date | 2026-08-04 |
| Nature | Artefact GOV-000 v1.4 §1bis — Product Discovery, circuit parallèle au Discovery (CWRM) |
| Origine | [WE-004](../workspaces/WE-004-documentation.md) |
| Origine (indicateur GOV-000) | Discovery-Driven — en cours (pas encore validée par prototype/test) |
| Concerne | **Scindé par [WBD-004](../workspaces/WBD-004-consultation-vs-documentation.md) v2.0** — capture audio : WS-003 (Mode Capture, modalité) · transcription/extraction/synthèse : WS-004 (nom à confirmer, responsabilité de persistance) |
| Ne concerne pas | La décision de nommage de WS-004 (WBD-004 la renvoie au Blueprint) — ce PDX reste valide quel que soit le nom retenu |

> **Ce PDX n'est pas une spécification fonctionnelle.** Il ne dit pas "nous allons construire cela." Il
> dit "cela mérite un prototype." RG-002 (GOV-000 §1bis) : ce document ne crée aucun Product Principle.
>
> **Avertissement de méthode, à ne jamais retirer :** le corpus (WE-004) ne demande pas cette solution.
> Il documente la douleur qu'elle vise à résoudre. Présenter la capture assistée par IA comme "ce que
> les praticiens veulent" serait une erreur de gouvernance (GOV-000 §1bis, dérive 1).

---

## Titre

Capture clinique assistée

---

## Friction

La reconstruction différée mobilise fortement la mémoire. Ancrée sur des éléments réels de
[WE-004](../workspaces/WE-004-documentation.md), tous au-dessus du seuil MEDIUM ou explicitement
documentés comme Gap (RG-001 — pas de PDX sans friction documentée) :

- **PAT-D-002 (≈ HIGH, 7/9)** — la rédaction formelle est systématiquement reportée hors présence du
  patient.
- **PAT-D-003 (≈ MEDIUM, 4/9)** — la mémorisation remplace la documentation en temps réel.
- **PAT-D-005 (≈ HIGH, 7/9)** — la fin de consultation est le déclencheur par défaut de la rédaction —
  tout ce qui n'a pas été noté pendant doit être reconstruit d'un coup, après coup.
- **GAP-D-002 (? gap quasi complet)** — un praticien (F009) admet explicitement que l'oubli survient
  sans prise de rappel. Le coût de la reconstruction n'est jamais mesuré.
- **GAP-D-003 (? gap complet)** — aucun praticien ne décrit de critère de fin pour une note isolée.

---

## Hypothèse

Une capture audio passive, suivie d'une synthèse IA, réduit l'effort de reconstruction post-consultation
sans nuire à la relation patient — et sans interrompre l'attention portée au patient pendant la
consultation (cohérence requise avec PP-009, PP-010, déjà gelés dans WS-003).

```
Aujourd'hui :  Patient → Praticien → Mémoire → Compte rendu différé

Hypothèse :    Patient → Conversation → Transcription → Extraction de mots-clés
                              → Synthèse clinique proposée → Validation par le praticien
                    └──────┬──────┘   └──────────────┬───────────────────────┘
                      WS-003                      WS-004 (nom à confirmer)
                (capture audio,               (transformer la capture brute
                 modalité Mode Capture)         en mémoire clinique réutilisable)
```

> Frontière issue de [WBD-004](../workspaces/WBD-004-consultation-vs-documentation.md) v2.0 : capturer
> (WS-003) et préserver (WS-004) sont deux responsabilités distinctes, pas deux moments du même geste.

---

## Hypothèses à tester

- Les praticiens acceptent-ils l'enregistrement ?
- La synthèse est-elle suffisamment fiable ?
- Le gain de temps est-il réel ?
- La présence d'un micro modifie-t-elle la consultation ?
- (ajout) Cette acceptation varie-t-elle selon les profils déjà identifiés comme hétérogènes sur la
  documentation — TEN-D-001, TEN-D-002 (WE-004) ?

---

## Ce que le corpus prouve

- La reconstruction existe.
- Elle est différée.

## Ce que le corpus ne prouve pas

- Que les praticiens souhaitent être enregistrés.
- Qu'une synthèse IA soit acceptable.
- Que cela améliore réellement leur travail.

Le corpus s'arrête là. Tout le reste appartient au prototype et aux tests praticiens, pas à ce document.

---

## Contraintes non négociables (CLAUDE.md — AI Principles)

> "AI assists. AI prepares. AI summarizes. AI recommends. AI highlights. AI never owns clinical
> decisions. The practitioner remains responsible."

- La transcription et la synthèse proposée sont **toujours** une proposition, jamais une écriture
  automatique dans le dossier — validation explicite du praticien, non contournable.
- Option **opt-in**, jamais activée par défaut (cohérent avec PP-009).
- Rétention des données audio/transcrites : question Consent/Trust Platform, hors scope de ce PDX,
  à trancher en Engineering si le prototype est validé.
- Rattachement architectural probable : capacité consommée par WS-003, pas une nouvelle Plateforme —
  "AI" figure parmi les Plateformes futures de CLAUDE.md, mais "Build Clinical First" reste la règle.

---

## Prototype

Oui.

## Blueprint

Non — et ne le sera jamais directement (RG-002, RG-003).

## Statut

Discovery (PDX).

```
PDX-001 (ici)
    ↓
Prototype exploratoire — capture audio + transcription + extraction, sur un sous-ensemble de profils
    ↓
Tests praticiens — au minimum les profils couverts par TEN-D-001/002 (F001/F009, F002/F004)
    ↓
Validation / Rejet — RG-004 : un rejet n'a aucun impact sur le reste du produit
    ↓ (si validé uniquement)
PDR → candidat Product Principle (prochain identifiant libre : PP-016)
```

---

## Évolution

| Version | Date | Nature |
|---|---|---|
| 0.1 | 2026-08-04 | Innovation Hypothesis initiale (IH-001) — premier cas d'usage du circuit Innovation. |
| 0.2 | 2026-08-04 | Renommée PDX-001 suite au renommage GOV-000 v1.4 (Innovation → Product Discovery). Reformatée au gabarit PDX officiel. Contenu inchangé sur le fond. |
| 0.3 | 2026-08-04 | Scindée entre WS-003 (capture audio, modalité Mode Capture) et WS-004 (transcription/extraction/synthèse, responsabilité de persistance) suite à [WBD-004](../workspaces/WBD-004-consultation-vs-documentation.md) v2.0. L'hypothèse elle-même est inchangée — seule son rattachement à un ou deux Workspaces est clarifié. |
