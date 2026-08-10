# MEDLINK-000 — The Evolution of MedLink

*From intuition to empirical product design.*

*Un document qui ne gouverne rien, ne remplace rien, et n'introduit aucune règle.*

---

## 1. Pourquoi ce document existe

MedLink n'a pas été conçu en une seule étape.

Comme toute démarche de recherche, le projet a évolué par itérations successives.

Les documents présents dans ce dépôt représentent différentes étapes de cette évolution. Certains
sont nés d'une intuition. D'autres d'une théorie. D'autres d'une observation directement corroborée
par le terrain. Ce document explique leur rôle et leurs relations — pas pour trancher lequel est
vrai, mais pour que leur coexistence se comprenne au premier regard plutôt que de ressembler à une
contradiction.

Il ne fixe aucun statut. [ADR-0021](adr/ADR-0021-document-lifecycle-legacy-governance.md) fait déjà
ce travail-là, pour qui veut savoir précisément ce qu'un document engage aujourd'hui.
[M2-AR-001](M2-AR-001-product-governance-reconciliation-audit.md) fait le travail de cartographie
exhaustive. Celui-ci ne fait que raconter, simplement, comment on est arrivé là.

---

## 2. Génération 1 — Vision

L'intuition. Les premières convictions. Pourquoi MedLink existe.

C'est ici que vivent `M-000` (Manifesto), `MISSION.md`, `MANIFESTO.md`, et la justification
philosophique qui les accompagne (`M-002`). Plus tard dans le projet, `FOUNDATIONS.md` et
`CONSTITUTION.md` sont venus reformuler cette même question — pas parce que la Génération 1 se
termine à un moment donné, mais parce qu'un projet a besoin, de temps en temps, de revenir à son
pourquoi avant d'avancer.

Ces documents ne sont pas des spécifications. Ils ne répondent pas à *"comment"*. Ils répondent à :

> Pourquoi ?

---

## 3. Génération 2 — Théorie Produit

À partir de cette vision, une première théorie produit a été formulée.

C'est ici que vivent `PRODUCT-CONSTITUTION-v1.0`, `PRODUCT-ARCHITECTURE-v1.0`,
`PRODUCT-PIPELINE-v1.0`, `PRODUCT-OPERATING-MODEL-v1.0`, `PRODUCT-PRINCIPLES.md`,
`DISPLAY-RULEBOOK.md`, ainsi que les explorations qui les accompagnent (`M-001`, `M-003`, `CC-000`,
`MP-001`, `PP-001`, `PD-001`, `H-P01`).

Ces documents représentent la première théorie explicative du produit.

Pas la vérité — une théorie. La meilleure hypothèse formulable avec ce qu'on savait à ce moment-là.
Une théorie a le droit d'anticiper avant que le terrain ne parle. C'est même son rôle.

---

## 4. Génération 3 — Validation empirique

M1.

Le changement de paradigme : ne plus partir des hypothèses. Partir des observations.

C'est ici que vivent le corpus d'entretiens et les ACT qui en sont extraits, les transformations
d'état, le travail de corroboration et de tentative de réfutation systématique — et tout ce que ce
travail a produit : `GOV-000`, la série `ADR-0015` → `ADR-0021`, `WBD-004`, `WE-004`/`WE-005`,
`PDR-004`, `PDX-001`, `AR-001`, `AR-001B`, `CWRM-EXP-001`. Le détail complet de cette génération est
dans [M1_FINAL_ARCHIVE](M1_FINAL_ARCHIVE.md).

Cette génération n'a pas cherché à prouver que la Génération 2 avait raison. Elle a cherché à savoir
ce que le terrain dit, y compris quand ça contredisait une théorie déjà écrite — c'est précisément ce
qui est arrivé plus d'une fois.

---

## 5. Génération 4 — Traduction

M2.

M2 ne redéfinit pas le produit.

Il traduit les lois observées du travail clinique en expérience produit.

L'interface utilisateur n'est pas conçue indépendamment des observations. Elle constitue la
traduction la plus fidèle connue, à un instant donné, des lois observées du travail clinique.

Cette génération ne produit pas seulement des écrans. Elle produit les intentions, les parcours, les
Workspaces, les frontières produit. L'UX n'en est qu'une conséquence — la dernière étape d'une chaîne
qui commence par ce que le terrain a montré, pas par ce qu'un écran devrait afficher.

`PRODUCT-001` (*"The Perfect Clinical Day"*) est le premier geste dans cette direction, encore au
statut Draft, encore non réconcilié avec ce qui précède. Cette génération commence tout juste.

---

## 6. Une philosophie

Les documents des générations précédentes ne sont pas remplacés.

Ils représentent les étapes successives de la compréhension du problème.

Les nouvelles observations enrichissent cette compréhension. Elles ne l'effacent pas.

Lorsqu'une contradiction apparaît entre deux générations, le modèle évolue ; la réalité observée
reste l'autorité.

Les hypothèses peuvent évoluer.

Les principes produit peuvent évoluer.

Les architectures peuvent évoluer.

Les implémentations évolueront nécessairement.

La réalité observée, elle, n'est jamais modifiée pour préserver un modèle existant.

C'est précisément cette asymétrie qui permet au projet de progresser.

