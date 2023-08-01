<?php

declare(strict_types=1);

namespace Carthage\Application\MetricCollection\CommandHandler\Histogram;

use Carthage\Application\MetricCollection\Command\Histogram\CreateHistogramCommand;
use Carthage\Application\Shared\CommandHandler\CommandHandlerInterface;
use Carthage\Domain\MetricCollection\Event\Histogram\HistogramCreatedEvent;
use Carthage\Domain\MetricCollection\Service\Histogram\HistogramService;
use Psr\EventDispatcher\EventDispatcherInterface;

final readonly class CreateHistogramCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private HistogramService $histogramService,
        private EventDispatcherInterface $eventDispatcher,
    ) {
    }

    public function __invoke(CreateHistogramCommand $command): void
    {
        $histogram = $this->histogramService->createHistogram($command->createHistogram);

        $this->eventDispatcher->dispatch(
            new HistogramCreatedEvent($histogram->getIdentity()),
        );
    }
}
