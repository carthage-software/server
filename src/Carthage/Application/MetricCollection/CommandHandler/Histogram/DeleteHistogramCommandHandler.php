<?php

declare(strict_types=1);

namespace Carthage\Application\MetricCollection\CommandHandler\Histogram;

use Carthage\Application\MetricCollection\Command\Histogram\DeleteHistogramCommand;
use Carthage\Application\Shared\CommandHandler\CommandHandlerInterface;
use Carthage\Domain\MetricCollection\Event\Histogram\HistogramDeletedEvent;
use Carthage\Domain\MetricCollection\Service\Histogram\HistogramService;
use Psr\EventDispatcher\EventDispatcherInterface;

final readonly class DeleteHistogramCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private HistogramService $histogramService,
        private EventDispatcherInterface $eventDispatcher,
    ) {
    }

    public function __invoke(DeleteHistogramCommand $command): void
    {
        $this->histogramService->deleteHistogram($command->histogramIdentity);

        $this->eventDispatcher->dispatch(
            new HistogramDeletedEvent($command->histogramIdentity)
        );
    }
}
