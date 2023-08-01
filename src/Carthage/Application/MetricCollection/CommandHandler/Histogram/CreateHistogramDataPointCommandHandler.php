<?php

declare(strict_types=1);

namespace Carthage\Application\MetricCollection\CommandHandler\Histogram;

use Carthage\Application\MetricCollection\Command\Histogram\CreateHistogramDataPointCommand;
use Carthage\Application\Shared\CommandHandler\CommandHandlerInterface;
use Carthage\Domain\MetricCollection\Event\Histogram\HistogramDataPointCreatedEvent;
use Carthage\Domain\MetricCollection\Service\Histogram\HistogramDataPointService;
use Psr\EventDispatcher\EventDispatcherInterface;

final readonly class CreateHistogramDataPointCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private HistogramDataPointService $histogramDataPointService,
        private EventDispatcherInterface $eventDispatcher,
    ) {
    }

    public function __invoke(CreateHistogramDataPointCommand $command): void
    {
        $histogramDataPoint = $this->histogramDataPointService->createHistogramDataPoint($command->createHistogramDataPoint);

        $this->eventDispatcher->dispatch(
            new HistogramDataPointCreatedEvent($histogramDataPoint->getIdentity()),
        );
    }
}
