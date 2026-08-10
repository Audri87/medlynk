# PRODUCT-001 — The Perfect Clinical Day

## Version 0.1 — Vision produit

| Field | Value |
|---|---|
| Statut | Draft — Vision |
| Date | 2026-08-06 |
| Nature | Document de vision produit, lecteur principal = praticien, pas développeur |

> **Avertissement de statut — non réconcilié.** `docs/product/` contient déjà plusieurs documents
> fondateurs (`PRODUCT-CONSTITUTION-v1.0.md` — *Frozen*, `M-000-manifesto.md`, `MISSION.md`,
> `PRODUCT-PRINCIPLES.md`, entre autres) découverts au moment d'écrire ce document mais non encore
> audités ni mis en relation avec lui, ni avec `CONSTITUTION.md`/`FOUNDATIONS.md`/`MANIFESTO.md`
> (racine du dépôt). PRODUCT-001 coexiste avec cette couche existante sans hiérarchie déclarée — même
> choix assumé que pour les trois autres documents fondateurs. Ne pas lire ce document comme
> supersédant `PRODUCT-CONSTITUTION-v1.0.md` ou tout autre document `docs/product/*`.

---

# Préambule

Ce document n'est ni une spécification fonctionnelle, ni un Blueprint d'architecture.

Il décrit **la journée idéale d'un professionnel de santé utilisant MedLink**, telle qu'elle devrait être vécue.

Le lecteur principal n'est pas un développeur.

C'est un praticien.

Chaque interaction décrite devra pouvoir être reliée, dans les documents techniques, à une evidence produite pendant M1.

Le praticien, lui, ne voit jamais :

* Workspace
* Aggregate
* Event
* Timeline Projection
* Care Record

Il poursuit uniquement des intentions.

---

# Les six intentions fondamentales

Au cours d'une journée clinique, un praticien cherche uniquement à :

1. Me préparer
2. Comprendre
3. Soigner
4. Retenir
5. Partager
6. Terminer

Tout MedLink doit être organisé autour de ces six intentions.

Jamais autour de sa structure technique.

> *Note (séparable, non normative) — correspondance avec la Clinical Loop.* Ces six intentions
> s'alignent terme à terme avec WS-001 → WS-006 (Me préparer=WS-001, Comprendre=WS-002, Soigner=WS-003,
> Retenir=WS-004, Partager=WS-005, Terminer=WS-006). Deux d'entre elles reposent sur un niveau
> d'evidence inégal : "Soigner"/"Comprendre" sont Gold Standard ; "Partager" (WS-005) vient de faire
> l'objet d'un audit de corroboration ([AR-001 Finding-005](../AR-001-architecture-review.md)) qui a
> trouvé une seule de ses quatre composantes déclarées (transmission) au niveau `Evidence` — les
> trois autres (avis, délégation, reprise de patient) sont respectivement `Unsupported`, `Observation`
> et mal rattachée. Ceci ne remet pas en cause l'intention "Partager" elle-même, qui reste légitime
> comme vision — seulement son niveau de preuve actuel, plus bas que celui des autres intentions.

---

# 07:45 — J'arrive au cabinet

## Mon intention

**Me préparer.**

Je ne veux pas ouvrir un logiciel.

Je veux commencer ma journée.

---

## Ce que je veux savoir

* Qui vais-je voir aujourd'hui ?
* Y a-t-il une urgence ?
* Quel patient mérite une attention particulière ?
* Qu'est-ce qui a changé depuis hier ?
* Dois-je préparer quelque chose ?

Je ne veux pas parcourir dix écrans.

Je veux comprendre ma journée en moins d'une minute.

---

## Ce que fait MedLink

MedLink me présente une vue synthétique de ma journée.

Pas une liste.

Une compréhension.

Chaque patient est accompagné de son contexte essentiel.

Les changements importants depuis ma dernière intervention sont mis en évidence.

Les urgences apparaissent naturellement.

Les éléments inchangés restent discrets.

Je n'ai encore rien cliqué.

Pourtant je sais déjà comment ma journée va commencer.

---

# 08:00 — Premier patient

## Mon intention

**Comprendre.**

Avant d'entrer dans la salle.

Je veux répondre immédiatement à une seule question :

> Où en étions-nous ?

---

## Ce que je veux retrouver

* la dernière séance
* ce qui avait été décidé
* ce qui devait être repris
* les évolutions importantes
* les points de vigilance

Je ne cherche pas un dossier.

Je cherche un contexte.

---

## Ce que fait MedLink

MedLink reconstruit ce contexte avant toute action.

