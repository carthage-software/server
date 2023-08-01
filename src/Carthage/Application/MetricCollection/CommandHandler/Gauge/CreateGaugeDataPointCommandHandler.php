<?php

declare(strict_types=1);

namespace Carthage\Application\MetricCollection\CommandHandler\Gauge;

use Carthage\Application\MetricCollection\Command\Gauge\CreateGaugeDataPointCommand;
use Carthage\Application\Shared\CommandHandler\CommandHandlerInterface;
use Carthage\Domain\MetricCollection\Event\Gauge\GaugeDataPointCreatedEvent;
use Carthage\Domain\MetricCollection\Service\Gauge\GaugeDataPointService;
use Psr\EventDispatcher\EventDispatcherInterface;

final readonly class CreateGaugeDataPointCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private GaugeDataPointService $gaugeDataPointService,
        private EventDispatcherInterface $eventDispatcher,
    ) {
    }

    public function __invoke(CreateGaugeDataPointCommand $command): void
    {
        $gaugeDataPoint = $this->gaugeDataPointService->createGaugeDataPoint($command->createGaugeDataPoint);

        $this->eventDispatcher->dispatch(new GaugeDataPointCreatedEvent($gaugeDataPoint->getIdentity()));
    }
}
