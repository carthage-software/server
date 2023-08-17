<?php

declare(strict_types=1);

namespace Carthage\Infrastructure\LogManagement\Doctrine\Repository\Log;

use Carthage\Domain\LogManagement\Entity\Log\LogEntry;
use Carthage\Domain\LogManagement\Enum\Log\Statistics\Frequency;
use Carthage\Domain\LogManagement\Repository\Log\LogEntryRepositoryInterface;
use Carthage\Domain\LogManagement\ValueObject\Log\Statistic\LogEntryFrequencyCount;
use Carthage\Domain\LogManagement\ValueObject\Log\Statistic\LogEntrySourceFrequency;
use Carthage\Domain\LogManagement\ValueObject\Log\Statistic\LogEntryTagDistribution;
use Carthage\Infrastructure\Shared\Doctrine\Repository\EntityRepository;
use DateTimeImmutable;
use Doctrine\DBAL\Exception as DatabaseException;
use Doctrine\Persistence\ManagerRegistry;
use Exception;
use Psl\Type;
use Psl\Vec;
use Symfony\Component\DependencyInjection\Attribute\AsAlias;

/**
 * @extends EntityRepository<LogEntry>
 */
#[AsAlias(LogEntryRepositoryInterface::class)]
final class LogEntryRepository extends EntityRepository implements LogEntryRepositoryInterface
{
    private const STATISTIC_DATE_FORMAT = 'Y-m-d';

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LogEntry::class);
    }

    /**
     * @throws DatabaseException
     *
     * @return list<non-empty-string>
     */
    public function getUniqueTagsFromLogEntries(): array
    {
        $connection = $this->getEntityManager()->getConnection();

        $table = $this->getClassMetadata()->getTableName();
        $table = $connection->quoteIdentifier($table);

        /** @var array<array-key, array{row: non-empty-string}> $result */
        $result = $connection
            ->executeQuery("SELECT DISTINCT jsonb_array_elements_text(tags) AS tag FROM $table ORDER BY tag ASC")
            ->fetchAllAssociative()
        ;

        return Vec\map($result, static fn (array $row): string => $row['tag']);
    }

    /**
     * @throws DatabaseException
     *
     * @return list<non-empty-string>
     */
    public function getUniqueSourcesFromLogEntries(): array
    {
        $connection = $this->getEntityManager()->getConnection();

        $table = $this->getClassMetadata()->getTableName();
        $table = $connection->quoteIdentifier($table);

        /** @var array<array-key, array{row: non-empty-string}> $result */
        $result = $connection
            ->executeQuery("SELECT DISTINCT source FROM $table ORDER BY source ASC")
            ->fetchAllAssociative()
        ;

        return Vec\map($result, static fn (array $row): string => $row['source']);
    }

    /**
     * {@inheritDoc}
     *
     * @throws DatabaseException
     */
    public function getMostFrequentSources(DateTimeImmutable $from, DateTimeImmutable $to): array
    {
        $connection = $this->getEntityManager()->getConnection();

        $table = $this->getClassMetadata()->getTableName();
        $table = $connection->quoteIdentifier($table);

        $query = <<<SQL
            WITH total AS (
                SELECT COUNT(*) AS total_count FROM $table WHERE occurred_at BETWEEN :from AND :to
            )
            SELECT source, COUNT(source) AS count, (COUNT(source) * 100.0 / total.total_count) AS percentage
            FROM $table, total
            WHERE occurred_at BETWEEN :from AND :to
            GROUP BY source, total.total_count
            ORDER BY count DESC
        SQL;

        /** @var array<array-key, array{source: non-empty-string, count: string, percentage: string}> $result */
        $result = $connection->executeQuery($query, [
            'from' => $from->format(self::STATISTIC_DATE_FORMAT),
            'to' => $to->format(self::STATISTIC_DATE_FORMAT),
        ])->fetchAllAssociative();

        return Vec\map($result, static fn (array $row): LogEntrySourceFrequency => new LogEntrySourceFrequency(
            Type\non_empty_string()->coerce($row['source']),
            Type\positive_int()->coerce($row['count']),
            Type\float()->coerce($row['percentage']),
        ));
    }

    /**
     * {@inheritDoc}
     *
     * @throws DatabaseException
     *
     * @return list<LogEntryTagDistribution>
     */
    public function getTagDistribution(DateTimeImmutable $from, DateTimeImmutable $to): array
    {
        $connection = $this->getEntityManager()->getConnection();

        $table = $this->getClassMetadata()->getTableName();
        $table = $connection->quoteIdentifier($table);

        $query = <<<SQL
            WITH tags_cte AS (
                SELECT jsonb_array_elements_text(tags) AS tag FROM $table WHERE occurred_at BETWEEN :from AND :to
            )
            SELECT tag, COUNT(tag) AS count
            FROM tags_cte
            GROUP BY tag
            ORDER BY count DESC
        SQL;

        /** @var array<array-key, array{tag: string, count: string}> $result */
        $result = $connection->executeQuery($query, [
            'from' => $from->format(self::STATISTIC_DATE_FORMAT),
            'to' => $to->format(self::STATISTIC_DATE_FORMAT),
        ])->fetchAllAssociative();

        return Vec\map($result, static fn (array $row): LogEntryTagDistribution => new LogEntryTagDistribution(
            Type\non_empty_string()->coerce($row['tag']),
            Type\positive_int()->coerce($row['count']),
        ));
    }

    /**
     * {@inheritDoc}
     *
     * @throws DatabaseException
     * @throws Exception
     *
     * @return list<LogEntryFrequencyCount>
     */
    public function getLogEntryCountByFrequency(Frequency $frequency, DateTimeImmutable $from, DateTimeImmutable $to): array
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

        $query = <<<SQL
            SELECT date_trunc(:interval, occurred_at) AS date, COUNT(*) AS count
            FROM $table
            WHERE occurred_at BETWEEN :from AND :to
            GROUP BY date
            ORDER BY date ASC
        SQL;

        /** @var array<array-key, array{date: string, count: string}> $result */
        $result = $connection->executeQuery($query, [
            'interval' => $interval,
            'from' => $from->format(self::STATISTIC_DATE_FORMAT),
            'to' => $to->format(self::STATISTIC_DATE_FORMAT),
        ])->fetchAllAssociative();

        return Vec\map($result, static fn (array $row): LogEntryFrequencyCount => new LogEntryFrequencyCount(
            new DateTimeImmutable(
                Type\non_empty_string()->coerce($row['date']),
            ),
            Type\positive_int()->coerce($row['count']),
        ));
    }
}
