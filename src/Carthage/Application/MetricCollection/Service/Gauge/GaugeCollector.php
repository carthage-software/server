<?php

declare(strict_types=1);

namespace Carthage\Application\MetricCollection\Service\Gauge;

use Carthage\Application\MetricCollection\Command\Gauge\CreateGaugeDataPointCommand;
use Carthage\Application\Shared\CommandBusInterface;
use Carthage\Domain\MetricCollection\DataTransferObject\Gauge\CollectGauge;
use Carthage\Domain\MetricCollection\Event\Gauge\GaugeCreatedEvent;
use Carthage\Domain\MetricCollection\Repository\Gauge\GaugeRepositoryInterface;
use Carthage\Domain\MetricCollection\Service\Gauge\GaugeService;
use Psr\EventDispatcher\EventDispatcherInterface;

final readonly class GaugeCollector
{
    public function __construct(
        private GaugeService $gaugeService,
        private GaugeRepositoryInterface $gaugeRepository,
        private EventDispatcherInterface $eventDispatcher,
        private CommandBusInterface $commandBus,
    ) {
    }

    public function collectGauge(CollectGauge $collectGauge): void
    {
        $gauge = $this->gaugeRepository->findOneWithNameInNamespace(
            $collectGauge->gauge->name,
            $collectGauge->gauge->namespace,
        );

        if (null === $gauge) {
            $gauge = $this->gaugeService->createGauge($collectGauge->gauge);

            $this->eventDispatcher->dispatch(new GaugeCreatedEvent($gauge->getIdentity()));
        }

        foreach ($collectGauge->dataPoints as $dataPoint) {
            $this->commandBus->dispatch(
                new CreateGaugeDataPointCommand($dataPoint->toCreateGaugeDataPoint($gauge)),
            );
        }
    }
}
