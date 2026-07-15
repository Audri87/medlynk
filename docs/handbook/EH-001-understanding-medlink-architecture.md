# EH-001 — Understanding MedLink Architecture

**Series**: Engineering Handbook
**Audience**: PHP / Symfony developers new to DDD, Hexagonal Architecture, CQRS
**Complements**: SA-001, SA-002, SA-003, SA-004

---

## A Note Before You Start

This handbook is not a specification.

The specifications (SA-001 through SA-004) define *what* the architecture is. This handbook explains *why* it was built this way and *how to think* when you work inside it.

If you know Symfony but have never worked with Domain-Driven Design, this is your starting point.

Read it from start to finish the first time. After that, use it as a reference when a concept feels unclear.

By the end, you will understand:
- why the code is structured the way it is;
- why you can't just add a `$entityManager->persist()` call to a Controller;
- why there is no `ClinicalActivityService` with fifty methods;
- why reading and writing are handled differently;
- how a single user action travels through the entire system.

---

## Part I — The Big Picture

---

## Chapter 1 — Why MedLink Uses DDD

### The problem

Imagine you join a project and open the codebase. You find:

```
src/
├── Controller/
│   └── ClinicalController.php   (2400 lines)
├── Entity/
│   └── ClinicalActivity.php
├── Service/
│   └── ClinicalService.php      (1800 lines)
└── Repository/
    └── ClinicalActivityRepository.php
```

`ClinicalService` has methods like `createActivity()`, `validateContribution()`, `transferResponsibility()`, `archiveDraft()`, `generateSummary()`, `sendNotification()` and forty others.

To understand what "validating a contribution" means clinically, you have to read twelve hundred lines of code.

This is the traditional approach. It works for small applications. It becomes a nightmare when the domain is complex — and healthcare is extremely complex.

### What DDD brings

Domain-Driven Design is a way of building software where the code directly reflects the business reality it is modelling.

In MedLink, the rule "a Clinical Activity must always have exactly one responsible practitioner" is not buried inside a service method. It lives inside the `ClinicalActivity` object itself, enforced every time, everywhere, with no exceptions.

The code becomes a model of the real world.

### MedLink's clinical reality

MedLink organises the work of healthcare practitioners.

Practitioners:
- open Clinical Activities (consultations, follow-ups, assessments);
- produce Clinical Contributions (observations, diagnoses, prescriptions);
- transfer Clinical Responsibility to each other via explicit Handovers;
- build Clinical Knowledge over time.

These concepts have real rules. A Handover must be explicitly accepted. A Contribution cannot be modified once validated. A Clinical Activity cannot exist without a responsible practitioner.

These are not database constraints. They are business invariants — rules that are always true in the real world.

DDD is the technique that lets the code express and enforce these invariants directly.

---

## Part II — The Domain Layer

---

## Chapter 2 — What Is a Bounded Context?

### The concept

A Bounded Context is a part of the system that owns one coherent piece of the business.

Inside its boundary, it speaks its own language, enforces its own rules, and owns its own data. Nothing outside the boundary can reach inside directly.

### The analogy

Think of a hospital. The emergency department and the pharmacy are both part of the same hospital — but they operate independently. The emergency department does not walk into the pharmacy's stock room to grab medicines. They communicate through a formal process (a prescription).

Each department is a Bounded Context.

### MedLink's Bounded Contexts

The Clinical Platform has two Core Bounded Contexts.

```
+--------------------------+         +--------------------------+
|      Clinical Work       |         |    Clinical Knowledge    |
|                          |         |                          |
|  - ClinicalActivity      |         |  - ClinicalContribution  |
|  - ClinicalDraft         |  ─────▶ |  - CareRecord            |
|  - ClinicalHandover      |  event  |                          |
|  - ClinicalResponsibility|         |                          |
+--------------------------+         +--------------------------+
```

**Clinical Work** coordinates the active work of practitioners: who is responsible, what is in progress, what has been validated.

**Clinical Knowledge** preserves what has been validated for good: the clinical contributions that become part of the patient's permanent record.

They are separated because they have different lifecycles, different rules, and different reasons to change.

### Why separation matters

If Clinical Work and Clinical Knowledge were merged into one giant module, a change to how responsibility transfer works could accidentally break how contributions are archived.

Separation protects each context from the other's changes.

### Common mistake

Putting everything in one module because "they're related."

Everything in a healthcare system is related. That is not a reason to merge them. You separate by **ownership of rules**, not by data similarity.

---

## Chapter 3 — What Is an Aggregate?

### The concept

An Aggregate is a group of objects that belong together and must always be in a consistent state.

Every Aggregate has one **Aggregate Root** — the main object that controls everything inside the group. You can only interact with the Aggregate through the Root. You never reach inside to modify a sub-object directly.

