<?php

declare(strict_types=1);

namespace Carthage\Infrastructure\MetricCollection\Doctrine\Repository\Metric;

use Carthage\Domain\MetricCollection\Entity\Metric\Metric;
use Carthage\Domain\MetricCollection\Repository\Metric\MetricRepositoryInterface;
use Carthage\Infrastructure\Shared\Doctrine\Repository\EntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Psl\Vec;

/**
 * @extends EntityRepository<Metric>
 */
final class MetricRepository extends EntityRepository implements MetricRepositoryInterface
{
    public function __construct(
        ManagerRegistry $registry
    ) {
        parent::__construct($registry, Metric::class);
    }

    /**
     * @return list<non-empty-string>
     */
    public function findAllNamespaces(): array
    {
        $queryBuilder = $this
            ->createQueryBuilder('m')
            ->select('m.namespace')
            ->distinct()
        ;

        /** @var list<array{namespace: non-empty-string}> $result */
        $result = $queryBuilder->getQuery()->getResult();

        return Vec\map($result, static fn (array $row): string => $row['namespace']);
    }
}
