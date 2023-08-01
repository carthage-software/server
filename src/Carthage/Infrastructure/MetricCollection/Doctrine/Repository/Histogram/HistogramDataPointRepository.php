<?php

declare(strict_types=1);

namespace Carthage\Infrastructure\MetricCollection\Doctrine\Repository\Histogram;

use Carthage\Domain\MetricCollection\Entity\Histogram\HistogramDataPoint;
use Carthage\Domain\MetricCollection\Repository\Histogram\HistogramDataPointRepositoryInterface;
use Carthage\Infrastructure\Shared\Doctrine\Repository\EntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\DependencyInjection\Attribute\AsAlias;

/**
 * @extends EntityRepository<HistogramDataPoint>
 */
#[AsAlias(HistogramDataPointRepositoryInterface::class)]
final class HistogramDataPointRepository extends EntityRepository implements HistogramDataPointRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HistogramDataPoint::class);
    }
}
