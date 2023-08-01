<?php

declare(strict_types=1);

namespace Carthage\Infrastructure\MetricCollection\Doctrine\Repository\Metric;

use Carthage\Domain\MetricCollection\Entity\Metric\MetricDataPoint;
use Carthage\Domain\MetricCollection\Repository\Metric\MetricDataPointRepositoryInterface;
use Carthage\Infrastructure\Shared\Doctrine\Repository\EntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends EntityRepository<MetricDataPoint>
 */
final class MetricDataPointRepository extends EntityRepository implements MetricDataPointRepositoryInterface
{
    public function __construct(
        ManagerRegistry $registry)
    {
        parent::__construct($registry, MetricDataPoint::class);
    }
}
