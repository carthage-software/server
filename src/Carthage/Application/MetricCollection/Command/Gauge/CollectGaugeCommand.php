<?php

declare(strict_types=1);

namespace Carthage\Application\MetricCollection\Command\Gauge;

use Carthage\Application\Shared\Command\CommandInterface;
use Carthage\Domain\MetricCollection\DataTransferObject\Gauge\CollectGauge;

final readonly class CollectGaugeCommand implements CommandInterface
{
    public function __construct(
        public CollectGauge $collectGauge,
    ) {
    }
}
