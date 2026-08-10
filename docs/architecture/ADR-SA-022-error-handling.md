# ADR-SA-022 — Error Handling Policy

**Type :** Software Architecture Decision — Politique transversale
**Statut :** Accepted
**Date :** 2026-07-29
**Autorité :** Ce document gouverne la gestion des erreurs dans toutes les couches. Il est subordonné à ADR-SA-000 et ADR-SA-017.

---

## Conformité ADR-SA-000

| Principe | Statut | Note |
|---|---|---|
| P-01 — Indépendance du Domain | ✅ Conforme | Les DomainExceptions ne connaissent pas HTTP |
| P-02 — Aggregates gardiens | ✅ Conforme | Les exceptions métier naissent dans l'Aggregate |
| P-03 — Application Services orchestrent | ✅ Conforme | L'Application Service distingue les types d'exception — §4 |
| P-04 à P-10 | ⚪ Sans objet | |

---

## 1. Contexte

Sans politique explicite d'error handling, trois dérives émergent :
- les exceptions métier et techniques sont confondues et traitées identiquement,
- les détails d'infrastructure fuient vers le client HTTP,
- les logs ne permettent pas de distinguer un comportement attendu d'un incident réel.

Cette ADR établit la politique unifiée d'error handling pour toutes les couches de MedLink.

---

## 2. Hiérarchie des exceptions

### Exceptions métier (Domain)

Toutes les exceptions métier étendent `DomainException`. Elles expriment une violation d'une règle du domaine.

```
DomainException (base)
├── ClinicalActivityNotActive
├── SelfApprovalAttemptedException
├── ContributionAlreadySigned
├── InsufficientClinicalData
└── ...
```

**Règles :**
- Une `DomainException` est nommée d'après le fait métier qu'elle exprime — jamais d'après l'opération technique
- Elle est définie dans le Domain Layer, dans le répertoire de l'Aggregate ou du concept concerné
- Elle ne contient pas de référence à une couche technique (HTTP, ORM, message bus)
- Son message est lisible par un développeur — il n'est jamais envoyé directement au client

### Exceptions de validation (Interface)

Exprimées avant que la Command ne soit construite. Elles indiquent un format d'entrée invalide.

```
ValidationException (base)
├── MissingRequiredField
├── InvalidUuidFormat
└── ...
```

Ces exceptions appartiennent à la couche Interface. Elles ne descendent jamais dans le Domain.

### Exceptions de concurrence (Infrastructure)

```
ConcurrencyException
```

Levée lors d'un conflit de version optimiste. Traitée par le TransactionMiddleware (ADR-SA-018 §6 — retry).

### Exceptions d'infrastructure

Toutes les autres exceptions : perte de connexion DB, timeout, bus indisponible, etc.

Elles ne sont **pas** catchées par l'Application Service. Elles remontent et sont loguées au niveau ERROR.

---

## 3. Mapping HTTP

