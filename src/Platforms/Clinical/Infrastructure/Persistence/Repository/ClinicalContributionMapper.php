<?php

declare(strict_types=1);

namespace App\Platforms\Clinical\Infrastructure\Persistence\Repository;

use App\Platforms\Clinical\Domain\ClinicalContribution\ClinicalContent;
use App\Platforms\Clinical\Domain\ClinicalContribution\ClinicalContribution;
use App\Platforms\Clinical\Domain\ClinicalContribution\ContributorRole;
use App\Platforms\Clinical\Domain\ClinicalContribution\ValueObject\ApprovalReference;
use App\Platforms\Clinical\Domain\ClinicalContribution\ValueObject\CareRecordId;
use App\Platforms\Clinical\Domain\ClinicalContribution\ValueObject\ClinicalContributionId;
use App\Platforms\Clinical\Domain\ClinicalContribution\ValueObject\ClinicalText;
use App\Platforms\Clinical\Domain\ClinicalContribution\ValueObject\ContributionStatus;
use App\Platforms\Clinical\Domain\ClinicalContribution\ValueObject\ContributionTimestamp;
use App\Platforms\Clinical\Domain\ClinicalContribution\ValueObject\ContributorRoleType;
use App\Platforms\Clinical\Domain\ClinicalContribution\ValueObject\PractitionerId;

/**
 * Translates between ClinicalContribution Aggregate state and its DBAL persistence representation.
 *
 * Authorized by ADR-SA-009 D-003: "Repository implementations MAY delegate translation
 * to internal components within the Infrastructure layer."
 * Justified by ADR-SA-008 D-006: mapping involves nested Reflection across 6 domain objects,
 * non-backed enum reconstitution, and UTC normalization — complex enough to warrant isolation.
 *
 * Uses ReflectionProperty to read and write private Aggregate state.
 * The Domain is never modified to expose persistence accessors.
 */
final class ClinicalContributionMapper
{
    /**
     * Extracts Aggregate state as a flat DBAL parameter array.
     * All DateTimeImmutable values are serialised to ISO 8601 (UTC).
     *
     * @return array<string, string|null>
     */
    public function toPersistence(ClinicalContribution $contribution): array
    {
        $ref = new \ReflectionClass($contribution);

        /** @var ClinicalContributionId $id */
        $id = $ref->getProperty('id')->getValue($contribution);
        /** @var CareRecordId $careRecordId */
        $careRecordId = $ref->getProperty('careRecordId')->getValue($contribution);
        /** @var ContributionStatus $status */
        $status = $ref->getProperty('status')->getValue($contribution);
        /** @var ClinicalContent $content */
        $content = $ref->getProperty('content')->getValue($contribution);
        /** @var ContributorRole $contributorRole */
        $contributorRole = $ref->getProperty('contributorRole')->getValue($contribution);
        /** @var ApprovalReference|null $approvalReference */
        $approvalReference = $ref->getProperty('approvalReference')->getValue($contribution);

        $contentRef = new \ReflectionClass($content);
        /** @var ClinicalText $clinicalText */
        $clinicalText = $contentRef->getProperty('text')->getValue($content);
        /** @var ContributionTimestamp $recordedAt */
        $recordedAt = $contentRef->getProperty('recordedAt')->getValue($content);

        $roleRef = new \ReflectionClass($contributorRole);
        /** @var PractitionerId $practitionerId */
        $practitionerId = $roleRef->getProperty('practitionerId')->getValue($contributorRole);
        /** @var ContributorRoleType $roleType */
        $roleType = $roleRef->getProperty('role')->getValue($contributorRole);

        $params = [
            'id'                           => $id->value,
            'care_record_id'               => $careRecordId->value,
            'status'                       => $this->encodeStatus($status),
            'clinical_text'                => $clinicalText->value,
            'recorded_at'                  => $recordedAt->value->format(\DateTimeInterface::ATOM),
            'contributing_practitioner_id' => $practitionerId->value,
            'contributor_role'             => $this->encodeRole($roleType),
            'approving_practitioner_id'    => null,
            'approved_at'                  => null,
        ];

        if ($approvalReference !== null) {
            $params['approving_practitioner_id'] = $approvalReference->approvingPractitionerId->value;
            $params['approved_at'] = $approvalReference->approvedAt->value->format(\DateTimeInterface::ATOM);
        }

        return $params;
    }