### The analogy

Think of a car. A car has an engine, wheels, doors, a fuel tank. You don't remove the engine while the car is moving. You don't change a tyre while someone is driving.

The car itself is the Aggregate Root. All modifications happen through it, according to its rules. The car says: "you can change a tyre only when I'm stopped."

### MedLink's Aggregate: ClinicalActivity

`ClinicalActivity` is the main Aggregate Root in Clinical Work.

It owns:
- the current state (Open, InProgress, Closed);
- the current responsible practitioner;
- the list of Clinical Drafts in progress;
- the history of Handovers.

```
ClinicalActivity  (Aggregate Root)
    │
    ├── ClinicalDraft[]      (internal state)
    ├── ClinicalHandover[]   (history)
    └── ClinicalResponsibility  (current holder)
```

You never modify a `ClinicalDraft` directly from outside. You ask `ClinicalActivity` to do it:

```php
// ❌ Never do this
$draft->markAsComplete();

// ✓ Always go through the Aggregate Root
$clinicalActivity->validateDraft($draftId, $practitioner);
```

### Why this matters

The `ClinicalActivity` can check its own rules before allowing any change:
- "Is this draft still open?"
- "Does this practitioner have responsibility?"
- "Is the activity in a state that allows validation?"

If you bypass the Aggregate Root and modify objects directly, these checks never happen.

### Sequence: interacting with an Aggregate

```
Handler
    │
    │  load($activityId)
    ▼
Repository
    │  returns ClinicalActivity
    ▼
Handler
    │
    │  validateDraft($draftId, $practitioner)
    ▼
ClinicalActivity
    │  checks rules internally
    │  modifies internal state
    │  produces ClinicalActivityDraftValidated (Domain Event)
    ▼
Handler
    │  saves Aggregate + dispatches event
    ▼
Repository + Event Bus
```

---

## Chapter 4 — Why an Aggregate Protects Business Rules

### The problem it solves

Business rules in healthcare are non-negotiable. "A Clinical Activity must always have a responsible practitioner" is not a suggestion — it is a clinical safety requirement.

If this rule lives in a Service method, what happens when someone calls `$entityManager->persist($activity)` directly without going through the Service? The rule is bypassed.

If this rule lives inside the `ClinicalActivity` object itself, it cannot be bypassed. It runs every time, regardless of who calls the object.

### The analogy

A combination lock enforces its rule (the correct code) regardless of who is trying to open it. You cannot convince the lock to skip the check. You cannot call it "from the back."

An Aggregate is a combination lock for business rules.

### What invariants look like inside a MedLink Aggregate

```php
// Inside ClinicalActivity — Domain layer, zero Symfony
final class ClinicalActivity
{
    private ClinicalResponsibility $responsibility;
    private ClinicalActivityStatus $status;

    public function transferResponsibility(
        Practitioner $newHolder,
        ClinicalHandover $handover
    ): void {
        if (!$handover->isAccepted()) {
            throw new HandoverNotAcceptedException(
                'Responsibility can only transfer via an accepted Handover.'
            );
        }

        if ($this->status->isClosed()) {
            throw new ClinicalActivityClosedException(
                'Cannot transfer responsibility on a closed activity.'
            );
        }

        $this->responsibility = new ClinicalResponsibility($newHolder);
        $this->record(new ClinicalResponsibilityTransferred($this->id, $newHolder));
    }
}
```

These checks run every single time. No one can transfer responsibility without an accepted Handover. Ever.

### Common mistakes

**Mistake 1** — putting business rules in a Service:
```php
// ❌ The rule lives in the Service, not in the Aggregate
class ClinicalActivityService
{
    public function transferResponsibility($activityId, $practitionerId): void
    {
        $activity = $this->repository->find($activityId);
        // If someone calls persist() directly, this check is skipped
        if ($activity->getStatus() !== 'open') {
            throw new \Exception('...');
        }
        $activity->setResponsiblePractitioner($practitionerId);
    }
}
```

**Mistake 2** — public setters on the Aggregate:
```php
// ❌ This bypasses all protection
$activity->setStatus('closed');
$activity->setResponsiblePractitioner($practitioner);
```

### Best practice

The Aggregate Root has no public setters. All modifications happen through intention-revealing methods (`validateDraft()`, `transferResponsibility()`, `close()`). Each method enforces the rules before making any change.

---

## Chapter 5 — What Is a Repository?

### The concept

A Repository is how the Domain persists and retrieves Aggregates.

From the Domain's point of view, a Repository is just an interface — a contract. "Give me a `ClinicalActivity` by its ID. Save this `ClinicalActivity`. Give me all open activities for this practitioner."

The Domain does not know if data is stored in PostgreSQL, in memory, in a file, or anywhere else. It only knows the contract.

