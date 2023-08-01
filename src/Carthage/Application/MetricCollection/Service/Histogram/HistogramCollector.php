<?php

declare(strict_types=1);

namespace Carthage\Application\MetricCollection\Service\Histogram;

use Carthage\Application\MetricCollection\Command\Histogram\CreateHistogramDataPointCommand;
use Carthage\Application\Shared\CommandBusInterface;
use Carthage\Domain\MetricCollection\DataTransferObject\Histogram\CollectHistogram;
use Carthage\Domain\MetricCollection\Event\Histogram\HistogramCreatedEvent;
use Carthage\Domain\MetricCollection\Repository\Histogram\HistogramRepositoryInterface;
use Carthage\Domain\MetricCollection\Service\Histogram\HistogramService;
use Psr\EventDispatcher\EventDispatcherInterface;

final readonly class HistogramCollector
{
    public function __construct(
        private HistogramService $histogramService,
        private HistogramRepositoryInterface $histogramRepository,
        private EventDispatcherInterface $eventDispatcher,
        private CommandBusInterface $commandBus,
    ) {
    }

    public function collectHistogram(CollectHistogram $collectHistogram): void
    {
        $histogram = $this->histogramRepository->findOneWithNameInNamespace(
            $collectHistogram->histogram->name,
            $collectHistogram->histogram->namespace,
        );

        if (null === $histogram) {
            $histogram = $this->histogramService->createHistogram($collectHistogram->histogram);

            $this->eventDispatcher->dispatch(new HistogramCreatedEvent($histogram->getIdentity()));
        }

        foreach ($collectHistogram->dataPoints as $dataPoint) {
            $this->commandBus->dispatch(
                new CreateHistogramDataPointCommand($dataPoint->toCreateHistogramDataPoint($histogram)),
            );
        }
    }
}