Je n'ai pas besoin de relire plusieurs comptes rendus.

Je comprends immédiatement :

* pourquoi ce patient est là,
* ce qui a changé,
* ce que nous devons faire aujourd'hui.

---

# 08:02 — La consultation commence

## Mon intention

**Soigner.**

Mon attention appartient au patient.

Pas à l'ordinateur.

Je parle.

J'observe.

J'écoute.

Je réfléchis.

Le logiciel ne doit jamais devenir le centre de la consultation.

---

## Ce que fait MedLink

Il reste silencieux.

Il ne m'interrompt jamais.

Il ne me demande aucune information inutile.

Il ne transforme pas chaque interaction en formulaire.

Il m'accompagne sans voler mon attention.

---

# 08:35 — Une information importante apparaît

## Mon intention

**Retenir.**

Je ne veux pas perdre cette information.

Mais je ne veux pas casser la relation avec le patient.

---

## Ce que fait MedLink

La capture est minimale.

Quelques secondes suffisent.

Je peux reprendre immédiatement ma consultation.

La technologie s'efface derrière le soin.

---

# 08:42 — Le patient quitte le cabinet

## Mon intention

**Retenir durablement.**

Je veux que mon futur moi comprenne cette séance.

Pas seulement moi.

Le professionnel qui reprendra éventuellement ce patient devra également comprendre.

---

## Ce que fait MedLink

Il m'aide à transformer une capture brute en mémoire clinique.

Cette mémoire est :

* concise,
* fidèle,
* exploitable,
* réutilisable.

Je n'écris jamais pour remplir un dossier.

J'écris pour soutenir le raisonnement clinique futur.

> *Note (séparable, non normative).* La phrase *"le professionnel qui reprendra éventuellement ce
> patient devra également comprendre"* touche directement
> [Finding-004](../AR-001-architecture-review.md#finding-004--la-définition-de-ws-004-empiète-sur-le-mandat-de-ws-005) :
> le corpus a montré que produire une mémoire réutilisable par soi-même (WS-004) et la rendre
> effectivement disponible à un autre professionnel (WS-005) sont deux actes distincts, le second
> conditionnel. Lu strictement, ce paragraphe reste cohérent avec cette frontière — la mémoire est
> conçue pour être *transmissible si besoin*, ce qui est le travail de WS-004, sans que la
> transmission elle-même (WS-005) soit automatique. La formulation reste néanmoins proche du texte
> *"pour soi-même et pour d'autres"* que Finding-004 a retiré du mandat de WS-004 — à garder en tête
> si ce paragraphe sert un jour de base à une spécification.

---

# 08:45 — Une transmission devient nécessaire

## Mon intention

**Partager.**

Je veux transmettre uniquement ce qui doit l'être.

Au bon destinataire.

Au bon moment.

---

## Ce que fait MedLink

Il prépare la transmission.

Il rassemble automatiquement les éléments utiles.

Il me laisse décider.

La responsabilité clinique reste toujours humaine.

---

# 12:30 — Entre deux patients

Je n'ai pas besoin de penser :

* aux dossiers oubliés,
* aux documents reçus,
* aux tâches en attente.

MedLink maintient ces éléments visibles sans envahir mon attention.

Je peux choisir le bon moment pour les traiter.

---

# 18:15 — Fin de journée

## Mon intention

**Terminer.**

Je veux rentrer chez moi.

Je ne veux pas passer une heure à vérifier ce que j'ai oublié.

---

## Ce que fait MedLink

Il me montre uniquement ce qui reste réellement ouvert.

Je peux décider :

* terminer maintenant,
* reporter,
* déléguer,
* ignorer si cela n'a plus de valeur.

Lorsque je ferme MedLink, j'ai confiance.

Ma journée est terminée.

---

# Les principes invisibles

Le praticien ne voit jamais :

* les Workspaces,
* les projections,
* les événements,
* les agrégats.

Il ne poursuit jamais une architecture.

Il poursuit une intention.

L'architecture existe uniquement pour rendre ces intentions possibles.

---

# Définition de réussite

Une journée est réussie lorsque le praticien peut dire :

> « Je n'ai jamais eu l'impression d'utiliser un logiciel. J'ai simplement pu travailler avec davantage de sérénité, en retrouvant le bon contexte au bon moment, sans que la technologie ne détourne mon attention de mes patients. »

Si cette phrase devient vraie, alors MedLink aura rempli sa mission.

---

## Historique

| Date | Version | Nature |
|---|---|---|
| 2026-08-06 | 0.1 | Version initiale — vision produit, non réconciliée avec les documents fondateurs préexistants de `docs/product/` |
