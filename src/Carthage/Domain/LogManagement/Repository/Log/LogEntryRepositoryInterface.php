<?php

declare(strict_types=1);

namespace Carthage\Domain\LogManagement\Repository\Log;

use Carthage\Domain\LogManagement\Entity\Log\LogEntry;
use Carthage\Domain\LogManagement\Enum\Log\Statistics\Frequency;
use Carthage\Domain\LogManagement\ValueObject\Log\Statistic\LogEntryFrequencyCount;
use Carthage\Domain\LogManagement\ValueObject\Log\Statistic\LogEntrySourceFrequency;
use Carthage\Domain\LogManagement\ValueObject\Log\Statistic\LogEntryTagDistribution;
use Carthage\Domain\Shared\Repository\EntityRepositoryInterface;

/**
 * @extends EntityRepositoryInterface<LogEntry>
 */
interface LogEntryRepositoryInterface extends EntityRepositoryInterface
{
    /**
     * Retrieves a list of all unique tags used in log entries.
     *
     * This method queries the underlying data store to find all distinct tags
     *  that have been used in log entries.
     *
     * @return list<non-empty-string>
     */
    public function getUniqueTagsFromLogEntries(): array;

    /**
     * Retrieves a list of all unique sources from which log entries have been generated.
     *
     * This method queries the underlying data store to find all distinct sources
     *  that have been referenced in log entries.
     *
     * @return list<non-empty-string>
     */
    public function getUniqueSourcesFromLogEntries(): array;

    /**
     * Gets the most frequent sources of log entries.
     *
     * @return list<LogEntrySourceFrequency>
     */
    public function getMostFrequentSources(): array;

    /**
     * Gets the distribution of tags across log entries.
     *
     * @return list<LogEntryTagDistribution>
     */
    public function getTagDistribution(): array;

    /**
     * Gets the count of log entries over a given time frequency.
     *
     * @param Frequency $frequency The frequency at which to calculate (e.g., daily, weekly).
     *
     * @return list<LogEntryFrequencyCount>
     */
    public function getLogEntryCountByFrequency(Frequency $frequency): array;
}
