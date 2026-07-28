# ADR-SA-011 — Read Model Strategy

**Document ID**: ADR-SA-011
**Title**: Read Model Strategy — Pagination, Indexing, Evolution, Performance
**Status**: Approved

---

## Purpose

ADR-SA-007 D-007 established that Read Models are persisted independently of Aggregates.
ADR-SA-009 D-005 established that ViewRepositories use DBAL with direct `array → DTO`
mapping.

This document establishes the operational rules of the Read Side: how projections are
shaped, how data is retrieved, how pagination works, who owns indexes, and when a
projection should be created, enriched, or split.

---

## 1. Philosophy

The Read Side has exactly one job: **return the data a consumer needs, as fast as
possible, in the shape it needs it.**

It does not represent the Domain. It does not protect invariants. It does not execute
business rules. It optimises for three properties in this order:

1. **Correctness** — the data must match the current Aggregate state (within eventual consistency bounds)
2. **Simplicity** — the query must be readable by any engineer without domain context
3. **Performance** — the query must return within acceptable latency under expected load

When these properties conflict, correctness wins over simplicity. Simplicity wins over
performance. Performance is achieved through indexing and denormalisation, not through
architectural complexity.

### What the Read Side Is Not

The Read Side is not a mirror of the Write Side. Projection tables are not normalised
representations of Aggregate state. They are pre-computed, retrieval-optimised views
shaped for their specific consumer.

A Projection table column may contain data from multiple Aggregates. A Projection may
join data that exists in separate Aggregate stores. A Projection may denormalise a
value that exists in a single Aggregate to avoid a JOIN at query time.

None of this violates DDD. The projection is in the Infrastructure layer. It is not a
domain object.

---

## 2. Structure

The Read Side execution path is:

```
Query (Application — immutable intent)
    ↓
QueryHandler (Application — dispatches to ViewRepository Port)
    ↓
ViewRepository Port (Application — interface contract)
    ↓
ViewRepository Implementation (Infrastructure — DBAL)
    ↓
PostgreSQL (explicit SELECT)
    ↓
array (DBAL result row)
    ↓
View DTO (Application contract — immutable)
    ↓
QueryHandler returns View DTO to caller
```

No component outside this path participates in a Read Side operation.
No Aggregate Repository is accessed. No Domain object is instantiated.

---

## 3. SQL Policy

### SP-001 — All SQL Is Explicit

Every SELECT executed by a ViewRepository is a SQL string literal in a PHP file.

No auto-generated queries. No ORM. No magic.

The full query is readable in the ViewRepository implementation without traversing
abstractions.

**Permitted:** Doctrine DBAL `QueryBuilder` when it reduces verbosity for dynamic filter
composition. When using QueryBuilder, each `WHERE` condition must be explicitly added —
no dynamic addition based on runtime type inference.

**Prohibited:**
- Doctrine ORM `EntityRepository::findBy()`
- Any abstraction that generates SQL from object structure
- SQL assembled from string concatenation without parameterisation (SQL injection risk)

### SP-002 — No Intermediate Row Class

DBAL returns `array`. The array is mapped directly to the View DTO in the ViewRepository
implementation. No `ProjectionRow`, `ReadRow`, or equivalent intermediate class exists
between the DBAL result and the DTO.

This is enforced by ADR-SA-008 (Model Existence Principle). The `array` passes the
Existence Test because it carries no forbidden dependency.

### SP-003 — JOIN Is Authorised

ViewRepository implementations MAY join across Projection tables when the data needed
by the View DTO exists in multiple tables.

A JOIN in a Projection query is not a cross-Aggregate join. Projection tables are not
Aggregate stores. Joining two Projection tables to build a composite View DTO is correct
and encouraged over multiple round-trips.

**Rule:** A JOIN must be documented with a comment stating which Projection tables it
spans and why. Example:

```sql
-- JOIN: patient_timeline ← clinical_contribution_detail
-- Reason: timeline entries display contributor name stored in detail projection
SELECT t.id, t.clinical_text, t.occurred_at, d.contributor_name
FROM patient_timeline t
JOIN clinical_contribution_detail d ON d.id = t.contribution_id
WHERE t.care_record_id = :careRecordId
```

