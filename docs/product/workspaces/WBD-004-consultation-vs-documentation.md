# WBD-004 — WS-003 (Consultation) vs WS-004 (nom provisoire : Clinical Continuity)

| Field | Value |
|---|---|
| ID | WBD-004 |
| Version | 2.3 |
| Status | **Verdict WBD (`GOV-000` v1.8 §5) : NO-WORKSPACE** pour la question "WS-004 est-il un Workspace" ; **RESOLVED, inchangé**, pour la frontière WS-003/WS-005 (AR-001 Finding-004, §Verdict). Aucun changement de statut de cycle de vie (`ADR-0021`) — ce WBD n'en portait aucun. |
| Date | 2026-08-04 (Erratum : 2026-09-08 ; Amendement/delta documentaire : 2026-09-09) |
| Nature | Artefact GOV-000 §5/§6 — Workspace Boundary Decision |
| Workspaces concernés | WS-003 — Consultation (Gold Standard, v2.5) · WS-004 — **NO-WORKSPACE** au sens de WSP-001 ; la responsabilité identifiée reste réelle mais n'est plus portée par un Workspace (voir Erratum et Amendement 2026-09-09) |
| Origine | v1.0 : audit critique de [PDR-004](PDR-004-documentation.md). v2.0 : reprise complète — l'utilisateur a identifié que la question posée en v1.0 était mal formée. v2.2 : Erratum suite à [ADR-0024](../../adr/ADR-0024-ws004-nature-et-proof-set-m2.md). v2.3 : delta documentaire minimal suite à la clôture du Reconstruction Audit du Clinical Loop ([OBS-M2-013](../M2-JOURNAL-observations.md)). |

> **Ce qui a changé entre v1.0 et v2.0.** La v1.0 cherchait "quel comportement de documentation
> WS-004 possède-t-il que WS-003 ne possède pas" — une question de comportement observé, qui nous
> renvoyait sans cesse vers un corpus qui ne pouvait pas trancher (evidence trop faible sur tous les
> axes testés). La bonne question était différente : **"quelle responsabilité produit manque dans la
> Clinical Loop, indépendamment de ce que montre le corpus ?"** Une question d'architecture produit,
> pas de comportement. C'est ce changement de nature de la question qui résout ce WBD — pas une
> nouvelle donnée.

---