Rien de ce qui précède n'est une **ancienne architecture**. Rien n'est **obsolète**. Rien n'est du
**legacy**. Ce sont des étapes d'une même évolution de la connaissance — celle d'un projet qui a
appris, à chaque génération, un peu mieux ce qu'il essaie de comprendre.

```
                Réalité clinique
                       │
                       ▼
              Génération 1
            Intuition / Vision
                       │
                       ▼
              Génération 2
          Première théorie produit
                       │
                       ▼
              Génération 3
         Validation empirique (M1)
                       │
                       ▼
              Génération 4
      Traduction en expérience (M2)
                       │
                       ▼
             Architecture & Code
```

---

## 7. La philosophie scientifique de MedLink

### La primauté de la réalité

MedLink repose sur un principe simple :

La réalité prime toujours sur le modèle.

Le travail clinique existe indépendamment de MedLink.

La recherche n'a pas pour objectif d'inventer des workflows cliniques, mais de découvrir comment ils
fonctionnent naturellement.

Chaque observation, chaque entretien, chaque résultat empirique contribue à une compréhension
progressivement plus fidèle de cette réalité.

### Les lois se découvrent

Les régularités identifiées par l'observation empirique ne sont pas des décisions de conception.

Elles sont la manifestation de phénomènes récurrents observés dans la pratique clinique.

Au fil du temps, elles peuvent être corroborées, précisées ou réfutées par de nouvelles observations.

Le projet les considère donc comme la meilleure compréhension actuelle du travail clinique, et non
comme des vérités immuables.

### Les modèles évoluent

Les principes produit, les parcours utilisateurs, les Workspaces, les architectures, les modèles de
domaine et les implémentations logicielles sont des modèles.

Leur rôle est de traduire, aussi fidèlement que possible, les lois du travail clinique telles
qu'elles sont comprises à un instant donné.

Lorsqu'une nouvelle observation contredit un modèle, le modèle évolue.

L'observation, elle, ne change pas.

### Un apprentissage continu

MedLink n'a pas vocation à converger vers une architecture définitive.

Il a vocation à converger vers une représentation toujours plus fidèle de la réalité clinique.

Chaque génération de documents représente ainsi une progression de la compréhension, et non le
remplacement de la génération précédente.

Le projet progresse en conservant ce que la réalité confirme, en affinant ce qu'elle éclaire, et en
révisant ce qu'elle contredit.

### Une histoire de compréhension

Ce dépôt ne doit pas être lu comme une simple collection de documents indépendants.

Il doit être compris comme l'histoire d'une compréhension qui s'est progressivement enrichie du
travail clinique.

Chaque génération répond à une question différente.

Ensemble, elles décrivent l'évolution de MedLink : d'une intuition fondatrice vers une conception
produit ancrée dans l'observation empirique.

### Une conséquence fondamentale

Dans MedLink, une architecture n'est jamais une fin en soi.

Elle constitue le meilleur modèle connu, à un instant donné, pour traduire les lois observées du
travail clinique en logiciel.

Si de nouvelles observations conduisent à une meilleure compréhension de cette réalité, alors
l'architecture, le produit et le logiciel ont vocation à évoluer avec elle.

La fidélité à la réalité prévaut toujours sur la préservation d'un modèle existant.

> Cette section recoupe, en partie, [CWRM-SCI-000](research/specifications/CWRM-SCI-000-scientific-constitution.md)
> (Rules 8 et 9 en particulier). Elle n'en est pas une reformulation normative — CWRM-SCI-000 reste la
> charte scientifique qui gouverne le CWRM ; cette section explique seulement, en langage narratif,
> pourquoi ce dépôt se lit comme une évolution plutôt que comme une collection de vérités concurrentes.

---

## Comment lire ce dépôt

Tous les documents présents dans ce dépôt ne répondent pas à la même question.

Les documents de Vision expliquent pourquoi MedLink existe.

Les documents de Théorie Produit proposent une première modélisation du problème.

Les documents de Recherche cherchent à comprendre le travail clinique réel.

Les documents d'Architecture traduisent cette compréhension en modèles logiciels.

Les documents d'Engineering implémentent ces modèles.

Aucun de ces niveaux ne remplace le précédent.

Chaque niveau traduit le précédent dans un langage différent.

---

> **MedLink is not built by imposing models on clinical work. It is built by progressively
> discovering the structure of clinical work, then translating that understanding into product,
> architecture, and software.**

---

## Historique

| Date | Version | Nature |
|---|---|---|
| 2026-08-06 | 1.0 | Version initiale — document explicatif, non normatif |
| 2026-08-06 | 1.1 | Titre reformulé (*"The Evolution of MedLink"*) ; Génération 4 précisée (l'UX comme conséquence, pas comme point de départ) ; asymétrie modèle/réalité développée en §6 ; section "Comment lire ce dépôt" ajoutée ; phrase de clôture ajoutée |
| 2026-08-06 | 1.2 | Ajout de la section 7 — "La philosophie scientifique de MedLink" (primauté de la réalité, découverte des lois, évolution des modèles, apprentissage continu). Sous-titre interne renommé pour éviter la collision avec la section "Comment lire ce dépôt" existante. Renvoi explicite à CWRM-SCI-000 (Rules 8/9) plutôt que redondance silencieuse. |
