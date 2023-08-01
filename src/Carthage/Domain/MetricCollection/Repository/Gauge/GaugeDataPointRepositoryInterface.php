<?php

declare(strict_types=1);

namespace Carthage\Domain\MetricCollection\Repository\Gauge;

use Carthage\Domain\MetricCollection\Entity\Gauge\GaugeDataPoint;
use Carthage\Domain\Shared\Repository\EntityRepositoryInterface;

/**
 * @extends EntityRepositoryInterface<GaugeDataPoint>
 */
interface GaugeDataPointRepositoryInterface extends EntityRepositoryInterface
{
}