> ## ⚠ Erratum — 2026-09-08 ([ADR-0024](../../adr/ADR-0024-ws004-nature-et-proof-set-m2.md))
>
> Ce qui suit **précise** le verdict RESOLVED ci-dessous, il ne le rouvre pas et ne le supprime pas.
> Le texte original de v2.1 est conservé tel quel plus bas, avec des renvois ponctuels vers cet
> erratum aux endroits concernés.
>
> **Ce qui reste vrai, inchangé** : la responsabilité identifiée — *transformer la capture brute de
> WS-003 en mémoire clinique fiable, structurée, réutilisable, pour soi-même* — reste valide. Rien
> dans l'audit du 2026-09-08 ne l'a remise en cause. Ce qui bascule de WS-003 vers cette responsabilité
> (structuration, extraction, fiabilisation, mise à disposition future) reste inchangé.
>
> **Ce qui change** : la falsification menée le 2026-09-08 (challenge WS-003/WS-004, puis audit
> falsificateur documenté dans [OBS-M2-013](../M2-JOURNAL-observations.md)) n'a identifié **aucune
> responsabilité Actor-facing** — aucune activité cognitive, décisionnelle ou opérationnelle du
> praticien — distincte de WS-003 sur les scénarios testés. Les deux pistes cherchées activement pour
> trouver une telle responsabilité (G1/Clinical Authorization, PDX-001) n'ont pas renversé ce constat :
> G1 est un comportement de domaine (`HR-001`, *"Domain Behaviour"*, résolu par *"Strategic Design"*),
> pas une responsabilité de Workspace ; PDX-001 contient une exigence de validation Actor-facing réelle
> mais **conditionnelle** à une capacité elle-même non démontrée, jamais prototypée, jamais testée
> (`Discovery (PDX)`).
>
> Or [WSP-001](../../workspace/WSP-001-workspace.md) définit un Workspace comme une projection
> *"assemblée pour un Actor"*, et exclut explicitement qu'un Workspace soit *"un Application Service."*
> **À l'état actuel et démontré du corpus, WS-004 ne satisfait donc pas la définition normative de
> Workspace.** Ce n'est pas une nouvelle responsabilité qui est retirée — c'est l'étiquette "Workspace"
> posée sur une responsabilité par ailleurs toujours valide, en l'absence de toute UX Actor-facing
> démontrée pour la porter.
>
> **Conséquence actée** ([ADR-0024](../../adr/ADR-0024-ws004-nature-et-proof-set-m2.md), Option A) :
> WS-004 est retiré du proof set M2 ([ADR-0022](../../adr/ADR-0022-m2-freeze-protocol.md) §2, v1.1),
> remplacé par WS-006 — explicitement **pas** comme remplacement fonctionnel (WS-006 ne porte pas la
> responsabilité de persistance/structuration ; il est inclus parce qu'il satisfait, lui, le critère
> Workspace). La responsabilité identifiée par ce document devient, jusqu'à preuve contraire, une
> **responsabilité architecturale interne** (persistance/structuration, potentiellement un traitement
> asynchrone) plutôt qu'un Workspace — sans qu'aucune nouvelle responsabilité ne lui soit inventée à
> cette occasion.
>
> **Ce qui n'est pas tranché ici** : la forme UX que prendrait une éventuelle validation liée à
> PDX-001, si sa capacité sous-jacente est un jour démontrée — explicitement laissé ouvert, ne pas
> anticiper. La question de gouvernance plus large (faut-il une catégorie normative "Application
> Service interne" distincte de Workspace/Research Workspace ?) est un chantier séparé (`GOV-000`),
> non traité par cet erratum.

---

> ## ⚠ Amendement — 2026-09-09 (delta documentaire minimal — clôture du Reconstruction Audit)
>
> Cet amendement **applique** l'Erratum du 2026-09-08 ci-dessus : il ne rouvre ni ne modifie son
> constat, il en tire les conséquences documentaires précises, clause par clause, suite au
> Reconstruction Audit du Clinical Loop ([OBS-M2-013](../M2-JOURNAL-observations.md), clôture) et à la
> demande explicite d'un delta minimal, sans réécriture historique.
>
> **Verdict WBD mis à jour** (vocabulaire `GOV-000` v1.8 §5) : le champ Status en tête de document passe
> de RESOLVED à **NO-WORKSPACE** pour la question "WS-004 est-il un Workspace" — la question pour
> laquelle ce document a été rouvert le 2026-09-08. La frontière WS-003/WS-005 (AR-001 Finding-004,
> §Verdict ci-dessous) n'est pas concernée par ce changement et reste RESOLVED, inchangée.
>
> **Ce que l'audit a établi, que ce document ignorait à sa rédaction (2026-08-04/06) — antérieure de
> plus d'un mois à [CAL-001](../../clinical/CAL-001-clinical-activity-lifecycle.md)** : la
> responsabilité que ce WBD cherchait à faire porter par un futur "WS-004" n'est pas une responsabilité
> produit en attente d'un porteur — c'est un **Domain Behaviour déjà normatif et Accepted** :
> - [CAL-001](../../clinical/CAL-001-clinical-activity-lifecycle.md) Phase 5 (*Formalization*) et
>   Phase 6 (*Contribution*) couvrent exactement "transformer ce qui vient de se passer en quelque
>   chose d'exploitable" — sans qu'aucun Workspace intermédiaire ne soit requis pour l'exercer.
> - [ADR-0008](../../adr/ADR-0008-clinical-work-and-clinical-knowledge.md) établit un chemin d'écriture
>   direct Clinical Work → Clinical Knowledge, sans objet intermédiaire, et qualifie "Context
>   Reconstruction" d'Application Service (pas un concept de domaine) — ce qui confirme que WS-002 lit
>   directement ce que WS-003 écrit, sans porteur séparé entre les deux.
> - [ADR-0010](../../adr/ADR-0010-care-record.md) exclut explicitement de Care Record la production de
>   Clinical Contributions et tout mécanisme de persistance technique ("belongs to architecture, not to
>   the domain model") — ce qui corrige l'inférence de la section Collision de nommage ci-dessous : il
>   n'y a pas de second objet Domain/Projection à distinguer de Care Record, seulement une capacité
>   d'ingénierie.
> - [HR-001](../../HR-001-hotspot-register-v1.md) H-G1 (*Publication & Visibility Rules*, Open,
>   catégorisé *"Domain Behaviour"*, résolution attendue = *Strategic Design*) reste le **seul écart
>   réellement ouvert** identifié par l'audit — un comportement de domaine, pas une responsabilité de
>   Workspace.
>
> **Corrections clause par clause apportées au texte v2.1 ci-dessous** (annotations ⚠ ponctuelles
> insérées in situ à cette date, texte original v2.1 toujours visible, rien supprimé) :
> - *"responsabilité produit"* (§Clinical Loop et le trou identifié) → Domain Behaviour déjà résolu
>   (CAL-001 Ph.5-6), pas une responsabilité en attente d'un porteur.
> - *"miroir écriture/écriture"* WS-003/WS-004 (§Verdict) → ne peut pas tenir entre un Workspace réel
>   et un objet NO-WORKSPACE ; la distinction capturer ≠ préserver reste vraie, sa formulation en
>   miroir de deux Workspaces ne l'est plus.
> - *"Ce qui bascule de WS-003 vers WS-004"* (§Verdict) → structuration/extraction = capacité
>   Engineering (hypothétique, conditionnelle à PDX-001) ; fiabilisation/validation = Domain Behaviour
>   déjà couvert par CAL-I-003 ; mise à disposition future = Domain Behaviour ouvert, exactement
>   HR-001 H-G1.
> - *"relève de WS-004"* (§PDX-001 se scinde naturellement) → Transcription/Extraction/Synthèse IA =
>   Engineering capability consommée par WS-003 ; Validation = Domain Behaviour déjà normatif
>   (CAL-I-003), pas une nouveauté apportée par PDX-001.
> - *"Le nom devient définitif au moment où le Blueprint WS-004 est rédigé (Gate 2)"* (§Collision de
>   nommage) → un verdict NO-WORKSPACE ne produit jamais de Blueprint (`GOV-000` v1.8 §5) ; cette
>   phrase ne se réalisera pas.
>
> **Ce qui reste valide sans changement** : la frontière WS-003/WS-005 (AR-001 Finding-004, deux ACT
> distincts et séquentiels) ; la table Memory Capture Current/Future dans son contenu (sa case
> d'atterrissage change : elle vise désormais une capacité Engineering consommée par WS-003, pas un
> futur Blueprint WS-004) ; les quatre OQ-WBD-004 (elles informent désormais WS-003/Engineering, et
> non plus un futur Blueprint WS-004 qui n'existera pas).
>
> **Ce que cet amendement ne fait pas** : il ne renomme pas ce document ; il n'en change pas le statut
> de cycle de vie (`ADR-0021` — ce WBD ne portait de toute façon aucun statut Draft/Frozen/Historical,
> seulement un verdict `GOV-000` §5, désormais NO-WORKSPACE) ; il n'invente aucune nouvelle
> responsabilité ni aucun nouveau Workspace ; il n'anticipe pas la forme future de PDX-001 — inchangé
> depuis l'Erratum du 2026-09-08.

---

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
lui-même. *(⚠ voir Amendement 2026-09-09 : ce n'est pas une responsabilité produit en attente d'un
porteur, c'est un Domain Behaviour déjà normatif — CAL-001 Phase 5/6.)*

---

## Verdict : RESOLVED (frontière WS-003/WS-005) — NO-WORKSPACE (nature de WS-004, voir Amendement 2026-09-09)

**Répartition des responsabilités, trois Workspaces, un seul flux de mémoire clinique :**
*(texte original v2.1 conservé tel quel — ⚠ la ligne WS-004 est amendée par l'Erratum 2026-09-08 et
l'Amendement 2026-09-09 ci-dessus : la responsabilité tient, redistribuée entre Domain Behaviour
(CAL-001 Ph.5-6, HR-001 H-G1) et capacité Engineering conditionnelle à PDX-001 ; la qualification
"Workspace" ne tient plus, verdict NO-WORKSPACE)*

| Workspace | Responsabilité | Sens du flux |
|---|---|---|
| **WS-003** — Consultation | Capturer, dans l'instant, sans interrompre l'attention (PP-009/010/012/013) | **Écriture — moment** |
| **WS-004** ⚠ — nom à confirmer, **plus un Workspace démontré** (voir Erratum) | Transformer la capture brute en mémoire clinique fiable, structurée, réutilisable **— pour soi-même** | **Écriture — persistance** |
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

**Correction 2026-09-09 (Amendement — delta documentaire).** La table ci-dessus, dans sa ligne WS-004,
continue de nommer un Workspace là où le verdict est désormais NO-WORKSPACE. La responsabilité qu'elle
décrit ("transformer la capture brute...") ne disparaît pas : elle se redistribue entre CAL-001 Ph.5-6
(Formalization/Contribution, Domain Behaviour déjà Accepted), HR-001 H-G1 (mise à disposition future,
Domain Behaviour ouvert) et une capacité Engineering conditionnelle à PDX-001 (structuration,
extraction). Cette correction ne modifie pas la ligne WS-002/WS-005/WS-006, ni la frontière WS-003/
WS-005 établie par AR-001 Finding-004 ci-dessus, qui reste RESOLVED.

WS-003 et WS-004 ne sont donc pas deux Workspaces qui font "la même chose à des moments différents"
(l'erreur de la v1.0 de ce WBD) — ce sont deux responsabilités différentes : **capturer** n'est pas
**préserver**. WS-002 est le miroir en lecture de ce que WS-004 produit en écriture — exactement
comme WS-003 et WS-004 sont miroir écriture/écriture à deux moments différents. *(⚠ voir Amendement
2026-09-09 : la formulation "miroir écriture/écriture" entre deux Workspaces ne tient plus — WS-004
n'est pas un Workspace. La distinction capturer ≠ préserver reste vraie ; ADR-0008 explique par
ailleurs pourquoi WS-002 lit directement ce que WS-003 écrit, sans porteur intermédiaire.)*

**Ce qui bascule de WS-003 vers WS-004, précisément :** rien de ce qui est déjà gelé (PP-009 à PP-015
restent intacts, propriété exclusive de WS-003 — capture pendant l'instant). Ce qui revient à WS-004 :
tout ce qui arrive **après** la capture brute — structuration, extraction, fiabilisation, mise à
disposition future. La frontière n'est plus temporelle (pendant/après consultation, déjà réglée par
PP-013) mais **fonctionnelle** (capturer / préserver). *(⚠ voir Amendement 2026-09-09 : cette liste ne
revient plus à "WS-004" — structuration/extraction sont une capacité Engineering conditionnelle à
PDX-001 ; fiabilisation/validation relèvent déjà de CAL-I-003 ; mise à disposition future est le
Domain Behaviour ouvert HR-001 H-G1.)*

**PDX-001 se scinde naturellement le long de cette frontière** — ce n'était pas visible avant cette
résolution :
- *Capture audio* (l'enregistrement lui-même, pendant/juste après la consultation) → reste une
  modalité candidate de **WS-003** Mode Capture, au même titre que le texte libre.
- *Transcription → Extraction → Synthèse IA → Validation* → relève de **WS-004** — c'est très
  exactement la responsabilité "transformer une capture brute en mémoire exploitable." *(⚠ voir
  Amendement 2026-09-09 : Transcription/Extraction/Synthèse IA = capacité Engineering consommée par
  WS-003, pas "WS-004" ; Validation = CAL-I-003, déjà normatif, pas une nouveauté de PDX-001.)*

---

## Collision de nommage — à trancher explicitement avant tout Blueprint

**"Clinical Memory" entre en collision directe avec un concept déjà défini dans CLAUDE.md :**

> "Care Record is Clinical Memory. Responsibilities: Store clinical information, history, observations,
> prescriptions, attachments, results. Care Record never orchestrates workflows."

Care Record est un concept de **Domain** (Clinical Platform) — un magasin de données, pas une
Projection. WS-004, lui, serait un **Workspace** (Projection UX, computée, jamais stockée — principe
"Workspace = Projection" de CLAUDE.md) *(⚠ affirmation datée de v2.1 — voir Erratum 2026-09-08 :
WS-004 n'est plus démontré comme Workspace à l'état actuel du corpus ; s'il reste une responsabilité
architecturale interne, cette collision de nommage avec Care Record reste pertinente à surveiller,
juste pour une autre catégorie d'objet)*. Nommer WS-004 "Clinical Memory" ferait coexister deux choses
différentes sous un nom identique : le magasin (Care Record, Domain) et l'expérience qui alimente ce
magasin (WS-004, Projection). Risque réel de confusion en Engineering (quel "Clinical Memory" un
ticket référence-t-il ?) et en Product (le Workspace ne doit jamais laisser croire qu'il EST la donnée
— CLAUDE.md : "Care Record never orchestrates workflows", et Workspaces ne stockent rien).

*(⚠ voir Amendement 2026-09-09 : [ADR-0010](../../adr/ADR-0010-care-record.md) exclut explicitement de
Care Record la production de Clinical Contributions et tout mécanisme de persistance technique
("belongs to architecture, not to the domain model") — il n'y a donc pas un second objet
Domain/Projection à distinguer de Care Record, seulement une capacité d'ingénierie. Le risque de
collision de nommage décrit ci-dessus reste réel mais change de nature : ce n'est plus deux Domain vs.
Projection à distinguer, c'est Care Record (Domain) vs. une capacité Engineering sans nom de Workspace.)*

**Recommandation : "Clinical Continuity"** plutôt que "Clinical Memory" :
- Aucune collision avec un concept déjà gelé.
- Se raccroche naturellement au vocabulaire déjà en usage dans WS-002 (Bloc **Continuité**, métrique
  **Context Confidence**) — WS-002 lit la continuité, WS-004 l'écrit. Le nom rend la paire visible.
- "Clinical Reconstruction" (l'autre option proposée) a l'inconvénient inverse de "Documentation" :
  il décrit une opération (reconstruire) plutôt qu'une responsabilité (préserver pour l'usage futur) —
  moins bon candidat que Continuity à ce titre.

**Ce nom n'est pas figé par ce document.** WBD-004 tranche la *responsabilité* et la *frontière* — pas
le nom final. Le nom devient définitif au moment où le Blueprint WS-004 est rédigé (Gate 2). Jusque-là,
ce document utilise "WS-004" et évite "Documentation" et "Clinical Memory". *(⚠ voir Amendement
2026-09-09 : un verdict NO-WORKSPACE ne produit jamais de Blueprint — `GOV-000` v1.8 §5. Cette phrase
ne se réalisera pas ; "WS-004" reste une trace historique de la question posée, pas un nom en attente
de confirmation.)*

---

## Réservation de scope pour le futur Blueprint (pas du scope creep — RG-004/RG-001 respectées)

*(⚠ voir Amendement 2026-09-09 : cette réservation ne vise plus un futur "Blueprint WS-004" — qui
n'existera pas, NO-WORKSPACE oblige — mais une capacité Engineering candidate, consommée par WS-003.
Le contenu ci-dessous reste valide tel quel ; seule la case d'atterrissage change.)*

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

*(⚠ voir Amendement 2026-09-09 : "le futur Blueprint" dans le titre et la colonne "Alimente"
ci-dessous doit se lire désormais comme WS-003/Engineering — il n'y aura pas de Blueprint WS-004.
Les quatre questions et leur statut de résolution restent valides sans changement.)*

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
| 2.3 | 2026-09-09 | **Amendement — delta documentaire minimal**, suite à la clôture du Reconstruction Audit du Clinical Loop (OBS-M2-013). Verdict WBD mis à jour : RESOLVED → **NO-WORKSPACE** (`GOV-000` v1.8 §5) pour la question "WS-004 est-il un Workspace" ; la frontière WS-003/WS-005 (AR-001 Finding-004) reste RESOLVED, inchangée. Corrections clause par clause (annotations ⚠ in situ, texte v2.1 préservé) : "responsabilité produit" → Domain Behaviour déjà résolu (CAL-001 Ph.5-6) ; "miroir écriture/écriture" WS-003/WS-004 → retiré, distinction capturer/préserver conservée ; "ce qui bascule vers WS-004" → redistribué entre CAL-001 Ph.5-6/CAL-I-003 (Domain Behaviour), HR-001 H-G1 (Domain Behaviour ouvert) et capacité Engineering conditionnelle à PDX-001 ; "relève de WS-004" (scission PDX-001) → idem ; "Blueprint WS-004 rédigé (Gate 2)" → ne se réalisera pas, NO-WORKSPACE n'a pas de Blueprint. Références ajoutées : CAL-001, ADR-0008, ADR-0010, HR-001 H-G1. Aucun renommage du document, aucun changement de statut de cycle de vie (`ADR-0021`), aucune nouvelle responsabilité inventée, forme future de PDX-001 non anticipée. "WS-004" conservé comme trace historique de la question posée. |
| 2.2 | 2026-09-08 | **Erratum, pas une réouverture.** Suite à ADR-0024 (OBS-M2-013, audit falsificateur) : la responsabilité de persistance/structuration reste valide et inchangée ; la qualification "Workspace" de WS-004 est retirée à l'état actuel du corpus, faute de responsabilité Actor-facing démontrée (WSP-001). WS-004 devient une responsabilité architecturale interne, sans nouvelle responsabilité inventée. WS-004 retiré du proof set M2 (ADR-0022 v1.1), remplacé par WS-006 — explicitement pas comme remplacement fonctionnel. Deux annotations ponctuelles ajoutées dans le texte v2.1 (table des responsabilités, section Collision de nommage), texte original conservé. Question ouverte, non tranchée : forme UX future si PDX-001 est un jour validé. |
| 2.1 | 2026-08-06 | **AR-001 Finding-004.** Retrait de "et pour d'autres" du mandat de WS-004 — non soutenu par le corpus (ACT-F002-019/021, ACT-F005-013/016, ACT-F009-025/026 : deux ACT distincts et séquentiels, jamais un seul ; ACT-F004, profil entier, exerce la mémoire durable sans aucune transmission). OQ-WBD-004-1 et OQ-WBD-004-4 résolues. Hypothèse de fusion WS-004/WS-005 (REV-001) examinée puis rejetée par la même preuve. |
| 2.0 | 2026-08-04 | Reprise complète suite à un changement de perspective : la question posée en v1.0 était mal formée (comportement vs responsabilité). Verdict **RESOLVED** par analyse de la Clinical Loop, pas par nouvelle preuve corpus. Frontière fonctionnelle établie : WS-003 capture (moment), WS-004 préserve (persistance), WS-002 lit (continuité). Collision de nommage "Clinical Memory" / Care Record identifiée et documentée — "Clinical Continuity" recommandé, décision finale renvoyée au Blueprint. PDX-001 scindé entre WS-003 (capture audio) et WS-004 (transcription/extraction/synthèse). Section "Memory Capture" (Current/Future) actée comme réservation de scope, pas comme implémentation. |
| 1.0 | 2026-08-04 | WBD initial — reclassement de DD-401 (PDR-004) suite à audit critique. Verdict UNRESOLVED — question posée en termes de comportement, insuffisamment tranchable par le corpus disponible. |