### SP-004 — Denormalisation Is Authorised

Projection tables MAY store denormalised data — values duplicated from another projection
or derived from multiple events — when this eliminates a JOIN at query time.

Denormalisation is a performance decision, not an architectural violation. The value of
a denormalised column is maintained by the Projector that writes to the table.

**Example:** `patient_timeline.contributor_name` stores the practitioner's name at the
time of the contribution. This avoids a JOIN to a practitioner projection at query time.
If the practitioner changes their name later, the timeline entry retains the historical
name — which is clinically correct.

### SP-005 — Parameterised Queries Are Mandatory

Every user-controlled value in a SQL query SHALL be passed as a DBAL parameter.

No string interpolation. No `sprintf` with user values. No dynamic column names from
user input.

---

## 4. Pagination

### Decision: Keyset Pagination on (occurred_at, id)

MedLink uses **keyset pagination** (also called cursor-based pagination) for all lists
of temporally ordered data.

Offset/limit pagination is prohibited for Projection lists. At scale, `OFFSET N` requires
the database to scan and discard N rows. For a timeline with 10,000 entries, page 500
requires scanning 9,980 rows before returning 20.

Keyset pagination avoids this by using the last seen row as the cursor.

### Cursor Structure

The cursor encodes the position of the last returned row:

```json
{ "occurred_at": "2026-07-24T14:32:00.000Z", "id": "uuid-of-last-row" }
```

The cursor is base64-encoded and opaque to the API consumer. The API consumer does not
know its internal structure.

### Query Pattern

```sql
-- First page (no cursor)
SELECT id, clinical_text, status, occurred_at
FROM patient_timeline
WHERE care_record_id = :careRecordId
ORDER BY occurred_at DESC, id DESC
LIMIT :limit

-- Subsequent pages (cursor provided)
SELECT id, clinical_text, status, occurred_at
FROM patient_timeline
WHERE care_record_id = :careRecordId
  AND (occurred_at, id) < (:cursorOccurredAt, :cursorId)
ORDER BY occurred_at DESC, id DESC
LIMIT :limit
```

The composite `(occurred_at, id)` cursor is stable: two events at the same timestamp
are differentiated by `id`. No rows are skipped or duplicated between pages.

### Page Size Policy

| Parameter | Value |
|---|---|
| Default page size | 20 |
| Maximum page size | 100 |
| Minimum page size | 1 |
| Page size parameter | `limit` (API) |

If `limit` exceeds 100, the ViewRepository returns 100 results without error. The
consumer is not informed of the cap — the response simply contains 100 results.

### Next Page Token

The ViewRepository returns:

```php
new PatientTimelineView(
    entries: [...],
    nextPageToken: $hasMore ? base64_encode(json_encode($lastCursor)) : null,
)
```

`nextPageToken` is `null` when the last page has been reached. The consumer passes
`nextPageToken` as the cursor parameter for the next request.

---

## 5. Index Policy

### Who Owns Indexes

The ViewRepository owns the indexes for its Projection table.

The ViewRepository implementation knows the exact query patterns. It is the only
component with authority to declare what indexes its table needs.

Indexes are defined in the migration that creates the Projection table. They are
reviewed alongside the ViewRepository implementation in the same PR.

### Mandatory Index Rule

Every Projection table SHALL have a composite index on the columns used in its primary
`WHERE + ORDER BY` clause.

For temporal lists:
```sql
CREATE INDEX idx_patient_timeline_care_record
    ON patient_timeline (care_record_id, occurred_at DESC, id DESC);
```

For detail lookups:
```sql
CREATE INDEX idx_contribution_detail_id
    ON clinical_contribution_detail (id);
-- (this is the PRIMARY KEY — no additional index needed)
```

### Additional Indexes

