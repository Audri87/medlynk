# WBD-004 — WS-003 (Consultation) vs WS-004 (nom provisoire : Clinical Continuity)

| Field | Value |
|---|---|
| ID | WBD-004 |
| Version | 2.1 |
| Status | **RESOLVED — par analyse de responsabilité, pas par nouvelle preuve corpus** |
| Date | 2026-08-04 |
| Nature | Artefact GOV-000 §5/§6 — Workspace Boundary Decision |
| Workspaces concernés | WS-003 — Consultation (Gold Standard, v2.5) · WS-004 — renommage proposé, **nom à confirmer** (voir §Collision de nommage) |
| Origine | v1.0 : audit critique de [PDR-004](PDR-004-documentation.md). v2.0 : reprise complète — l'utilisateur a identifié que la question posée en v1.0 était mal formée. |

> **Ce qui a changé entre v1.0 et v2.0.** La v1.0 cherchait "quel comportement de documentation
> WS-004 possède-t-il que WS-003 ne possède pas" — une question de comportement observé, qui nous
> renvoyait sans cesse vers un corpus qui ne pouvait pas trancher (evidence trop faible sur tous les
> axes testés). La bonne question était différente : **"quelle responsabilité produit manque dans la
> Clinical Loop, indépendamment de ce que montre le corpus ?"** Une question d'architecture produit,
> pas de comportement. C'est ce changement de nature de la question qui résout ce WBD — pas une
> nouvelle donnée.

---

## La Clinical Loop et le trou identifié

```
WS-001 — Je commence ma journée
    ↓
WS-002 — Je retrouve le contexte
    ↓
WS-003 — Je soigne le patient
    ↓
   ???
    ↓
WS-005 — Je partage
    ↓
WS-006 — Je termine
```

Le trou n'est pas *"j'écris."* WS-003 (Mode Clôture) écrit déjà — il produit note, prescription,
orientation, examen, RDV (WS-003 §9). Le trou est : **"je transforme ce qui vient de se passer en
quelque chose d'exploitable demain."** C'est une responsabilité produit, distincte de l'acte de capture
lui-même.

---

## Verdict : RESOLVED

**Répartition des responsabilités, trois Workspaces, un seul flux de mémoire clinique :**

| Workspace | Responsabilité | Sens du flux |
|---|---|---|
| **WS-003** — Consultation | Capturer, dans l'instant, sans interrompre l'attention (PP-009/010/012/013) | **Écriture — moment** |
| **WS-004** — nom à confirmer | Transformer la capture brute en mémoire clinique fiable, structurée, réutilisable **— pour soi-même** | **Écriture — persistance** |
| **WS-002** — Patient Context | Lire cette mémoire clinique pour reconstruire le contexte avant la prochaine consultation (Bloc Continuité) | **Lecture** |
| **WS-005** — nom candidat *Clinical Coordination* (contesté, voir [WE-005](WE-005-information-flow.md) §9) | Partager l'information entre acteurs du parcours (transmission, avis, délégation, reprise de patient) — **acte distinct et conditionnel**, jamais fondu dans la production de WS-004 | **Lecture (de la mémoire WS-004) + Écriture (canal externe) — ⚠ store de sortie non précisé**, mais la nature à deux temps du flux est désormais évidencée (voir note AR-001 ci-dessous) |
| **WS-006** — *"Je termine"* | Clore la journée (voir WS-003 §11, rappel de fin de journée) | **Lecture — ⚠ non spécifié** (aucun Blueprint WS-006 à ce jour ; statut `Research Workspace` au sens GOV-000 §4) |

Ajout 2026-08-06 (Sprint M1.1 — Consolidation, réponse à la Critique 3/Q3 de la revue d'architecture
M1) : cette table listait à l'origine seulement WS-002/003/004. WS-005 et WS-006 sont des nœuds de la
même Clinical Loop (voir diagramme ci-dessus) et n'avaient jamais reçu de Sens du flux déclaré — la
revue d'architecture a signalé que cette absence empêchait d'exclure un cycle de dépendance. Les deux
lignes ajoutées documentent l'état réel des connaissances (incomplet, marqué ⚠), pas une réponse
définitive.

