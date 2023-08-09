<?php

declare(strict_types=1);

namespace Carthage\Application\MetricCollection\CommandHandler\Summary;

use Carthage\Application\MetricCollection\Command\Summary\DeleteSummaryDataPointCommand;
use Carthage\Application\Shared\CommandHandler\CommandHandlerInterface;
use Carthage\Domain\MetricCollection\Event\Summary\SummaryDataPointDeletedEvent;
use Carthage\Domain\MetricCollection\Service\Summary\SummaryDataPointService;
use Psr\EventDispatcher\EventDispatcherInterface;

final readonly class DeleteSummaryDataPointCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private SummaryDataPointService $summaryDataPointService,
        private EventDispatcherInterface $eventDispatcher,
    ) {
    }

    public function __invoke(DeleteSummaryDataPointCommand $command): void
    {
        $this->summaryDataPointService->deleteSummaryDataPoint($command->summaryDataPointIdentity);

        $this->eventDispatcher->dispatch(new SummaryDataPointDeletedEvent($command->summaryDataPointIdentity));
    }
}
