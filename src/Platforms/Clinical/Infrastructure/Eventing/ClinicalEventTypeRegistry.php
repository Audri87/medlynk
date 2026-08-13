<?php

declare(strict_types=1);

namespace App\Platforms\Clinical\Infrastructure\Eventing;

use App\Platforms\Clinical\Domain\ClinicalContribution\Event\ClinicalContributionApproved;
use App\Platforms\Clinical\Domain\ClinicalContribution\Event\ClinicalContributionCreated;
use App\Platforms\Clinical\Domain\ClinicalContribution\Event\ClinicalContributionValidated;
use App\Platforms\Clinical\Domain\ClinicalContribution\Event\ClinicalContributionValidationFailed;
use App\Shared\Infrastructure\Eventing\EventTypeConfig;
use App\Shared\Infrastructure\Eventing\EventTypeResolver;

/**
 * Registers all Clinical Platform Domain Event type configurations.
 *
 * Owned by Clinical Infrastructure — each platform owns its own registry.
 * Consumed by EventTypeResolver (Shared Infrastructure).
 *
 * EventTypeConfig closures (aggregateIdExtractor, occurredAtExtractor, payloadExtractor)
 * are the only place where ClinicalContribution event field names are referenced outside
 * the Domain layer. If an event property is renamed, only its closure changes here.
 *
 * ClinicalContributionApproved uses $approvedAt (not $occurredAt) — this asymmetry
 * is intentional: approval time is a caller-supplied business input, not the Runtime clock.
 * See ApproveClinicalContributionHandler for the rationale.
 *
 * ADR-SA-013 R-038 / R-039: event type strings are stable identifiers, independent of
 * PHP class names. Renaming the PHP class does not change the event type string and
 * does not invalidate stored Outbox rows or downstream consumers.
 */
final class ClinicalEventTypeRegistry
{
    public static function createResolver(): EventTypeResolver
    {
        return new EventTypeResolver([
            ClinicalContributionCreated::class => new EventTypeConfig(
                eventClass: ClinicalContributionCreated::class,
                eventType: 'clinical.contribution.created',
                aggregateType: 'ClinicalContribution',
                eventVersion: '1.0',
                aggregateIdExtractor: static fn (ClinicalContributionCreated $e): string
                    => $e->clinicalContributionId->value,
                occurredAtExtractor: static fn (ClinicalContributionCreated $e): \DateTimeImmutable
                    => $e->occurredAt->value,
                payloadExtractor: static fn (ClinicalContributionCreated $e): array => [
                    'clinical_contribution_id'      => $e->clinicalContributionId->value,
                    'care_record_id'                => $e->careRecordId->value,
                    'contributing_practitioner_id'  => $e->contributingPractitionerId->value,
                    'clinical_text'                 => $e->clinicalText->value,
                    'occurred_at'                   => $e->occurredAt->value->format(\DateTimeInterface::ATOM),
                ],
            ),

            ClinicalContributionValidated::class => new EventTypeConfig(
                eventClass: ClinicalContributionValidated::class,
                eventType: 'clinical.contribution.validated',
                aggregateType: 'ClinicalContribution',
                eventVersion: '1.0',
                aggregateIdExtractor: static fn (ClinicalContributionValidated $e): string
                    => $e->clinicalContributionId->value,
                occurredAtExtractor: static fn (ClinicalContributionValidated $e): \DateTimeImmutable
                    => $e->occurredAt->value,
                payloadExtractor: static fn (ClinicalContributionValidated $e): array => [
                    'clinical_contribution_id' => $e->clinicalContributionId->value,
                    'care_record_id'           => $e->careRecordId->value,
                    'occurred_at'              => $e->occurredAt->value->format(\DateTimeInterface::ATOM),
                ],
            ),

            ClinicalContributionApproved::class => new EventTypeConfig(
                eventClass: ClinicalContributionApproved::class,
                eventType: 'clinical.contribution.approved',
                aggregateType: 'ClinicalContribution',
                eventVersion: '1.0',
                aggregateIdExtractor: static fn (ClinicalContributionApproved $e): string
                    => $e->clinicalContributionId->value,
                occurredAtExtractor: static fn (ClinicalContributionApproved $e): \DateTimeImmutable
                    => $e->approvedAt->value,
                payloadExtractor: static fn (ClinicalContributionApproved $e): array => [
                    'clinical_contribution_id'   => $e->clinicalContributionId->value,
                    'care_record_id'             => $e->careRecordId->value,
                    'approving_practitioner_id'  => $e->approvingPractitionerId->value,
                    'approved_at'                => $e->approvedAt->value->format(\DateTimeInterface::ATOM),
                ],
            ),

            ClinicalContributionValidationFailed::class => new EventTypeConfig(
                eventClass: ClinicalContributionValidationFailed::class,
                eventType: 'clinical.contribution.validation_failed',
                aggregateType: 'ClinicalContribution',
                eventVersion: '1.0',
                aggregateIdExtractor: static fn (ClinicalContributionValidationFailed $e): string
                    => $e->clinicalContributionId->value,
                occurredAtExtractor: static fn (ClinicalContributionValidationFailed $e): \DateTimeImmutable
                    => $e->occurredAt->value,
                payloadExtractor: static fn (ClinicalContributionValidationFailed $e): array => [
                    'clinical_contribution_id' => $e->clinicalContributionId->value,
                    'care_record_id'           => $e->careRecordId->value,
                    'failure_reason'           => $e->failureReason,
                    'occurred_at'              => $e->occurredAt->value->format(\DateTimeInterface::ATOM),
                ],
            ),
        ]);
    }
}