### The analogy

When you order something online, you don't care whether the item is stored in warehouse A, B, or C. You just say "give me product X" and it appears. The logistics system is invisible to you.

The Repository is the logistics system for your Aggregates.

### The two parts of a Repository

**In the Domain layer** — the contract (interface):

```php
// Domain/Repository/ClinicalActivityRepositoryInterface.php
interface ClinicalActivityRepositoryInterface
{
    public function findById(ClinicalActivityId $id): ?ClinicalActivity;
    public function findOpenByPractitioner(PractitionerId $id): array;
    public function save(ClinicalActivity $activity): void;
}
```

**In the Infrastructure layer** — the implementation:

```php
// Infrastructure/Persistence/ClinicalActivityRepository.php
final class ClinicalActivityRepository implements ClinicalActivityRepositoryInterface
{
    // Actual database code lives here
    // Domain never sees this class
}
```

### The key rule

**One Repository per Aggregate Root.**

`ClinicalActivity` has one Repository. `ClinicalHandover` does not have its own Repository — it is part of `ClinicalActivity` and is persisted through it.

---

## Chapter 6 — Why Repository Contracts Belong to the Domain

### The concept

The Repository *interface* lives in the Domain layer. The implementation lives in Infrastructure. This feels backwards at first — why would a persistence concept live in the Domain?

### The reason

The Domain defines what it needs. Infrastructure provides it.

This is called **dependency inversion**. The Domain does not depend on Infrastructure. Infrastructure depends on the Domain.

```
Domain defines:
    ClinicalActivityRepositoryInterface

Infrastructure provides:
    ClinicalActivityRepository implements ClinicalActivityRepositoryInterface

Application uses:
    ClinicalActivityRepositoryInterface (never the concrete class)
```

### The analogy

A restaurant defines what it needs from its supplier: "I need fresh vegetables, delivered daily, with a certificate of origin." The restaurant does not care which farm provides them, or how they are transported. The supplier adapts to the restaurant's requirements — not the other way around.

The Domain is the restaurant. Infrastructure is the supplier.

### What this means for testing

Because the Domain only knows the interface, you can swap the real database implementation for a simple in-memory implementation during tests:

```php
// In tests: InMemoryClinicalActivityRepository implements the same interface
// No database required — the Domain is completely isolated
```

### Common mistake

Injecting the concrete `ClinicalActivityRepository` (Infrastructure class) into a Handler or a Domain Service:

```php
// ❌ The Application layer now depends on Infrastructure directly
public function __construct(
    private ClinicalActivityRepository $repository  // concrete class — wrong
) {}

// ✓ Depend on the interface defined in the Domain
public function __construct(
    private ClinicalActivityRepositoryInterface $repository  // correct
) {}
```

---

## Part III — Commands and Use Cases

---

## Chapter 7 — What Is a Command?

### The concept

A Command is a message that says: "I want to do something."

It carries the data needed to perform the action. It has no return value. It does not fetch anything. It does not display anything. It simply expresses an intent.

### The analogy

When you call a hospital reception and say "I want to book an appointment for Wednesday at 10am with Dr. Dupont," you are issuing a Command. You are expressing an intent. You give the relevant data (day, time, doctor). You do not simultaneously ask to see the hospital's appointment book.

### What a Command looks like in MedLink

```php
// Application/Command/StartClinicalActivity.php
final class StartClinicalActivity
{
    public function __construct(
        public readonly PractitionerId $practitionerId,
        public readonly PatientId $patientId,
        public readonly ClinicalActivityType $type,
    ) {}
}
```

Three rules for Commands:
1. **Immutable** — the data does not change after creation.
2. **No logic** — a Command is just data.
3. **No return** — a Command does not return a result.

### The naming convention

Commands are named in the **imperative** — they express an order:

```
StartClinicalActivity
ValidateContribution
TransferResponsibility
CloseClinicalActivity
RequestClinicalHandover
AcceptClinicalHandover
```

### Common mistake

Putting logic in a Command:

```php
// ❌ A Command is just data — no methods, no logic
final class StartClinicalActivity
{
    public function validate(): bool  // No. This belongs in the Domain.
    {
        return $this->practitionerId !== null && $this->patientId !== null;
    }
}
```

---

## Chapter 8 — What Is a Handler?

### The concept

A Handler is the code that executes a Command.

It receives one Command, coordinates the Domain objects needed to execute it, and returns nothing.

The Handler is the **orchestrator** — it loads the Aggregate, calls the right method, saves the result. But it does not make business decisions itself. The Domain does that.

### The analogy

A Handler is like a nurse preparing a medical procedure. The nurse fetches the instruments, prepares the patient, calls the surgeon, and documents the result. The *surgeon* makes the medical decisions. The nurse orchestrates — the surgeon decides.

