<?php

declare(strict_types=1);

namespace App\Platforms\Clinical\Domain\ClinicalContribution;

use App\Platforms\Clinical\Domain\ClinicalContribution\Event\ClinicalContributionApproved;
use App\Platforms\Clinical\Domain\ClinicalContribution\Event\ClinicalContributionCreated;
use App\Platforms\Clinical\Domain\ClinicalContribution\Event\ClinicalContributionValidated;
use App\Platforms\Clinical\Domain\ClinicalContribution\Exception\ContributionNotInDraftException;
use App\Platforms\Clinical\Domain\ClinicalContribution\Exception\ContributionNotValidatedException;
use App\Platforms\Clinical\Domain\ClinicalContribution\Exception\SelfApprovalAttemptedException;
use App\Platforms\Clinical\Domain\ClinicalContribution\ValueObject\ApprovalReference;
use App\Platforms\Clinical\Domain\ClinicalContribution\ValueObject\CareRecordId;
use App\Platforms\Clinical\Domain\ClinicalContribution\ValueObject\ClinicalContributionId;
use App\Platforms\Clinical\Domain\ClinicalContribution\ValueObject\ClinicalText;
use App\Platforms\Clinical\Domain\ClinicalContribution\ValueObject\ContributionStatus;
use App\Platforms\Clinical\Domain\ClinicalContribution\ValueObject\ContributionTimestamp;
use App\Platforms\Clinical\Domain\ClinicalContribution\ValueObject\ContributorRoleType;
use App\Platforms\Clinical\Domain\ClinicalContribution\ValueObject\PractitionerId;

/**
 * Aggregate Root — Clinical Platform, ClinicalContribution Bounded Context.
 *
 * Single responsibility: enforce the complete lifecycle of one Clinical Contribution —
 * from creation through validation to approval — and record a Domain Event at each
 * state transition.
 *
 * States: Draft → Validated → Approved (transitions are one-directional and irreversible).
 *
 * ─── What this class does ────────────────────────────────────────────────────────
 *  — Guards all business invariants (BI-001 through BI-007).
 *  — Records Domain Events for every state transition.
 *  — Exposes pullPendingEvents() for the Application Runtime to collect after commit.
 *
 * ─── What this class does NOT do ─────────────────────────────────────────────────
 *  — Does not persist itself. Persistence is delegated to ClinicalContributionRepository.
 *  — Does not publish Domain Events. The Application Runtime publishes after commit.
 *  — Does not know the transaction that wraps its operations.
 *  — Does not depend on Infrastructure, Application, or any persistence technology.
 *  — Does not load related aggregates (CareRecord, Practitioner).
 *
 * ─── Business Invariants ─────────────────────────────────────────────────────────
 *  BI-001  ClinicalText must not be empty at creation.         (enforced by ClinicalText VO)
 *  BI-002  CareRecordId must be a valid identifier.             (enforced by CareRecordId VO)
 *  BI-003  ContributingPractitionerId must be a valid identifier.(enforced by PractitionerId VO)
 *  BI-004  validate() may only be called when status is Draft.
 *  BI-005  approve() may only be called when status is Validated.
 *  BI-006  An Approved contribution is immutable — no further transitions.
 *  BI-007  The approving practitioner must differ from the contributing practitioner.
 *
 * BI-001 through BI-003 are enforced at Value Object construction. They cannot be
 * violated at the Aggregate level because invalid values can never reach this class.
 * BI-004 through BI-007 are state-machine invariants enforced by this class directly.
 */
final class ClinicalContribution
{
    /** @var object[] */
    private array $pendingEvents = [];

    private ClinicalContributionId $id;
    private CareRecordId $careRecordId;
    private ContributionStatus $status;
    private ClinicalContent $content;
    private ContributorRole $contributorRole;
    private ?ApprovalReference $approvalReference = null;

    private function __construct() {}

    /**
     * Factory operation — UC-001 (Create Clinical Contribution).
     *
     * Business intention: record a new clinical observation against a Care Record,
     * attributing it to a practitioner in a defined role.
     *
     * Protected invariants: BI-001, BI-002, BI-003 are enforced by Value Object
     * construction before this method body executes. No invalid state can be assembled.
     *
     * Emits: ClinicalContributionCreated — carries all projection-relevant data.
     * Projections consume this event to append a new entry to the Patient Timeline
     * and create a Detail record.
     *
     * Why this responsibility belongs inside the Aggregate: creating a contribution
     * is not a data-assembly operation. It is a domain act — establishing a new
     * clinical fact against a patient record. Only the Aggregate can determine
     * whether the inputs form a coherent domain object and record the corresponding fact.
     *
     * Why a static factory and not a public constructor: the private constructor
     * ensures no ClinicalContribution can be instantiated outside this factory.
     * It prevents partial construction and guarantees that every instance enters
     * existence in a defined, event-recorded state.
     */
    public static function create(
        ClinicalContributionId $id,
        CareRecordId $careRecordId,
        PractitionerId $contributingPractitionerId,
        ContributorRoleType $contributorRoleType,
        ClinicalText $clinicalText,
        ContributionTimestamp $createdAt,
    ): self {
        $contribution = new self();
        $contribution->id = $id;
        $contribution->careRecordId = $careRecordId;
        $contribution->status = ContributionStatus::Draft;
        $contribution->content = new ClinicalContent($clinicalText, $createdAt);
        $contribution->contributorRole = new ContributorRole($contributingPractitionerId, $contributorRoleType);

        $contribution->record(new ClinicalContributionCreated(
            clinicalContributionId: $id,
            careRecordId: $careRecordId,
            contributingPractitionerId: $contributingPractitionerId,
            clinicalText: $clinicalText,
            occurredAt: $createdAt,
        ));

        return $contribution;
    }

