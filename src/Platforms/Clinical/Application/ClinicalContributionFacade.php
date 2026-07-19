<?php

declare(strict_types=1);

namespace App\Platforms\Clinical\Application;

use App\Platforms\Clinical\Application\Command\ApproveClinicalContribution;
use App\Platforms\Clinical\Application\Command\CreateClinicalContribution;
use App\Platforms\Clinical\Application\Command\ValidateClinicalContribution;
use App\Platforms\Clinical\Application\Query\GetClinicalContributionDetail;
use App\Platforms\Clinical\Application\Query\GetPatientTimeline;
use App\Platforms\Clinical\Application\ReadModel\ClinicalContributionDetailView;
use App\Platforms\Clinical\Application\ReadModel\PatientTimelineView;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

/**
 * Application Facade — single entry point for all use cases in this Bounded Context.
 *
 * Single responsibility: dispatch Commands to command.bus and Queries to query.bus.
 * Contains NO business logic. Contains NO persistence logic. Contains NO event logic.
 *
 * Consumed by: Infrastructure/Api/ StateProcessors and StateProviders.
 * Never consumed by: Domain classes, other Application classes, Projections.
 */
final class ClinicalContributionFacade
{
    public function __construct(
        private readonly MessageBusInterface $commandBus,
        private readonly MessageBusInterface $queryBus,
    ) {}

    public function createContribution(CreateClinicalContribution $command): void
    {
        $this->commandBus->dispatch($command);
    }

    public function validateContribution(ValidateClinicalContribution $command): void
    {
        $this->commandBus->dispatch($command);
    }

    public function approveContribution(ApproveClinicalContribution $command): void
    {
        $this->commandBus->dispatch($command);
    }

    public function getPatientTimeline(GetPatientTimeline $query): PatientTimelineView
    {
        return $this->queryBus->dispatch($query)->last(HandledStamp::class)->getResult();
    }

    public function getContributionDetail(GetClinicalContributionDetail $query): ClinicalContributionDetailView
    {
        return $this->queryBus->dispatch($query)->last(HandledStamp::class)->getResult();
    }
}
