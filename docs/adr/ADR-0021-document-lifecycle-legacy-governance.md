# ADR-0021 — Document Lifecycle & Legacy Governance

**Statut** : Accepted
**Date** : 2026-08-06
**Répond à** : [M2-AR-001](../M2-AR-001-product-governance-reconciliation-audit.md) (Product Governance
Reconciliation Audit)
**Ne modifie** : aucun document existant, aucune Constitution, aucun Blueprint, aucune Mission, aucun
Workspace. Cet ADR définit une politique générale, applicable à tout document présent ou futur.

---

## Contexte

M2-AR-001 a cartographié `docs/product/` sans trancher aucun conflit — c'était son mandat explicite.
Il en résulte douze documents au statut `Unknown`, plusieurs documents auto-déclarés "Constitution",
et plusieurs chaînes méthodologiques non réconciliées. Aucune de ces situations ne peut être traitée
tant qu'il n'existe pas de politique commune définissant ce que signifie chaque statut, qui a le
droit de le changer, et comment un statut indéterminé doit être traité en attendant sa résolution.

Cet ADR est cette politique. Il ne l'applique à aucun document nommément.

---

## Décision

### 1. États possibles d'un document

| État | Définition | Force normative |
|---|---|---|
| **Draft** | En cours de rédaction. N'a pas encore été déclaré référence sur son sujet. | Aucune — informatif seulement |
| **Active** | Référence courante sur son sujet. Évolue par versionnement normal (ADR-0017). | Normatif |
| **Experimental** | Hypothèse en test, protocole de sortie explicite non conclu (ADR-0017). | Non normatif — ne peut jamais fonder une décision sans réserve (ADR-0016) |
| **Frozen** | Active et explicitement protégé — modification impossible sans protocole d'évolution dédié (ADR-0017). | Normatif, renforcé |
| **Superseded** | Un document désigné et postérieur a formellement pris sa place sur la même question. | Non normatif — le successeur fait foi |
| **Deprecated** | Signalé comme ne devant plus servir de base à une nouvelle décision, **sans** qu'un successeur n'ait encore été désigné. | Non normatif pour toute nouvelle décision ; peut rester consulté pour du contenu non encore réconcilié |
| **Historical** | Préservé comme trace d'un état ou d'une décision passée, par un acte délibéré qui le déclare tel. | Aucune — jamais consulté pour guider une décision présente |
| **Legacy** | A cessé d'être mis à jour sans qu'aucune décision explicite n'ait été prise à ce sujet. | **Indéterminée — voir Règle 7** |
| **Unknown** | Statut non déterminable à partir des documents disponibles au moment d'un audit. N'est jamais un état cible — seulement un signal temporaire produit par un audit. | Indéterminée, à résoudre |

### 2. Historical vs Legacy — la distinction

**Historical** résulte d'une **décision explicite** : un ADR, un Finding, ou un acte de gouvernance
équivalent déclare noir sur blanc *"ce document documente désormais le passé, pas le présent"*. Sa
provenance est intacte, son statut est clos, aucune action supplémentaire n'est requise.

**Legacy** résulte d'une **absence de décision** : personne n'a choisi d'arrêter de le maintenir, il
a simplement cessé d'être mis à jour pendant que d'autres artefacts évoluaient autour de lui. Son
statut normatif n'est pas résolu — seulement suspecté obsolète. Un document Legacy est un point
ouvert, pas un point fermé.

Un document Historical ne devient jamais Legacy. Un document Legacy peut devenir Historical (par une
décision explicite qui le clôt) ou redevenir Active (par une décision explicite qui le réactualise) —
mais ne peut pas rester Legacy indéfiniment sans qu'un audit ultérieur ne le signale à nouveau.

### 3. Qui peut changer le statut d'un document

