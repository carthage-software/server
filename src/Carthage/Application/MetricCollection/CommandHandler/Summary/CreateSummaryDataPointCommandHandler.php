<?php

declare(strict_types=1);

namespace Carthage\Application\MetricCollection\CommandHandler\Summary;

use Carthage\Application\MetricCollection\Command\Summary\CreateSummaryDataPointCommand;
use Carthage\Application\Shared\CommandHandler\CommandHandlerInterface;
use Carthage\Domain\MetricCollection\Event\Summary\SummaryDataPointCreatedEvent;
use Carthage\Domain\MetricCollection\Service\Summary\SummaryDataPointService;
use Psr\EventDispatcher\EventDispatcherInterface;

final readonly class CreateSummaryDataPointCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private SummaryDataPointService $summaryDataPointService,
        private EventDispatcherInterface $eventDispatcher,
    ) {
    }

    public function __invoke(CreateSummaryDataPointCommand $command): void
    {
        $sumDataPoint = $this->summaryDataPointService->createSummaryDataPoint($command->createSumDataPoint);

        $this->eventDispatcher->dispatch(new SummaryDataPointCreatedEvent($sumDataPoint->getIdentity()));
    }
}
