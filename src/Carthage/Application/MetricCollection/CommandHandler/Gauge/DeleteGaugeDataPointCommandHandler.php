<?php

declare(strict_types=1);

namespace Carthage\Application\MetricCollection\CommandHandler\Gauge;

use Carthage\Application\MetricCollection\Command\Gauge\DeleteGaugeDataPointCommand;
use Carthage\Application\Shared\CommandHandler\CommandHandlerInterface;
use Carthage\Domain\MetricCollection\Event\Gauge\GaugeDataPointDeletedEvent;
use Carthage\Domain\MetricCollection\Service\Gauge\GaugeDataPointService;
use Psr\EventDispatcher\EventDispatcherInterface;

final readonly class DeleteGaugeDataPointCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private GaugeDataPointService $gaugeDataPointService,
        private EventDispatcherInterface $eventDispatcher,
    ) {
    }

    public function __invoke(DeleteGaugeDataPointCommand $command): void
    {
        $this->gaugeDataPointService->deleteGaugeDataPoint($command->gaugeDataPointId);

        $this->eventDispatcher->dispatch(new GaugeDataPointDeletedEvent($command->gaugeDataPointId));
    }
}
