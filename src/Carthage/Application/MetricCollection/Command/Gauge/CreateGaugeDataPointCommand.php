<?php

declare(strict_types=1);

namespace Carthage\Application\MetricCollection\Command\Gauge;

use Carthage\Application\Shared\Command\CommandInterface;
use Carthage\Domain\MetricCollection\DataTransferObject\Gauge\CreateGaugeDataPoint;

final readonly class CreateGaugeDataPointCommand implements CommandInterface
{
    public function __construct(
        public CreateGaugeDataPoint $createGaugeDataPoint,
    ) {
    }
}
