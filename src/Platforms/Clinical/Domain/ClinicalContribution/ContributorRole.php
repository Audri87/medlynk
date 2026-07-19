<?php

declare(strict_types=1);

namespace App\Platforms\Clinical\Domain\ClinicalContribution;

use App\Platforms\Clinical\Domain\ClinicalContribution\ValueObject\ContributorRoleType;
use App\Platforms\Clinical\Domain\ClinicalContribution\ValueObject\PractitionerId;

/**
 * Entity within the ClinicalContribution aggregate — per ADR-0007 (Roles on Relations).
 *
 * Single responsibility: capture the role the Contributing Practitioner held
 * at the exact moment of contribution creation. Role is a property of the
 * relationship between a Practitioner and this Clinical Contribution,
 * not a property of the Practitioner identity itself (ADR-0007).
 *
 * No independent lifecycle. Not persisted separately. Owned exclusively by
 * ClinicalContribution.
 *
 * Why an Entity and not a Value Object: the (practitionerId, role) pair has
 * positional identity within the Aggregate — it is the contributor relationship,
 * not an exchangeable value.
 *
 * getPractitionerId() is required by the Aggregate to enforce BI-007:
 * the approving practitioner must differ from the contributing practitioner.
 */
final class ContributorRole
{
    public function __construct(
        private readonly PractitionerId $practitionerId,
        private readonly ContributorRoleType $role,
    ) {}

    public function getPractitionerId(): PractitionerId
    {
        return $this->practitionerId;
    }

    public function getRole(): ContributorRoleType
    {
        return $this->role;
    }
}