### What a Handler looks like in MedLink

```php
// Application/Handler/StartClinicalActivityHandler.php
final class StartClinicalActivityHandler
{
    public function __construct(
        private readonly ClinicalActivityRepositoryInterface $repository,
        private readonly EventBusInterface $eventBus,
    ) {}

    public function __invoke(StartClinicalActivity $command): void
    {
        // 1. Create the Aggregate — business rules are enforced inside
        $activity = ClinicalActivity::start(
            id: ClinicalActivityId::generate(),
            practitioner: new PractitionerId($command->practitionerId),
            patient: new PatientId($command->patientId),
            type: $command->type,
        );

        // 2. Save it
        $this->repository->save($activity);

        // 3. Dispatch Domain Events produced by the Aggregate
        foreach ($activity->pullDomainEvents() as $event) {
            $this->eventBus->dispatch($event);
        }
    }
}
```

Notice what the Handler does NOT do:
- It does not check if the practitioner is allowed (that's the Domain's job).
- It does not know how data is stored (that's Infrastructure's job).
- It does not return anything.

### The sequence

```
Controller (Presentation)
    │
    │  new StartClinicalActivity($practitionerId, $patientId, $type)
    ▼
Command Bus
    │
    ▼
StartClinicalActivityHandler
    │  1. ClinicalActivity::start(...)     → enforces invariants
    │  2. $repository->save($activity)    → persists
    │  3. dispatch(DomainEvents)          → triggers side effects
    ▼
Done
```

---

## Chapter 9 — Why One Handler Implements One Use Case

### The rule

One Handler handles exactly one Command (or one Query).

This is not a preference. It is an architectural decision: each Handler has a single, clear responsibility. You know exactly what it does by reading its name.

### The analogy

In a hospital, a cardiologist has one medical specialty. When you need heart surgery, you call the cardiologist. You do not call the "General Medical Handler" that does everything depending on a parameter.

`StartClinicalActivityHandler` starts a Clinical Activity. That is all it does. Nothing else.

### Why grouping Handlers is a trap

You might be tempted to write:

```php
// ❌ God Handler — too many responsibilities
class ClinicalActivityHandler
{
    public function handle(object $command): void
    {
        match(get_class($command)) {
            StartClinicalActivity::class  => $this->handleStart($command),
            CloseClinicalActivity::class  => $this->handleClose($command),
            // ... 10 more cases
        };
    }
}
```

Problems with this approach:
- Adding a new use case requires modifying this class (violates the Open/Closed Principle).
- The class grows indefinitely — it becomes the `ClinicalService` you were trying to avoid.
- Testing one use case requires loading all the dependencies for all the others.

### The right approach

```
StartClinicalActivity       → StartClinicalActivityHandler
CloseClinicalActivity       → CloseClinicalActivityHandler
ValidateContribution        → ValidateContributionHandler
RequestClinicalHandover     → RequestClinicalHandoverHandler
AcceptClinicalHandover      → AcceptClinicalHandoverHandler
```

Each Handler is a PHP class with a single `__invoke()` method. It is small, focused, and independently testable.

### Best practice

If you find yourself wanting to merge two Handlers, ask: "Are these really the same use case, or just similar?" They are almost always different use cases that happen to share some code. Extract the shared code into a Domain Service instead of merging the Handlers.

---

## Part IV — Events, Projections, and the Read Side

---

## Chapter 10 — What Is a Domain Event?

### The concept

A Domain Event is a record of something that happened inside the Domain.

It is always in the **past tense** — it records a fact, not an intention. It is **immutable** — once created, it cannot be changed. It is always **named after what happened**, not after what should happen next.

### The analogy

Think of a medical record. When a patient comes in, the nurse writes: "Patient arrived at 14:32." When the doctor examines them, another entry is added: "Examination completed at 15:00. Diagnosis: X."

Each entry is a fact that happened. It cannot be erased or modified. It is the history of what occurred.

Domain Events are the history of what happened inside your Aggregate.

### MedLink Domain Events

```php
// Domain/DomainEvent/ClinicalActivityStarted.php
final class ClinicalActivityStarted
{
    public function __construct(
        public readonly ClinicalActivityId $activityId,
        public readonly PractitionerId $responsiblePractitionerId,
        public readonly PatientId $patientId,
        public readonly \DateTimeImmutable $occurredAt,
    ) {}
}
```

```php
// Domain/DomainEvent/ClinicalContributionValidated.php
final class ClinicalContributionValidated
{
    public function __construct(
        public readonly ClinicalActivityId $activityId,
        public readonly ClinicalContributionId $contributionId,
        public readonly PractitionerId $validatedBy,
        public readonly \DateTimeImmutable $occurredAt,
    ) {}
}
```

