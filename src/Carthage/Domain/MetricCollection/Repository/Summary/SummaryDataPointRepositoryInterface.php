<?php

declare(strict_types=1);

namespace Carthage\Domain\MetricCollection\Repository\Summary;

use Carthage\Domain\MetricCollection\Entity\Summary\SummaryDataPoint;
use Carthage\Domain\Shared\Repository\EntityRepositoryInterface;

/**
 * @extends EntityRepositoryInterface<SummaryDataPoint>
 */
interface SummaryDataPointRepositoryInterface extends EntityRepositoryInterface
{
}
