<?php

declare(strict_types=1);

namespace Carthage\Infrastructure\LogManagement\Doctrine\Repository\Log;

use Carthage\Domain\LogManagement\Entity\Log\Log;
use Carthage\Domain\LogManagement\Enum\Log\Level;
use Carthage\Domain\LogManagement\Repository\Log\LogRepositoryInterface;
use Carthage\Infrastructure\Shared\Doctrine\Repository\EntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Psl\Vec;
use Symfony\Component\DependencyInjection\Attribute\AsAlias;

/**
 * @extends EntityRepository<Log>
 */
#[AsAlias(LogRepositoryInterface::class)]
final class LogRepository extends EntityRepository implements LogRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Log::class);
    }

    public function findByLevelAndTemplateInNamespace(Level $level, string $template, string $namespace): ?Log
    {
        return $this->findOneBy([
            'namespace' => $namespace,
            'level' => $level,
            'template' => $template,
        ]);
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