| Acteur | Peut... | Ne peut pas... |
|---|---|---|
| **Un ADR** (ou artefact de décision équivalent) | Changer le statut de tout document vers n'importe quel état de la Règle 1 | — |
| **Une Review / un audit** (ex. REV-001, M2-AR-001) | Observer et signaler un statut, y compris `Unknown` | Acter un changement de statut — un audit constate, il ne décide pas |
| **Un programme de recherche** (ex. M1, CWRM) | Produire l'evidence qui justifie un changement de statut | Changer un statut par le seul fait de produire cette evidence — l'acte de décision reste séparé (ADR-0015 Règle 3 en est l'exemple direct) |
| **Le document lui-même** | Évoluer de `Draft` à `Active`, ou entre versions mineures, par édition directe + Historique (ADR-0017) | Se déclarer `Frozen`, `Superseded`, `Deprecated`, ou `Historical` par sa seule auto-déclaration — ces statuts affectent la lecture d'autres documents et requièrent un acte de gouvernance externe |

**Jamais directement** : aucun statut affectant la force normative perçue par un tiers
(`Frozen → autre chose`, `→ Superseded`, `→ Deprecated`, `→ Historical`) ne change sans un artefact de
décision séparé, identifiable, daté.

### 4. Ce qu'est un document Frozen

Reprend et applique ADR-0017 sans le modifier : `Frozen` = `Active` + protection explicite.

- **Peut-il être contredit ?** Pas silencieusement. Un document plus récent qui semble le contredire
  sans déclencher le protocole d'évolution qui protège le Frozen est, par défaut, le document en
  tort — pas l'inverse. Une contradiction ne devient légitime qu'une fois le protocole d'évolution
  explicitement suivi (voir ADR-0015 Règle 3 pour un exemple déjà exécuté).
- **Peut-il être remplacé ?** Oui, uniquement via le protocole d'évolution qui l'a créé ou qui le
  protège — jamais par péremption silencieuse.
- **Reste-t-il consultable ?** Toujours. `Frozen` ne signifie jamais supprimé, caché, ou déprécié.
- **Peut-il perdre son caractère normatif ?** Oui, mais uniquement en transitionnant explicitement
  vers `Historical` ou `Superseded` via un acte de gouvernance — jamais par simple absence de mise à
  jour (ce glissement silencieux est, par définition, ce que la Règle 2 nomme `Legacy`, un état
  distinct, pas une déchéance du statut `Frozen` lui-même).

### 5. Politique face à plusieurs Constitutions coexistantes

Cette ADR ne choisit pas laquelle est correcte, et ne l'exige d'aucune décision future qui s'appuierait
sur elle.

**Principe.** La coexistence de plusieurs documents se déclarant "Constitution" n'est pas, en soi, une
anomalie — à condition que le périmètre exact de chacun soit explicite. Le problème que révèle
M2-AR-001 n'est pas *"il existe plusieurs Constitutions"*, c'est *"leur périmètre respectif n'est
déclaré nulle part, donc un lecteur ne peut pas savoir laquelle s'applique à sa question."*

**Règle.** Toute Constitution — existante ou future — reste au statut `Unknown` au sens de cet ADR
tant qu'elle ne déclare pas explicitement : (a) le périmètre exact de son autorité (à quel type de
décision elle s'applique), et (b) sa connaissance ou non de l'existence d'autres Constitutions, sans
préjuger de leur validité. Cette règle n'exige ni fusion, ni hiérarchie, ni arbitrage — seulement une
déclaration de périmètre qui rende la coexistence lisible plutôt que silencieuse.

### 6. Interaction entre un programme de recherche et la documentation historique

Un programme de recherche (M1, CWRM, ou futur) produit de l'evidence. Il ne modifie jamais
directement un document `Historical` ou `Legacy` par le seul fait de cette production. Sa relation à
la documentation existante suit la même frontière que celle déjà posée par
`PRODUCT-PIPELINE-v1.0.md` lui-même : *"Au-dessus : ce que le terrain apprend. En dessous : ce que
nous décidons de construire."* Un programme de recherche reste "au-dessus" de cette ligne pour toute
question de statut documentaire aussi : il informe un audit ou un Finding, qui peut recommander un
changement de statut ; seul un ADR (Règle 3) l'acte.

### 7. Préserver un document ≠ le considérer normatif

**Préserver** signifie : garder le texte accessible, intact, tracé, jamais supprimé silencieusement.
Tous les statuts de la Règle 1 impliquent la préservation, sans exception — y compris `Historical` et
`Superseded`.

**Être normatif** signifie : un lecteur doit s'y conformer aujourd'hui pour toute nouvelle décision.

| État | Préservé | Normatif |
|---|---|---|
| Draft | Oui | Non |
| Active | Oui | Oui |
| Experimental | Oui | Non (sauf réserve explicite `⚠`) |
| Frozen | Oui | Oui, renforcé |
| Superseded | Oui | Non — le successeur fait foi |
| Deprecated | Oui | Non pour toute nouvelle décision |
| Historical | Oui | Non |
| **Legacy** | Oui | **Indéterminé — traité comme normatif par défaut jusqu'à revue explicite** |

**Règle de précaution pour `Legacy`.** Un document `Legacy` reste traité comme normatif par défaut
tant qu'un audit ou un ADR ne l'a pas explicitement reclassé. Ce choix n'est pas neutre : il aurait
été plus simple de présumer un document `Legacy` caduc. Cette ADR présume l'inverse, par cohérence
avec le principe déjà appliqué ailleurs dans ce corpus (CWRM-STD-002 — un identifiant retiré reste
marqué, jamais réutilisé silencieusement ; CWRM-020 — un entretien échoué reste archivé, jamais
supprimé) : l'absence de mise à jour est un signal d'alerte, pas une preuve d'obsolescence.

---

## Conséquences

**Pour M2-AR-001** — Les douze documents classés `Unknown` restent `Unknown` après cet ADR : cette
décision définit la politique, elle ne l'applique à aucun cas particulier (hors périmètre explicite
de la mission). Ils demeurent traités comme normatifs par défaut là où ils se recoupent avec
`Legacy` (Règle 7), et strictement indéterminés là où aucune décision n'a jamais été prise sur eux.

