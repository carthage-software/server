<?php

declare(strict_types=1);

namespace Carthage\Application\MetricCollection\CommandHandler\Gauge;

use Carthage\Application\MetricCollection\Command\Gauge\DeleteGaugeCommand;
use Carthage\Application\Shared\CommandHandler\CommandHandlerInterface;
use Carthage\Domain\MetricCollection\Event\Gauge\GaugeDeletedEvent;
use Carthage\Domain\MetricCollection\Service\Gauge\GaugeService;
use Psr\EventDispatcher\EventDispatcherInterface;

final readonly class DeleteGaugeCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private GaugeService $gaugeService,
        private EventDispatcherInterface $eventDispatcher,
    ) {
    }

    public function __invoke(DeleteGaugeCommand $command): void
    {
        $this->gaugeService->deleteGauge($command->gaugeId);

        $this->eventDispatcher->dispatch(new GaugeDeletedEvent($command->gaugeId));
    }
}
