<?php

declare(strict_types=1);

namespace Carthage\Infrastructure\LogManagement\Doctrine\Repository\Log;

use Carthage\Domain\LogManagement\Entity\Log\Log;
use Carthage\Domain\LogManagement\Enum\Log\Level;
use Carthage\Domain\LogManagement\Enum\Log\Statistics\Frequency;
use Carthage\Domain\LogManagement\Repository\Log\LogRepositoryInterface;
use Carthage\Domain\LogManagement\ValueObject\Log\Statistic\LogFrequencyCount;
use Carthage\Domain\LogManagement\ValueObject\Log\Statistic\LogLevelStatistics;
use Carthage\Infrastructure\Shared\Doctrine\Repository\EntityRepository;
use DateTimeImmutable;
use Doctrine\DBAL\Exception as DatabaseException;
use Doctrine\Persistence\ManagerRegistry;
use Exception;
use Psl\Type;
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

    public function findLogByLevelTemplateAndNamespace(Level $level, string $template, string $namespace): ?Log
    {
        return $this->findOneBy(['namespace' => $namespace, 'level' => $level, 'template' => $template]);
    }

    /**
     * @return list<non-empty-string>
     */
    public function getUniqueNamespacesFromLogs(): array
    {
        $queryBuilder = $this->createQueryBuilder('m')->select('m.namespace')->distinct();

        /** @var list<array{namespace: non-empty-string}> $result */
        $result = $queryBuilder->getQuery()->getResult();

        return Vec\map($result, static fn (array $row): string => $row['namespace']);
    }

    /**
     * @throws DatabaseException
     *
     * @return list<LogLevelStatistics>
     */
    public function getLogPercentageByLevel(): array
    {
        $connection = $this->getEntityManager()->getConnection();
        $table = $this->getClassMetadata()->getTableName();
        $table = $connection->quoteIdentifier($table);

        $query = "
            WITH total_logs AS (
                SELECT COUNT(*) AS total_count FROM $table
            )
            SELECT level, COUNT(*) AS count, (COUNT(*) * 100.0 / total_logs.total_count) AS percentage
            FROM $table, total_logs
            GROUP BY level, total_logs.total_count
        ";

        /** @var list<array{level: string, count: string, percentage: string}> $result */
        $result = $connection->executeQuery($query)->fetchAllAssociative();

        return Vec\map(
            $result,
            static fn (array $row): LogLevelStatistics => new LogLevelStatistics(
                Level::from(
                    Type\positive_int()->coerce($row['level']),
                ),
                Type\positive_int()->coerce($row['count']),
                Type\float()->coerce($row['percentage']),
            ),
        );
    }

    /**
     * @throws Exception
     * @throws DatabaseException
     *
     * @return list<LogFrequencyCount>
     */
    public function getLogCountByFrequency(Frequency $frequency): array
    {
        $connection = $this->getEntityManager()->getConnection();
        $table = $this->getClassMetadata()->getTableName();
        $table = $connection->quoteIdentifier($table);

        $interval = match ($frequency) {
            Frequency::Hourly => 'hour',
            Frequency::Daily => 'day',
            Frequency::Weekly => 'week',
            Frequency::Monthly => 'month',
            Frequency::Quarterly => 'quarter',
            Frequency::Yearly => 'year',
        };

        $query = "SELECT date_trunc(:interval, created_at) AS date, COUNT(*) AS count FROM $table GROUP BY date ORDER BY date ASC";

        /** @var list<array{date: string, count: string}> $result */
        $result = $connection->executeQuery($query, ['interval' => $interval])->fetchAllAssociative();

        return Vec\map($result, static fn (array $row): LogFrequencyCount => new LogFrequencyCount(
            new DateTimeImmutable(
                Type\non_empty_string()->coerce($row['date']),
            ),
            Type\positive_int()->coerce($row['count']),
        ));
    }
}