**Pour les futurs ADR de réconciliation** — Tout ADR qui reclassera un document nommé
(`PRODUCT-CONSTITUTION-v1.0.md`, `M-000`, etc.) devra le faire en citant l'état cible parmi ceux
définis en Règle 1, avec la justification correspondante — pas de statut ad hoc inventé au fil de
l'eau.

**Pour toute nouvelle couche documentaire découverte** — Cette politique reste valable sans
modification : elle ne dépend d'aucun document nommé, seulement de la nature de chaque état.

---

## Relation avec les documents existants

| Document | Relation |
|---|---|
| ADR-0016 — Status of Experimental Concepts | Complémentaire — ADR-0016 statue sur les concepts, cet ADR sur les documents qui les portent |
| ADR-0017 — Freeze Semantics | Base réutilisée sans modification pour `Accepted`/`Experimental`/`Frozen` ; cet ADR étend l'échelle avec `Superseded`, `Deprecated`, `Historical`, `Legacy`, `Unknown` |
| M2-AR-001 | Origine directe — chaque état défini ici répond à une catégorie observée par cet audit |
| AR-001, Finding-005 | `ADR-0020` (Accepted, 2026-10-05) a depuis tranché son objet d'origine (mandat WS-005 réduit à Transmission, Avis/Délégation en hypothèses) — non affecté par cet ADR |

---

## Historique

| Date | Version | Nature |
|---|---|---|
| 2026-08-06 | 1.0 | Création — politique de cycle de vie documentaire, en réponse à M2-AR-001. Aucune réconciliation documentaire effectuée. |
| 2026-10-05 | 1.1 | Correction mineure — référence à `ADR-0020` mise à jour (Accepted, plus réservé), suite à AR-001 Finding-002 |