### Where Domain Events come from

They are produced inside Aggregates, when something meaningful happens:

```php
final class ClinicalActivity
{
    private array $domainEvents = [];

    public static function start(...): self
    {
        $activity = new self(...);
        // Record what happened
        $activity->record(new ClinicalActivityStarted(
            activityId: $activity->id,
            responsiblePractitionerId: $practitionerId,
            patientId: $patientId,
            occurredAt: new \DateTimeImmutable(),
        ));
        return $activity;
    }

    private function record(object $event): void
    {
        $this->domainEvents[] = $event;
    }

    public function pullDomainEvents(): array
    {
        $events = $this->domainEvents;
        $this->domainEvents = [];
        return $events;
    }
}
```

### Who listens to Domain Events?

Within the same Platform, other Bounded Contexts and Projections listen to Domain Events and react:

```
ClinicalContributionValidated
    │
    ├──▶ Clinical Knowledge BC listens → archives the contribution
    │
    └──▶ Projection listens → updates the patient's timeline Read Model
```

### Common mistake

Using Domain Events to carry too much data — basically duplicating the entire Aggregate state:

```php
// ❌ Too much — Domain Events carry only what listeners need
final class ClinicalActivityStarted
{
    public function __construct(
        public readonly ClinicalActivity $entireActivity  // No. Use IDs, not objects.
    ) {}
}
```

Domain Events carry **identifiers and the minimal data needed by listeners**. Not entire objects.

---

## Chapter 11 — Domain Events vs Integration Events

### The fundamental difference

| | Domain Event | Integration Event |
|---|---|---|
| What it is | Internal fact within a Platform | Public announcement to other Platforms |
| Who sees it | BCs within the same Platform | Other Platforms only |
| What it contains | Internal Domain concepts | Stable public representation |
| Who owns it | The Bounded Context that produced it | The Platform Contract |

### The analogy

A **Domain Event** is like a note you pass to a colleague in the same office: "FYI — the patient arrived." Internal. Informal. Uses your team's vocabulary.

An **Integration Event** is like a press release sent to other hospitals: "Patient admitted under reference #12345." External. Formal. Uses a vocabulary others understand.

The same fact — patient arrived — is communicated differently depending on the audience.

### Why this separation is critical

If the Clinical Platform published its Domain Events directly to the Patient Engagement Platform, two problems occur:

1. **Coupling** — Patient Engagement now depends on Clinical's internal Domain model. If Clinical renames a concept, Patient Engagement breaks.
2. **Information leakage** — Internal clinical details that should not leave the Clinical Platform are exposed.

### The flow in MedLink

```
Clinical Work BC
    │
    │  produces: ClinicalContributionValidated (Domain Event)
    ▼
Integration Layer (Platform boundary)
    │
    │  translates to: ContributionMadeAvailable (Integration Event)
    │  contains only: contributionId, patientId, occurredAt
    ▼
Platform Contract (public surface)
    │
    ▼
Patient Engagement Platform (consumes Integration Event via ACL)
```

The Patient Engagement Platform never sees `ClinicalContributionValidated`. It only sees `ContributionMadeAvailable` — a clean, stable, public representation.

### Key rule

**Domain Events stay inside the Platform.**

**Integration Events are the only events that cross Platform boundaries.**

This rule is formalised in ADR-0014.

---

## Chapter 12 — What Is a Projection?

### The concept

A Projection is a component that listens to Domain Events and builds a Read Model from them.

Every time something relevant happens (a new Domain Event is dispatched), the Projection reacts and updates the data structure that will be used for reading.

### The analogy

Imagine a librarian (the Projection) who listens to everything that happens in the hospital. Every time a patient is admitted, the librarian updates the admissions register. Every time a doctor submits a diagnosis, the librarian updates the patient's folder.

The librarian never makes medical decisions. The librarian just maintains a well-organised, always-up-to-date record of everything that has happened.

### What a Projection looks like in MedLink

```php
// Infrastructure/Projection/PatientTimelineProjection.php
final class PatientTimelineProjection
{
    public function __construct(
        private readonly PatientTimelineReadModelRepository $readModelRepository,
    ) {}

    public function onClinicalActivityStarted(ClinicalActivityStarted $event): void
    {
        $this->readModelRepository->addEntry(
            patientId: $event->patientId,
            entry: new TimelineEntry(
                type: 'activity_started',
                activityId: $event->activityId,
                occurredAt: $event->occurredAt,
            )
        );
    }

    public function onClinicalContributionValidated(
        ClinicalContributionValidated $event
    ): void {
        $this->readModelRepository->addEntry(
            patientId: $event->patientId,
            entry: new TimelineEntry(
                type: 'contribution_validated',
                contributionId: $event->contributionId,
                occurredAt: $event->occurredAt,
            )
        );
    }
}
```

