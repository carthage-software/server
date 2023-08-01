<?php

declare(strict_types=1);

namespace Carthage\Application\MetricCollection\CommandHandler\Histogram;

use Carthage\Application\MetricCollection\Command\Histogram\DeleteHistogramDataPointCommand;
use Carthage\Application\Shared\CommandHandler\CommandHandlerInterface;
use Carthage\Domain\MetricCollection\Event\Histogram\HistogramDataPointDeletedEvent;
use Carthage\Domain\MetricCollection\Service\Histogram\HistogramDataPointService;
use Psr\EventDispatcher\EventDispatcherInterface;

final readonly class DeleteHistogramDataPointCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private HistogramDataPointService $histogramDataPointService,
        private EventDispatcherInterface $eventDispatcher,
    ) {
    }

    public function __invoke(DeleteHistogramDataPointCommand $command): void
    {
        $this->histogramDataPointService->deleteHistogramDataPoint($command->histogramDataPointId);

        $this->eventDispatcher->dispatch(
            new HistogramDataPointDeletedEvent($command->histogramDataPointId)
        );
    }
}
