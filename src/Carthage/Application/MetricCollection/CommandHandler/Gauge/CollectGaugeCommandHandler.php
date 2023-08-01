<?php

declare(strict_types=1);

namespace Carthage\Application\MetricCollection\CommandHandler\Gauge;

use Carthage\Application\MetricCollection\Command\Gauge\CollectGaugeCommand;
use Carthage\Application\MetricCollection\Service\Gauge\GaugeCollector;
use Carthage\Application\Shared\CommandHandler\CommandHandlerInterface;

final readonly class CollectGaugeCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private GaugeCollector $gaugeCollector,
    ) {
    }

    public function __invoke(CollectGaugeCommand $command): void
    {
        $this->gaugeCollector->collectGauge($command->collectGauge);
    }
}