    /**
     * State transition: Draft → Validated — UC-002 (Validate Clinical Contribution).
     *
     * Business intention: confirm that this contribution satisfies all domain invariants
     * and is ready for formal approval by an authorised practitioner.
     *
     * Protected invariant: BI-004 — validation may only be attempted in Draft state.
     * Calling validate() on a Validated or Approved contribution is a workflow error.
     *
     * Emits (success): ClinicalContributionValidated.
     * Emits (failure): ClinicalContributionValidationFailed with a failure reason.
     *
     * Current implementation: all domain invariants are enforced at construction by
     * Value Objects. A Draft contribution that exists has already passed BI-001 through
     * BI-003. Validation therefore always succeeds for a well-formed Draft.
     *
     * The ValidationFailed path is preserved in the domain model for future validation
     * rules — e.g., cross-aggregate consistency checks introduced by subsequent
     * domain engineering decisions. Extending validate() with additional rules
     * does not change its signature or callers.
     *
     * Why this responsibility belongs inside the Aggregate: the Aggregate is the sole
     * authority over its own invariants. No external service should be able to advance
     * a contribution to Validated without the Aggregate's explicit consent.
     */
    public function validate(ContributionTimestamp $validatedAt): void
    {
        if ($this->status !== ContributionStatus::Draft) {
            throw new ContributionNotInDraftException($this->id, $this->status);
        }

        // All structural invariants (BI-001, BI-002, BI-003) were enforced at construction.
        // A Draft contribution that reached this point is structurally coherent.
        // Future domain validation rules extend this section.
        $this->status = ContributionStatus::Validated;

        $this->record(new ClinicalContributionValidated(
            clinicalContributionId: $this->id,
            careRecordId: $this->careRecordId,
            occurredAt: $validatedAt,
        ));
    }

    /**
     * State transition: Validated → Approved — UC-003 (Approve Clinical Contribution).
     *
     * Business intention: formally endorse a Validated contribution. From this moment,
     * the contribution is an immutable part of the clinical record.
     *
     * Protected invariants:
     *  BI-005 — approval may only be attempted when status is Validated.
     *           Draft contributions have not passed domain checks; approving them
     *           would bypass the validation gate. Approved contributions cannot
     *           be re-approved (BI-006 — immutability is enforced by BI-005 here,
     *           since Approved ≠ Validated).
     *  BI-007 — the approving practitioner must differ from the contributing practitioner.
     *           A practitioner cannot be the sole authority on their own clinical contribution.
     *           Independent review is a clinical safety invariant.
     *
     * Emits: ClinicalContributionApproved — signals immutability and carries approver data.
     * Downstream projections update the Patient Timeline and Detail Read Models.
     * The WorkspaceProjection refreshes the Practitioner Workspace.
     *
     * Why this responsibility belongs inside the Aggregate: approval is a domain act —
     * a formal clinical endorsement — not a data update. The Aggregate is the sole
     * entity that can enforce both the state precondition and the identity constraint
     * atomically, without risk of partial enforcement.
     *
     * Note on BI-007: RVS-001 marks this rule as pending. Current enforcement
     * (self-approval is prohibited) represents the conservative clinical safety
     * position. If the domain rule is relaxed, only this method changes.
     */
    public function approve(PractitionerId $approvingPractitionerId, ContributionTimestamp $approvedAt): void
    {
        if ($this->status !== ContributionStatus::Validated) {
            throw new ContributionNotValidatedException($this->id, $this->status);
        }

        if ($this->contributorRole->getPractitionerId()->value === $approvingPractitionerId->value) {
            throw new SelfApprovalAttemptedException($this->id, $approvingPractitionerId);
        }

        $this->approvalReference = new ApprovalReference($approvingPractitionerId, $approvedAt);
        $this->status = ContributionStatus::Approved;

        $this->record(new ClinicalContributionApproved(
            clinicalContributionId: $this->id,
            careRecordId: $this->careRecordId,
            approvingPractitionerId: $approvingPractitionerId,
            approvedAt: $approvedAt,
        ));
    }

    /**
     * Returns and clears all pending Domain Events.
     *
     * Called exclusively by the Application Runtime after the transaction commits.
     * The Runtime publishes the returned events to the Internal Event Bus.
     *
     * Pending events are discarded (not queued or deferred) if the transaction rolls
     * back. This is a structural guarantee: events are only observable after commit.
     * An event pending in this array before commit does not exist in the system.
     *
     * @return object[]
     */
    public function pullPendingEvents(): array
    {
        $events = $this->pendingEvents;
        $this->pendingEvents = [];

        return $events;
    }

    public function getId(): ClinicalContributionId
    {
        return $this->id;
    }

    public function getStatus(): ContributionStatus
    {
        return $this->status;
    }

    private function record(object $event): void
    {
        $this->pendingEvents[] = $event;
    }
}
