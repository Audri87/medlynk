# ADR-0017 — Sémantique du Gel (Accepted / Experimental / Frozen)

**Statut** : Accepted
**Date** : 2026-08-06
**Sprint** : M1.1 — Consolidation (priorité 2)
**Répond à** : Critique 5 de la revue d'architecture M1

---

## Contexte

Le problème n'est pas la méthode — c'est le mot "gelé". Plusieurs documents du corpus emploient
"Accepted" et "Frozen" (ou "gelé"/"Binding") de façon quasi interchangeable :

- CWRM-AF-001 s'intitule *"Architectural Freeze v1.0"* mais son champ `Status` affiche
  *"Accepted — Binding"*.
- GOV-000 est globalement `Status: Accepted`, mais contient à la fois des clauses explicitement
  *"gelées"* (§3, convention des marqueurs — *"Convention des marqueurs (gelée)"*) et des clauses
  explicitement *non* gelées dans le même document (§1ter-b — *"Ceci n'est pas une couche gelée"*
  pour Cognitive Responsibility).

Le message de freeze M1 a traité "Responsibility → Product Question → Workspace" comme acquis, en
s'appuyant implicitement sur le statut global `Accepted` de GOV-000 — sans voir que la clause
précise qui le concerne est explicitement marquée comme non gelée à l'intérieur de ce même document
Accepted.

---

## Décision

### Les trois états, définis au niveau de la clause — pas seulement du document

Un document entier peut être `Accepted` tout en contenant des clauses individuelles à des états
différents. **Le statut d'une clause ne se déduit jamais du statut global du document qui la
contient — il doit être vérifié clause par clause.**

| État | Définition | Peut évoluer comment | Peut apparaître dans un jalon "acquis" ? |
|---|---|---|---|
| **Experimental** | Hypothèse en test, protocole de sortie explicite non conclu | Librement, tant que le protocole de sortie n'est pas conclu | **Non, jamais** |
| **Accepted** | Référence courante sur son sujet ; peut évoluer par versionnement normal (bump mineur, Historique) | Par édition directe + entrée Historique/Changelog | Oui, avec sa version affichée |
| **Frozen** | `Accepted` **et** explicitement protégé — modification impossible sans un protocole d'évolution dédié et documenté | Uniquement via le protocole d'évolution propre au document qui la porte (ex. CWRM-AF-001 §"Critères d'acceptation") | Oui |

`Frozen` est un sur-ensemble strict d'`Accepted` — jamais un synonyme. Toute clause non explicitement
marquée `Frozen` reste au niveau `Accepted` par défaut, même si le document conteneur porte un nom
évoquant un gel (ex. "Architecture Freeze").

### Reclassification rétroactive (2026-08-06)

| Document / Clause | État réel | Preuve |
|---|---|---|
| CWRM-AF-001, chaîne méthodologique | Frozen (le contenu), document conteneur Accepted — Binding | Protocole d'évolution à 5 questions explicite |
| CWRM-AF-001, méta-modèle (§"Le méta-modèle") | Frozen | *"Ils ne pourront évoluer qu'après validation expérimentale"* |
| GOV-000 §3, convention des marqueurs | Frozen | *"Convention des marqueurs (gelée)"*, explicite |
| GOV-000 §1ter-a, vocabulaire Product hors Domain | Frozen | *"règle gelée non conditionnelle"*, explicite |
| GOV-000 §1ter-b, Cognitive Responsibility | **Experimental** | *"Ceci n'est pas une couche gelée"*, explicite — ne doit jamais apparaître comme acquis (voir ADR-0016) |
| ADR-0015 — chaîne canonique | Accepted | Évolutif par le protocole de sa Règle 4, pas encore Frozen |

### Règle contraignante

Tout futur document de jalon (Freeze, Milestone, "état des lieux acquis") **doit** vérifier l'état de
chaque clause citée individuellement, et ne peut lister comme "acquis" que des clauses `Accepted` ou
`Frozen`. Une clause `Experimental` citée dans un jalon doit porter la mention explicite
`(Experimental — non acquis)`.

---

## Conséquences

**Pour les futurs jalons M2, M3…** — Doivent produire, avant publication, une vérification clause par
clause plutôt qu'une lecture du seul champ `Status` en tête de document.

**Pour CWRM-AF-001** — Reste Binding sur les clauses qu'il gèle explicitement ; ne l'est pas sur tout
ce que d'autres documents Accepted en dérivent implicitement.

**Pour GOV-000** — Aucune réécriture de contenu n'est requise ; cet ADR documente une lecture correcte
de ce que GOV-000 dit déjà, sans le modifier.

---

## Relation avec les documents existants

| Document | Relation |
|---|---|
| ADR-0016 — Status of Experimental Concepts | Complémentaire : ADR-0016 statue sur les concepts, ADR-0017 sur les clauses/documents qui les portent |
| CWRM-AF-001 | Reclassifié comme Frozen sur son contenu, Accepted — Binding comme statut global |
| GOV-000 §1ter-b | Confirmé Experimental, non affecté dans son texte |

---

## Historique

| Date | Version | Nature |
|---|---|---|
| 2026-08-06 | 1.0 | Création — Sprint M1.1, réponse à la Critique 5 de la revue d'architecture M1 |