### Important rules for Projections

1. A Projection **never modifies an Aggregate**. It only builds Read Models.
2. A Projection **never enforces business rules**. It just records.
3. A Projection can be **rebuilt from scratch** at any time by replaying past events.
4. Read Models produced by Projections are **read-only**.

### Common mistake

Calling Aggregate methods from inside a Projection:

```php
// ❌ Projections never touch Aggregates
public function onContributionValidated(ClinicalContributionValidated $event): void
{
    $activity = $this->activityRepository->findById($event->activityId);
    $activity->doSomething();  // No. Never.
}
```

---

## Chapter 13 — What Is a Read Model?

### The concept

A Read Model is a data structure optimised for reading — for displaying information to users.

It is not a Domain object. It has no business rules. It cannot be modified directly. It is built by Projections and consumed by Queries.

### The analogy

Imagine a hospital dashboard on a wall screen showing "Current emergency patients: 7 — Average wait time: 23 minutes."

This display is not the source of truth. It is derived from the actual records in the system, updated continuously, optimised to be read quickly. If a screen breaks, you just regenerate it from the real records.

That is a Read Model.

### A MedLink Read Model

```php
// Infrastructure/ReadModel/PatientTimelineReadModel.php
final class PatientTimelineReadModel
{
    /** @param TimelineEntry[] $entries */
    public function __construct(
        public readonly PatientId $patientId,
        public readonly array $entries,
        public readonly \DateTimeImmutable $lastUpdatedAt,
    ) {}
}
```

This object:
- has no methods for modification;
- carries no business logic;
- is assembled by the Projection every time an event happens;
- is what the Query returns to the Controller.

### The key insight

Read Models can be shaped exactly for what the UI needs. If a screen needs patient name, last visit date, and active activity count — the Read Model carries exactly those three fields.

You do not load an entire `ClinicalActivity` Aggregate (with all its complex internal state) just to display a patient summary. You query a Read Model that already has the exact data ready.

This is why reads are fast.

### Common mistake

Using the Aggregate as a Read Model:

```php
// ❌ Loading the full Aggregate just to display data
$activity = $this->activityRepository->findById($id);
return $activity->getPatientName();  // The Aggregate is not a Read Model
```

---

## Chapter 14 — What Is a Query?

### The concept

A Query expresses a request for information. It is the read-side equivalent of a Command.

Where a Command says "do something," a Query says "give me something."

A Query **never modifies state**. It only reads. This is not just a convention — it is an architectural invariant.

### The analogy

When you call a hospital reception and ask "What time is my appointment on Wednesday?" you are issuing a Query. You are not changing anything. You just want information.

### What a Query looks like in MedLink

```php
// Application/Query/GetPatientTimeline.php
final class GetPatientTimeline
{
    public function __construct(
        public readonly PatientId $patientId,
        public readonly int $limit = 50,
    ) {}
}
```

### The Query Handler

```php
// Application/Handler/GetPatientTimelineHandler.php
final class GetPatientTimelineHandler
{
    public function __construct(
        private readonly PatientTimelineReadModelRepositoryInterface $repository,
    ) {}

    public function __invoke(GetPatientTimeline $query): PatientTimelineReadModel
    {
        return $this->repository->findByPatient($query->patientId, $query->limit);
    }
}
```

Notice what the Query Handler does NOT do:
- It does not load any Aggregate.
- It does not touch any business rule.
- It reads directly from the Read Model.
- It returns data.

### The sequence

```
Controller (Presentation)
    │
    │  new GetPatientTimeline($patientId)
    ▼
Query Bus
    │
    ▼
GetPatientTimelineHandler
    │
    │  reads from ReadModel repository
    ▼
PatientTimelineReadModel
    │
    ▼
Controller assembles ViewModel → Response
```

---

## Chapter 15 — Why Commands Never Return Read Models

### The rule

A Command produces no return value. A Query returns data but changes nothing. These two concerns are strictly separated.

This is the core of **CQRS** (Command Query Responsibility Segregation).

### Why this matters

Consider this common code in traditional applications:

```php
// ❌ Classic anti-pattern: create and return
public function createActivity(array $data): ClinicalActivityDTO
{
    $activity = new ClinicalActivity($data);
    $this->em->persist($activity);
    $this->em->flush();
    return $this->buildDTO($activity);  // Command AND Query in one
}
```

This looks convenient. But it creates tight coupling between:
- the write model (ClinicalActivity Aggregate with its invariants);
- the read model (the DTO the caller expects).

Now imagine you optimise your read model to serve the dashboard differently. You have to change the create method. A write operation is now coupled to a presentation concern.

### The alternative in MedLink

