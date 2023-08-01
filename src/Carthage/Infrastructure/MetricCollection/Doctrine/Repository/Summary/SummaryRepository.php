<?php

declare(strict_types=1);

namespace Carthage\Infrastructure\MetricCollection\Doctrine\Repository\Summary;

use Carthage\Domain\MetricCollection\Entity\Summary\Summary;
use Carthage\Domain\MetricCollection\Repository\Summary\SummaryRepositoryInterface;
use Carthage\Infrastructure\Shared\Doctrine\Repository\EntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\DependencyInjection\Attribute\AsAlias;

/**
 * @extends EntityRepository<Summary>
 */
#[AsAlias(SummaryRepositoryInterface::class)]
final class SummaryRepository extends EntityRepository implements SummaryRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Summary::class);
    }

    public function findOneWithNameInNamespace(string $name, string $namespace): ?Summary
    {
        return $this->findOneBy([
            'namespace' => $namespace,
            'name' => $name,
        ]);
    }
}
