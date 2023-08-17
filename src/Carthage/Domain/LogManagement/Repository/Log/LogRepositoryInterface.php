<?php

declare(strict_types=1);

namespace Carthage\Domain\LogManagement\Repository\Log;

use Carthage\Domain\LogManagement\Entity\Log\Log;
use Carthage\Domain\LogManagement\Enum\Log\Level;
use Carthage\Domain\LogManagement\Enum\Log\Statistics\Frequency;
use Carthage\Domain\LogManagement\ValueObject\Log\Statistic\LogFrequencyCount;
use Carthage\Domain\LogManagement\ValueObject\Log\Statistic\LogLevelStatistic;
use Carthage\Domain\Shared\Repository\EntityRepositoryInterface;
use DateTimeImmutable;

/**
 * @extends EntityRepositoryInterface<Log>
 */
interface LogRepositoryInterface extends EntityRepositoryInterface
{
    /**
     * Finds a log entry by its level, template, and namespace.
     *
     * This method queries the underlying data store to find a log entry that matches
     * the specified level, template, and namespace.
     *
     * @param non-empty-string $template
     * @param non-empty-string $namespace
     *
     * @return Log|null the matching log entry, or null if no match is found
     */
    public function findLogByLevelTemplateAndNamespace(Level $level, string $template, string $namespace): ?Log;

    /**
     * Retrieves a list of all unique namespaces used in logs.
     *
     * This method queries the underlying data store to find all distinct namespaces
     * that have been used in logs.
     *
     * @return list<non-empty-string>
     */
    public function getUniqueNamespacesFromLogs(): array;

    /**
     * Gets the percentage of logs for each log level.
     *
     * @return list<LogLevelStatistic>
     */
    public function getLogPercentageByLevel(DateTimeImmutable $from, DateTimeImmutable $to): array;

    /**
     * Gets the count of logs over a given time frequency.
     *
     * @param Frequency $frequency The frequency at which to calculate (e.g., daily, weekly).
     *
     * @return list<LogFrequencyCount>
     */
    public function getLogCountByFrequency(Frequency $frequency, DateTimeImmutable $from, DateTimeImmutable $to): array;
}
