<?php

declare(strict_types=1);

namespace Carthage\Application\MetricCollection\CommandHandler\Gauge;

use Carthage\Application\MetricCollection\Command\Gauge\CreateGaugeCommand;
use Carthage\Application\Shared\CommandHandler\CommandHandlerInterface;
use Carthage\Domain\MetricCollection\Event\Gauge\GaugeCreatedEvent;
use Carthage\Domain\MetricCollection\Service\Gauge\GaugeService;
use Psr\EventDispatcher\EventDispatcherInterface;

final readonly class CreateGaugeCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private GaugeService $gaugeService,
        private EventDispatcherInterface $eventDispatcher,
    ) {
    }

    public function __invoke(CreateGaugeCommand $command): void
    {
        $gauge = $this->gaugeService->createGauge($command->createGauge);

        $this->eventDispatcher->dispatch(new GaugeCreatedEvent($gauge->getIdentity()));
    }
}
