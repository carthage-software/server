<?php

declare(strict_types=1);

namespace Carthage\Domain\MetricCollection\Repository\Histogram;

use Carthage\Domain\MetricCollection\Entity\Histogram\HistogramDataPoint;
use Carthage\Domain\Shared\Repository\EntityRepositoryInterface;

/**
 * @extends EntityRepositoryInterface<HistogramDataPoint>
 */
interface HistogramDataPointRepositoryInterface extends EntityRepositoryInterface
{
}