```php
// Write — creates the activity, returns nothing
$this->commandBus->dispatch(new StartClinicalActivity($practitionerId, $patientId, $type));

// Read — queries the Read Model, which was updated by a Projection reacting to the event
$timeline = $this->queryBus->dispatch(new GetPatientTimeline($patientId));
```

Each path is independent. The write path can change without affecting the read path. The read path can change without affecting the write path.

### Common question: "But then how does the frontend know the new ID?"

This comes up often. The answer depends on the use case:

1. **Generate the ID before sending the Command.** The frontend generates a UUID, sends it in the Command, and can use it immediately for a subsequent Query. No coupling needed.
2. **The user navigates to a list.** After creating an activity, the user sees the updated list — a Query returns the Read Model that was already updated by a Projection.
3. **Real-time update via Mercure.** The Projection publishes a Mercure event when the Read Model is updated. The frontend receives the update without polling.

### The key insight

In CQRS, the write side and the read side are **optimised independently**. Write side protects invariants. Read side delivers fast, shaped data. Mixing them degrades both.

---

## Part V — Bringing It All Together

---

## Chapter 16 — Complete MedLink Request Lifecycle

### The scenario

A practitioner opens MedLink and starts a new clinical activity with a patient. Let us follow every step of what happens in the system.

---

### Step 1 — The HTTP Request arrives

```
Browser
    │
    POST /api/v1/clinical/activities
    Body: { practitionerId, patientId, type }
    │
    ▼
Symfony Router
    │
    ▼
ClinicalActivityController (Presentation Layer)
```

The Controller is in the **Presentation** layer. Its only job is to receive the HTTP request, validate the input format, and dispatch a Command.

```php
// Presentation/Api/ClinicalActivityController.php
final class ClinicalActivityController
{
    public function __invoke(Request $request): JsonResponse
    {
        // 1. Deserialise and validate HTTP input
        $dto = $this->serializer->deserialize($request->getContent(), StartClinicalActivityInput::class, 'json');
        $this->validator->validate($dto);

        // 2. Create the Command
        $command = new StartClinicalActivity(
            practitionerId: new PractitionerId($dto->practitionerId),
            patientId: new PatientId($dto->patientId),
            type: ClinicalActivityType::from($dto->type),
        );

        // 3. Dispatch — no return value
        $this->commandBus->dispatch($command);

        return new JsonResponse(['status' => 'accepted'], 202);
    }
}
```

The Controller knows nothing about the Domain. It does not know what a `ClinicalActivity` is. It knows about HTTP.

---

### Step 2 — The Command travels to the Handler

```
CommandBus
    │
    ▼
StartClinicalActivityHandler (Application Layer)
```

The Handler is in the **Application** layer. It coordinates Domain objects.

```php
// Application/Handler/StartClinicalActivityHandler.php
final class StartClinicalActivityHandler
{
    public function __invoke(StartClinicalActivity $command): void
    {
        // Create the Aggregate — business rules enforced inside
        $activity = ClinicalActivity::start(
            id: ClinicalActivityId::generate(),
            practitioner: $command->practitionerId,
            patient: $command->patientId,
            type: $command->type,
        );

        // Persist
        $this->repository->save($activity);

        // Dispatch Domain Events produced by the Aggregate
        foreach ($activity->pullDomainEvents() as $event) {
            $this->eventBus->dispatch($event);
        }
    }
}
```

---

### Step 3 — The Aggregate enforces the rules

```
ClinicalActivity::start() (Domain Layer)
    │
    │  Checks: is this a valid practitioner? valid patient?
    │  Enforces: the activity starts with exactly one responsible practitioner
    │  Produces: ClinicalActivityStarted (Domain Event)
    ▼
Domain Event added to internal event list
```

The Domain layer has no knowledge of HTTP, Symfony, or databases. It just enforces business rules and records what happened.

---

### Step 4 — Infrastructure persists the Aggregate

```
ClinicalActivityRepository (Infrastructure Layer)
    │
    │  Translates Aggregate to database representation
    │  Persists via database adapter
    ▼
Database (PostgreSQL)
```

The Infrastructure layer knows about PostgreSQL. The Domain does not.

---

### Step 5 — Domain Events are dispatched

```
EventBus
    │
    │  ClinicalActivityStarted dispatched
    │
    ├──▶ PatientTimelineProjection
    │        │  Adds entry to patient timeline Read Model
    │
    └──▶ WorkflowProjection
             │  Adds activity to practitioner's workflow Read Model
```

Projections react to the Domain Event asynchronously. They update their Read Models.

---

### Step 6 — The frontend reads the updated state

A few milliseconds later, the frontend queries the patient's timeline:

