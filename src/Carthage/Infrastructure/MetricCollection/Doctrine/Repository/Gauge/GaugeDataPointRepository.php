<?php

declare(strict_types=1);

namespace Carthage\Infrastructure\MetricCollection\Doctrine\Repository\Gauge;

use Carthage\Domain\MetricCollection\Entity\Gauge\GaugeDataPoint;
use Carthage\Domain\MetricCollection\Repository\Gauge\GaugeDataPointRepositoryInterface;
use Carthage\Infrastructure\Shared\Doctrine\Repository\EntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\DependencyInjection\Attribute\AsAlias;

/**
 * @extends EntityRepository<GaugeDataPoint>
 */
#[AsAlias(GaugeDataPointRepositoryInterface::class)]
final class GaugeDataPointRepository extends EntityRepository implements GaugeDataPointRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GaugeDataPoint::class);
    }
}