Additional indexes are permitted when a ViewRepository has a secondary query path (e.g.,
a filtered view). Each additional index must be justified in the PR description: which
query pattern it serves, and why the primary index is insufficient.

An index that is not used by any active ViewRepository query is technical debt and must
be removed in the next cleanup PR.

---

## 6. Performance

### Projections Are Jetable — Therefore Optimisable

Because Projections are disposable (rebuilt from the Outbox — ADR-SA-010), they can be
optimised aggressively without fear of losing canonical data.

Adding a denormalised column, adding an index, restructuring the table layout — all of
these operations require only a Projection rebuild, not a domain migration.

This freedom should be exploited: Projection tables should be structured for the query,
not for normalisation.

### Performance Boundaries

| Metric | Target | Action if exceeded |
|---|---|---|
| P95 ViewRepository query | < 50ms | Investigate — add index or denormalise |
| P99 ViewRepository query | < 200ms | Alert — architectural review required |
| First page load | < 100ms end-to-end | Review full stack |

### When a Query Is Too Slow

In order:
1. Check that the correct index exists and is being used (`EXPLAIN ANALYZE`)
2. Add the missing index (no rebuild required — `CREATE INDEX CONCURRENTLY`)
3. Denormalise a JOIN into the Projection table (Projector rebuild required)
4. Split the query into two separate Projections (architectural change)

Do not optimise the query before checking the index. Do not rebuild before adding the
index. The cost of a Projection rebuild is real; the cost of an index creation is not.

---

## 7. Projection Evolution

### When to Create a New Projection

Create a new Projection when the new use case has a **distinct access pattern** — defined
as a different combination of at least two of:

- `WHERE` clause columns (filtering by a different dimension)
- `ORDER BY` columns (ordering by a different axis)
- `JOIN` tables (combining different Projection data)

**Example — create a new Projection:**
- `PatientTimelineProjection` orders by `occurred_at DESC` for a chronological view.
- A new "Overdue Contributions" view orders by `deadline_at ASC` and filters by `status = 'pending'`.
- Different `WHERE`, different `ORDER BY` → new Projection.

**Example — enrich existing Projection:**
- `ClinicalContributionDetailProjection` stores the contribution body.
- The API now also needs the approver's name.
- Same `WHERE`, same `ORDER BY`, additional column → enrich existing Projection.

### When to Enrich an Existing Projection

Enrich an existing Projection when:
- The new field is needed by the same query that already uses the Projection.
- The new field comes from a Domain Event already handled by the existing Projector.
- Adding the field does not require changing the primary index.

### The One Projection per Access Pattern Rule

No two ViewRepositories should read the same Projection table with significantly
different query shapes.

If two ViewRepositories read the same table with different `WHERE` conditions, it is a
signal that one of them needs its own Projection — or that the table needs an additional
index.

This rule prevents Projection tables from accumulating columns needed by many different
consumers, which makes it impossible to optimise the table for any of them.

### Splitting a Projection

When a Projection table has grown to serve multiple distinct access patterns, it must be
split into dedicated Projection tables — one per access pattern.

Splitting procedure:
1. Create the new Projection table via migration.
2. Replay the relevant Domain Events to populate it (ADR-SA-010 §7).
3. Update the ViewRepository to read from the new table.
4. Remove the columns from the original table that are now exclusively in the new table.
5. Rebuild the original Projection if needed.

---

## Relation to Other ADRs

| ADR | Relation |
|---|---|
| ADR-SA-007 D-007 — Read Model Persistence | This document operationalises D-007 with concrete query, pagination, and indexing rules |
| ADR-SA-008 — Model Existence Principle | Prohibits intermediate Row classes; mandates direct array → DTO |
| ADR-SA-009 D-005 — ViewRepository | This document extends D-005 with pagination and index ownership |
| ADR-SA-010 — Reliable Event Delivery | Outbox enables rebuild; this document defines the rebuild trigger conditions |

---

## Decision History

| Date | Decision |
|---|---|
| 2026-07-24 | ADR approved — keyset pagination mandatory; index ownership to ViewRepository; one Projection per access pattern |