```
Browser
    │
    GET /api/v1/clinical/patients/{patientId}/timeline
    │
    ▼
ClinicalTimelineController (Presentation Layer)
    │
    ▼
GetPatientTimeline (Query)
    │
    ▼
GetPatientTimelineHandler (Application Layer)
    │
    ▼
PatientTimelineReadModel (Infrastructure — Read Model)
    │
    ▼
ViewModel assembled
    │
    ▼
JSON Response
```

The timeline Read Model already contains the new activity — the Projection updated it in Step 5.

---

### The complete lifecycle diagram

```
  Browser
      │
      │ POST /api/v1/clinical/activities
      ▼
  ┌─────────────────────────────────────────────┐
  │              PRESENTATION LAYER             │
  │                                             │
  │  ClinicalActivityController                 │
  │  - deserialise HTTP input                   │
  │  - create Command                           │
  └───────────────┬─────────────────────────────┘
                  │ StartClinicalActivity (Command)
                  ▼
  ┌─────────────────────────────────────────────┐
  │              APPLICATION LAYER              │
  │                                             │
  │  StartClinicalActivityHandler               │
  │  - coordinates Domain                       │
  │  - calls Repository                         │
  │  - dispatches Domain Events                 │
  └──────┬────────────────────┬─────────────────┘
         │                    │
         ▼                    ▼
  ┌──────────────┐    ┌───────────────────────────┐
  │  DOMAIN      │    │     INFRASTRUCTURE        │
  │  LAYER       │    │                           │
  │              │    │  Repository persists       │
  │  Aggregate   │    │  Projection updates        │
  │  enforces    │    │  Read Models               │
  │  invariants  │    │                           │
  │  produces    │    │                           │
  │  DomainEvents│    │                           │
  └──────────────┘    └───────────────────────────┘

  Later:

  Browser
      │
      │ GET /api/v1/clinical/patients/{id}/timeline
      ▼
  ┌─────────────────────────────────────────────┐
  │              PRESENTATION LAYER             │
  └───────────────┬─────────────────────────────┘
                  │ GetPatientTimeline (Query)
                  ▼
  ┌─────────────────────────────────────────────┐
  │              APPLICATION LAYER              │
  │  GetPatientTimelineHandler                  │
  └───────────────┬─────────────────────────────┘
                  │
                  ▼
  ┌─────────────────────────────────────────────┐
  │              INFRASTRUCTURE                 │
  │  PatientTimelineReadModel (already updated) │
  └─────────────────────────────────────────────┘
                  │
                  ▼
              Response to Browser
```

---

## Summary: The Rules You Cannot Break

After reading this handbook, you understand why these rules exist.

| Rule | Why |
|---|---|
| Business rules live inside Aggregates | They cannot be bypassed — no public setters, no external modifications |
| Repository interface belongs to Domain | The Domain defines what it needs; Infrastructure provides it |
| One Handler, one Use Case | Each Handler has one responsibility, one reason to change |
| Commands have no return value | Write side and read side are independent |
| Queries never touch Aggregates | Reads come from Read Models — fast, shaped, always ready |
| Domain Events stay inside the Platform | Exposing them would couple other Platforms to internal Domain models |
| Integration Events cross Platform boundaries | They are stable, public, intentional contracts |

---

## What to Read Next

| Document | What it covers |
|---|---|
| SA-001 | The reference architecture — the complete layered model |
| SA-002 | How Platforms are structured and how they communicate |
| SA-003 | The internal architecture of every Bounded Context |
| SA-004 | How Symfony implements all of the above |
| EH-002 | *(Coming soon)* Writing your first Command and Handler in MedLink |
| EH-003 | *(Coming soon)* Writing your first Projection and Read Model |

---

## Glossary

| Term | Definition |
|---|---|
| Aggregate | A group of Domain objects forming a consistency boundary, controlled by an Aggregate Root |
| Aggregate Root | The main object of an Aggregate — the only entry point for modifications |
| Bounded Context | A software module owning one coherent business responsibility |
| Command | A message expressing the intent to modify business state — no return value |
| Domain Event | An immutable record of a fact that happened inside the Domain |
| Handler | Executes exactly one Command or one Query |
| Integration Event | An event published to other Platforms via the Platform Contract |
| Invariant | A business rule that is always true and enforced by the Aggregate |
| Port | An interface in the Domain or Application layer defining a dependency |
| Projection | A component that builds Read Models by reacting to Domain Events |
| Query | A request for data — never modifies state |
| Read Model | A data structure optimised for reading, built by Projections |
| Repository | The persistence contract for an Aggregate — interface in Domain, implementation in Infrastructure |
| Use Case | A single action a user (or system) performs — implemented by one Handler |
| Value Object | An immutable Domain concept — equality based on value, not identity |
| ViewModel | A read-only data structure assembled for rendering in the UI |