**Correction 2026-08-06 (AR-001 Finding-004).** La ligne WS-004 disait *"pour soi-même et pour
d'autres"* — formulation non soutenue par le corpus. ACT-F002-019/021, ACT-F005-013/016 et
ACT-F009-025/026 montrent systématiquement **deux ACT distincts et séquentiels** (finaliser la
mémoire, puis — de façon *conditionnelle* pour F002 — la transmettre), jamais un seul acte fondu.
ACT-F004 (profil entier, 17 ACT) exerce la construction de mémoire durable sans qu'aucun acte de
transmission n'apparaisse. *"Pour d'autres"* est retiré du mandat de WS-004 et reste la propriété
exclusive de WS-005. Ceci ne fusionne pas WS-004/WS-005 (hypothèse envisagée puis rejetée par la même
preuve — voir REV-001) ; ceci clarifie que WS-005 *lit* la mémoire produite par WS-004 pour décider
quoi partager, puis écrit vers un canal de sortie encore non précisé — probablement distinct du store
que WS-002 consulte, ce qui réduit sans l'éliminer totalement le risque de dépendance circulaire signalé
en Q3.

WS-003 et WS-004 ne sont donc pas deux Workspaces qui font "la même chose à des moments différents"
(l'erreur de la v1.0 de ce WBD) — ce sont deux responsabilités différentes : **capturer** n'est pas
**préserver**. WS-002 est le miroir en lecture de ce que WS-004 produit en écriture — exactement
comme WS-003 et WS-004 sont miroir écriture/écriture à deux moments différents.

**Ce qui bascule de WS-003 vers WS-004, précisément :** rien de ce qui est déjà gelé (PP-009 à PP-015
restent intacts, propriété exclusive de WS-003 — capture pendant l'instant). Ce qui revient à WS-004 :
tout ce qui arrive **après** la capture brute — structuration, extraction, fiabilisation, mise à
disposition future. La frontière n'est plus temporelle (pendant/après consultation, déjà réglée par
PP-013) mais **fonctionnelle** (capturer / préserver).

**PDX-001 se scinde naturellement le long de cette frontière** — ce n'était pas visible avant cette
résolution :
- *Capture audio* (l'enregistrement lui-même, pendant/juste après la consultation) → reste une
  modalité candidate de **WS-003** Mode Capture, au même titre que le texte libre.
- *Transcription → Extraction → Synthèse IA → Validation* → relève de **WS-004** — c'est très
  exactement la responsabilité "transformer une capture brute en mémoire exploitable."

---

## Collision de nommage — à trancher explicitement avant tout Blueprint

**"Clinical Memory" entre en collision directe avec un concept déjà défini dans CLAUDE.md :**

> "Care Record is Clinical Memory. Responsibilities: Store clinical information, history, observations,
> prescriptions, attachments, results. Care Record never orchestrates workflows."

Care Record est un concept de **Domain** (Clinical Platform) — un magasin de données, pas une
Projection. WS-004, lui, serait un **Workspace** (Projection UX, computée, jamais stockée — principe
"Workspace = Projection" de CLAUDE.md). Nommer WS-004 "Clinical Memory" ferait coexister deux choses
différentes sous un nom identique : le magasin (Care Record, Domain) et l'expérience qui alimente ce
magasin (WS-004, Projection). Risque réel de confusion en Engineering (quel "Clinical Memory" un
ticket référence-t-il ?) et en Product (le Workspace ne doit jamais laisser croire qu'il EST la donnée
— CLAUDE.md : "Care Record never orchestrates workflows", et Workspaces ne stockent rien).

**Recommandation : "Clinical Continuity"** plutôt que "Clinical Memory" :
- Aucune collision avec un concept déjà gelé.
- Se raccroche naturellement au vocabulaire déjà en usage dans WS-002 (Bloc **Continuité**, métrique
  **Context Confidence**) — WS-002 lit la continuité, WS-004 l'écrit. Le nom rend la paire visible.
- "Clinical Reconstruction" (l'autre option proposée) a l'inconvénient inverse de "Documentation" :
  il décrit une opération (reconstruire) plutôt qu'une responsabilité (préserver pour l'usage futur) —
  moins bon candidat que Continuity à ce titre.

**Ce nom n'est pas figé par ce document.** WBD-004 tranche la *responsabilité* et la *frontière* — pas
le nom final. Le nom devient définitif au moment où le Blueprint WS-004 est rédigé (Gate 2). Jusque-là,
ce document utilise "WS-004" et évite "Documentation" et "Clinical Memory".

---

## Réservation de scope pour le futur Blueprint (pas du scope creep — RG-004/RG-001 respectées)

Le porteur produit a proposé une esquisse de section Blueprint à réserver, pas à construire au MVP :

```
Memory Capture
  Current
    ✓ Texte
    ✓ Mots-clés
    ✓ Pièces jointes
  Future
    □ Capture audio
    □ Transcription
    □ Résumé IA
    □ Extraction des événements cliniques
```

Chaque ligne "Future" doit passer par son propre PDX avant de devenir Current — voir
[PDX-001](../discovery/PDX-001-capture-clinique-assistee.md) pour la ligne "Capture audio → Transcription
→ Résumé IA". Cette table n'autorise aucune implémentation directe ; elle documente qu'une place est
prévue, conformément à GOV-000 RG-002/RG-003.

---

## Ce qui reste ouvert pour le Blueprint (pas bloquant pour ce WBD)

Les quatre sous-questions de la v1.0 de ce document ne bloquent plus la frontière (résolue ci-dessus)
mais restent utiles pour informer le contenu du futur Blueprint :

| # | Question | Alimente |
|---|---|---|
| OQ-WBD-004-1 | ~~Un praticien distingue-t-il "écrire pour moi" et "écrire pour quelqu'un d'autre" ?~~ **Résolue (AR-001 Finding-004, 2026-08-06)** — oui : ACT-F002-019/021 codent ces deux actes séparément, avec l'envoi marqué "conditionnel". | Structure de la mémoire clinique — deux actes, un seul objet mémoire (WS-004), une sortie conditionnelle distincte (WS-005) |
| OQ-WBD-004-2 | Pourquoi F001 ne documente jamais et F009 documente intensément (TEN-D-001) ? | Design des stratégies de capture (§Memory Capture ladder) — combien en proposer par défaut |
| OQ-WBD-004-3 | Pourquoi F002 et F004 divergent sur la prise de notes en temps réel (TEN-D-002) ? | Idem — calibration par profil, probable UX Constraint plutôt que blocage |
| OQ-WBD-004-4 | ~~D'autres profils que F009 transmettent-ils activement de l'information à d'autres praticiens ?~~ **Résolue (AR-001 Finding-004, 2026-08-06)** — oui : F002 (patient) et F005 (médecin prescripteur) transmettent également, chacun via un ACT distinct de la production de mémoire. | Interface WS-004 → WS-005 (partage) — périmètre confirmé, retiré du mandat de WS-004 |

---

## Évolution

| Version | Date | Nature |
|---|---|---|
| 1.0 | 2026-08-04 | WBD initial — reclassement de DD-401 (PDR-004) suite à audit critique. Verdict UNRESOLVED — question posée en termes de comportement, insuffisamment tranchable par le corpus disponible. |
| 2.1 | 2026-08-06 | **AR-001 Finding-004.** Retrait de "et pour d'autres" du mandat de WS-004 — non soutenu par le corpus (ACT-F002-019/021, ACT-F005-013/016, ACT-F009-025/026 : deux ACT distincts et séquentiels, jamais un seul ; ACT-F004, profil entier, exerce la mémoire durable sans aucune transmission). OQ-WBD-004-1 et OQ-WBD-004-4 résolues. Hypothèse de fusion WS-004/WS-005 (REV-001) examinée puis rejetée par la même preuve. |
| 2.0 | 2026-08-04 | Reprise complète suite à un changement de perspective : la question posée en v1.0 était mal formée (comportement vs responsabilité). Verdict **RESOLVED** par analyse de la Clinical Loop, pas par nouvelle preuve corpus. Frontière fonctionnelle établie : WS-003 capture (moment), WS-004 préserve (persistance), WS-002 lit (continuité). Collision de nommage "Clinical Memory" / Care Record identifiée et documentée — "Clinical Continuity" recommandé, décision finale renvoyée au Blueprint. PDX-001 scindé entre WS-003 (capture audio) et WS-004 (transcription/extraction/synthèse). Section "Memory Capture" (Current/Future) actée comme réservation de scope, pas comme implémentation. |