    /**
     * Reconstitutes a ClinicalContribution from a DBAL result row.
     * Bypasses the private constructor via newInstanceWithoutConstructor().
     * Writes all private fields via ReflectionProperty.
     *
     * @param array<string, mixed> $row
     */
    public function toDomain(array $row): ClinicalContribution
    {
        $contribution = (new \ReflectionClass(ClinicalContribution::class))
            ->newInstanceWithoutConstructor();

        $ref = new \ReflectionClass($contribution);

        $ref->getProperty('id')->setValue(
            $contribution,
            new ClinicalContributionId($row['id']),
        );
        $ref->getProperty('careRecordId')->setValue(
            $contribution,
            new CareRecordId($row['care_record_id']),
        );
        $ref->getProperty('status')->setValue(
            $contribution,
            $this->decodeStatus($row['status']),
        );
        $ref->getProperty('content')->setValue(
            $contribution,
            new ClinicalContent(
                new ClinicalText($row['clinical_text']),
                new ContributionTimestamp($this->toUtcDateTime($row['recorded_at'])),
            ),
        );
        $ref->getProperty('contributorRole')->setValue(
            $contribution,
            new ContributorRole(
                new PractitionerId($row['contributing_practitioner_id']),
                $this->decodeRole($row['contributor_role']),
            ),
        );
        $ref->getProperty('approvalReference')->setValue($contribution, null);

        if ($row['approving_practitioner_id'] !== null) {
            $ref->getProperty('approvalReference')->setValue(
                $contribution,
                new ApprovalReference(
                    new PractitionerId($row['approving_practitioner_id']),
                    new ContributionTimestamp($this->toUtcDateTime($row['approved_at'])),
                ),
            );
        }

        return $contribution;
    }

    private function encodeStatus(ContributionStatus $status): string
    {
        return match ($status) {
            ContributionStatus::Draft     => 'draft',
            ContributionStatus::Validated => 'validated',
            ContributionStatus::Approved  => 'approved',
        };
    }

    private function decodeStatus(string $value): ContributionStatus
    {
        return match ($value) {
            'draft'     => ContributionStatus::Draft,
            'validated' => ContributionStatus::Validated,
            'approved'  => ContributionStatus::Approved,
            default     => throw new \UnexpectedValueException(
                sprintf('Unknown ContributionStatus value "%s" in persistence store.', $value),
            ),
        };
    }

    private function encodeRole(ContributorRoleType $role): string
    {
        return match ($role) {
            ContributorRoleType::PrimaryPractitioner     => 'primary_practitioner',
            ContributorRoleType::ConsultingPractitioner  => 'consulting_practitioner',
            ContributorRoleType::SupervisingPractitioner => 'supervising_practitioner',
        };
    }

    private function decodeRole(string $value): ContributorRoleType
    {
        return match ($value) {
            'primary_practitioner'     => ContributorRoleType::PrimaryPractitioner,
            'consulting_practitioner'  => ContributorRoleType::ConsultingPractitioner,
            'supervising_practitioner' => ContributorRoleType::SupervisingPractitioner,
            default                    => throw new \UnexpectedValueException(
                sprintf('Unknown ContributorRoleType value "%s" in persistence store.', $value),
            ),
        };
    }

    private function toUtcDateTime(string $value): \DateTimeImmutable
    {
        return (new \DateTimeImmutable($value))->setTimezone(new \DateTimeZone('UTC'));
    }
}
