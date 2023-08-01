<?php

declare(strict_types=1);

namespace Carthage\Infrastructure\MetricCollection\Doctrine\Repository\Gauge;

use Carthage\Domain\MetricCollection\Entity\Gauge\Gauge;
use Carthage\Domain\MetricCollection\Repository\Gauge\GaugeRepositoryInterface;
use Carthage\Infrastructure\Shared\Doctrine\Repository\EntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\DependencyInjection\Attribute\AsAlias;

/**
 * @extends EntityRepository<Gauge>
 */
#[AsAlias(GaugeRepositoryInterface::class)]
final class GaugeRepository extends EntityRepository implements GaugeRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Gauge::class);
    }

    public function findOneWithNameInNamespace(string $name, string $namespace): ?Gauge
    {
        return $this->findOneBy([
            'namespace' => $namespace,
            'name' => $name,
        ]);
    }
}
