<?php

declare(strict_types=1);

namespace Carthage\Application\MetricCollection\Command\Gauge;

use Carthage\Application\Shared\Command\CommandInterface;
use Carthage\Domain\MetricCollection\DataTransferObject\Gauge\CreateGauge;

final readonly class CreateGaugeCommand implements CommandInterface
{
    public function __construct(
        public CreateGauge $createGauge,
    ) {
    }
}
