<?php

declare(strict_types=1);

namespace Carthage\Infrastructure\MetricCollection\Doctrine\Repository\Summary;

use Carthage\Domain\MetricCollection\Entity\Summary\SummaryDataPoint;
use Carthage\Domain\MetricCollection\Repository\Summary\SummaryDataPointRepositoryInterface;
use Carthage\Infrastructure\Shared\Doctrine\Repository\EntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\DependencyInjection\Attribute\AsAlias;

/**
 * @extends EntityRepository<SummaryDataPoint>
 */
#[AsAlias(SummaryDataPointRepositoryInterface::class)]
final class SummaryDataPointRepository extends EntityRepository implements SummaryDataPointRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SummaryDataPoint::class);
    }
}
