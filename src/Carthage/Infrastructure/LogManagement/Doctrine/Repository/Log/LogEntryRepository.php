<?php

declare(strict_types=1);

namespace Carthage\Infrastructure\LogManagement\Doctrine\Repository\Log;

use Carthage\Domain\LogManagement\Entity\Log\LogEntry;
use Carthage\Domain\LogManagement\Repository\Log\LogEntryRepositoryInterface;
use Carthage\Infrastructure\Shared\Doctrine\Repository\EntityRepository;
use Doctrine\DBAL\Exception;
use Doctrine\Persistence\ManagerRegistry;
use Psl\Vec;
use Symfony\Component\DependencyInjection\Attribute\AsAlias;

/**
 * @extends EntityRepository<LogEntry>
 */
#[AsAlias(LogEntryRepositoryInterface::class)]
final class LogEntryRepository extends EntityRepository implements LogEntryRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LogEntry::class);
    }

    /**
     * @throws Exception
     *
     * @return list<non-empty-string>
     */
    public function findAllTags(): array
    {
        $connection = $this->getEntityManager()->getConnection();

        $table = $this->getClassMetadata()->getTableName();
        $table = $connection->quoteIdentifier($table);

        $result = $connection
            ->executeQuery("SELECT DISTINCT jsonb_array_elements_text(tags) AS tag FROM $table ORDER BY tag ASC")
            ->fetchAllAssociative()
        ;

        return Vec\map($result, static fn (array $row): string => $row['tag']);
    }
}
