<?php

declare(strict_types=1);

namespace Carthage\Domain\MetricCollection\Repository\Metric;

use Carthage\Domain\MetricCollection\Entity\Metric\MetricDataPoint;
use Carthage\Domain\Shared\Repository\EntityRepositoryInterface;

/**
 * @extends EntityRepositoryInterface<MetricDataPoint>
 */
interface MetricDataPointRepositoryInterface extends EntityRepositoryInterface
{
}
