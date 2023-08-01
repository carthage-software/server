<?php

declare(strict_types=1);

namespace Carthage\Infrastructure\MetricCollection\Doctrine\Repository\Histogram;

use Carthage\Domain\MetricCollection\Entity\Histogram\Histogram;
use Carthage\Domain\MetricCollection\Repository\Histogram\HistogramRepositoryInterface;
use Carthage\Infrastructure\Shared\Doctrine\Repository\EntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\DependencyInjection\Attribute\AsAlias;

/**
 * @extends EntityRepository<Histogram>
 */
#[AsAlias(HistogramRepositoryInterface::class)]
final class HistogramRepository extends EntityRepository implements HistogramRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Histogram::class);
    }

    public function findOneWithNameInNamespace(string $name, string $namespace): ?Histogram
    {
        return $this->findOneBy([
            'namespace' => $namespace,
            'name' => $name,
        ]);
    }
}
