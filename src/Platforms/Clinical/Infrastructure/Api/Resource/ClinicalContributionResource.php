<?php

declare(strict_types=1);

namespace App\Platforms\Clinical\Infrastructure\Api\Resource;

/**
 * API Platform DTO — Infrastructure layer, Presentation boundary.
 *
 * Single responsibility: represent a Clinical Contribution over HTTP.
 * Not a Domain object. Not a Read Model. Maps to HTTP request/response shape only.
 *
 * Consumed by: ClinicalContributionStateProcessor (writes), PatientTimelineStateProvider (reads).
 * Does not expose Domain Model types — wire format only.
 */
final class ClinicalContributionResource
{
    public ?string $id = null;
    public ?string $careRecordId = null;
    public ?string $contributingPractitionerId = null;
    public ?string $clinicalText = null;
    public ?string $status = null;
    public ?string $approvingPractitionerId = null;
    public ?\DateTimeImmutable $createdAt = null;
    public ?\DateTimeImmutable $approvedAt = null;
}