La traduction exception → HTTP status est la responsabilité exclusive de la couche Interface (ou d'un ExceptionListener global en Symfony).

| Exception | HTTP Status | RFC 9110 |
|---|---|---|
| `DomainException` | `422 Unprocessable Content` | Requête bien formée, règle métier violée |
| `ValidationException` | `400 Bad Request` | Format d'entrée invalide |
| `NotFoundException` | `404 Not Found` | Ressource inexistante |
| `AuthorizationException` | `403 Forbidden` | Accès refusé |
| `ConcurrencyException` (après max retries) | `409 Conflict` | Conflit de version non résolu |
| Exceptions d'infrastructure | `500 Internal Server Error` | Erreur interne — aucun détail |

### Format de réponse d'erreur

```json
{
    "type": "https://medlink.io/errors/clinical-activity-not-active",
    "title": "Clinical Activity is not active",
    "status": 422,
    "detail": "The clinical activity {id} is not in an active state.",
    "correlationId": "550e8400-e29b-41d4-a716-446655440000"
}
```

**Règles de format :**
- `type` : URI stable identifiant le type d'erreur (pas l'URL d'une page web)
- `title` : libellé stable en anglais — jamais traduit (c'est un identifiant technique)
- `detail` : message lisible, sans données sensibles
- `correlationId` : propagé depuis le contexte de la requête (ADR-SA-024)
- Jamais de stack trace dans la réponse client
- Jamais de message d'exception interne (erreur SQL, chemin de fichier, etc.)

---

## 4. Comportement par couche

### Domain Layer

- Lève des `DomainException` nommées
- Ne catch jamais d'exception
- N'a aucune notion de HTTP, de log, de retry

### Application Layer

```
try:
    [execute use case]
catch DomainException:
    rollback()
    re-lève (propagée vers Interface)
catch ConcurrencyException:
    rollback()
    retry ou re-lève après maxRetries
catch Throwable:
    rollback()
    log ERROR (stack trace)
    re-lève en InfrastructureException wrappée
```

L'Application Service ne traduit pas les exceptions en réponses HTTP. C'est toujours la couche Interface qui fait cette traduction.

### Interface Layer

- Catch les exceptions propagées par l'Application
- Traduit en réponse HTTP via la table §3
- Enrichit la réponse avec le `correlationId` (ADR-SA-024)
- Ne loggue pas les exceptions métier (déjà loguées par l'Application ou le Domain)

---

## 5. Politique de log

| Exception | Niveau | Contenu du log |
|---|---|---|
| `DomainException` (attendue) | `INFO` | type + message + correlationId |
| `ValidationException` | `INFO` | champs invalides + correlationId |
| `ConcurrencyException` résolue par retry | `DEBUG` | attempt count + correlationId |
| `ConcurrencyException` après maxRetries | `WARNING` | aggregate_id + attempt count + correlationId |
| Infrastructure exception | `ERROR` | stack trace complet + correlationId |
| Erreur critique (perte de DB, OOM) | `CRITICAL` | stack trace + contexte système + correlationId |

**Règles de log :**
- Tout log inclut le `correlationId` (ADR-SA-024)
- Jamais de donnée patient, jamais de donnée personnelle (GDPR + HDS)
- Les logs `INFO` et `DEBUG` ne sont pas des incidents — ils ne déclenchent pas d'alerte
- Les logs `ERROR` et `CRITICAL` déclenchent une alerte (PagerDuty ou équivalent)
- Le stack trace complet n'est jamais envoyé au client — uniquement dans les logs internes

---

## 6. Ce qui est interdit

| Interdit | Raison |
|---|---|
| Catcher `Throwable` dans le Domain | Le Domain n'a pas de stratégie de récupération |
| Envoyer un message d'exception infrastructure au client | Fuite d'information — risque de sécurité |
| Logger des données patient dans les messages d'erreur | GDPR + HDS |
| Utiliser des codes numériques arbitraires comme identifiants d'erreur | Nommer les exceptions par leur nature métier |
| Lever une `RuntimeException` générique pour une règle métier | Toute règle métier violée a un nom |

---

## 7. Invariants protégés

| Invariant | Protégé par |
|---|---|
| Aucun détail d'infrastructure ne fuit vers le client | Traduction dans Interface Layer — §4 |
| Les erreurs métier sont distinguables des erreurs techniques | Hiérarchie d'exceptions — §2 |
| Chaque erreur est traçable par correlationId | Propagation obligatoire — §3, §5 |
| Les logs INFO ne déclenchent pas d'alerte | Niveaux de log explicites — §5 |

---

## Références

| Document | Relation |
|---|---|
| ADR-SA-000 | Constitution logicielle |
| ADR-SA-017 | Runtime Architecture — couches et responsabilités |
| ADR-SA-018 | Transaction Management — rollback sur exception |
| ADR-SA-024 | Observability — correlationId et niveaux de log |
