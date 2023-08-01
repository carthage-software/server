<?php

declare(strict_types=1);

namespace Carthage\Application\MetricCollection\Service\Summary;

use Carthage\Application\MetricCollection\Command\Summary\CreateSummaryDataPointCommand;
use Carthage\Application\Shared\CommandBusInterface;
use Carthage\Domain\MetricCollection\DataTransferObject\Summary\CollectSummary;
use Carthage\Domain\MetricCollection\Event\Summary\SummaryCreatedEvent;
use Carthage\Domain\MetricCollection\Repository\Summary\SummaryRepositoryInterface;
use Carthage\Domain\MetricCollection\Service\Summary\SummaryService;
use Psr\EventDispatcher\EventDispatcherInterface;

final readonly class SummaryCollector
{
    public function __construct(
        private SummaryService $summaryService,
        private SummaryRepositoryInterface $summaryRepository,
        private EventDispatcherInterface $eventDispatcher,
        private CommandBusInterface $commandBus,
    ) {
    }

    public function collectSummary(CollectSummary $collectSum): void
    {
        $summary = $this->summaryRepository->findOneWithNameInNamespace(
            $collectSum->summary->name,
            $collectSum->summary->namespace,
        );

        if (null === $summary) {
            $summary = $this->summaryService->createSummary($collectSum->summary);

            $this->eventDispatcher->dispatch(new SummaryCreatedEvent($summary->getIdentity()));
        }

        foreach ($collectSum->dataPoints as $dataPoint) {
            $this->commandBus->dispatch(
                new CreateSummaryDataPointCommand($dataPoint->toCreateSummaryDataPoint($summary)),
            );
        }
    }
}
