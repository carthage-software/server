<?php

declare(strict_types=1);

namespace Carthage\Application\LogManagement\Service\Log\Statistic;

use Carthage\Domain\LogManagement\Enum\Log\Statistics\Frequency;
use Carthage\Domain\LogManagement\Repository\Log\LogEntryRepositoryInterface;
use Carthage\Domain\LogManagement\ValueObject\Log\Statistic\LogEntryFrequencyCount;
use Carthage\Domain\LogManagement\ValueObject\Log\Statistic\LogEntrySourceFrequency;
use Carthage\Domain\LogManagement\ValueObject\Log\Statistic\LogEntryTagDistribution;
use Psl\Str;
use Psr\Cache\CacheItemPoolInterface;

final readonly class LogEntryStatisticsService
{
    private const CACHE_TTL = 1800; // 30 minutes
    private const MOST_FREQUENT_SOURCES_CACHE_KEY = 'most_frequent_sources';
    private const TAG_DISTRIBUTION_CACHE_KEY = 'tag_distribution';
    private const LOG_ENTRY_COUNT_CACHE_KEY_FORMAT = 'log_entry_count_%s';

    public function __construct(
        private LogEntryRepositoryInterface $logEntryRepository,
        private CacheItemPoolInterface $cacheItemPool,
    ) {
    }

    /**
     * Retrieves the most frequent sources of log entries.
     *
     * @return list<LogEntrySourceFrequency> list of most frequent sources
     */
    public function getMostFrequentSources(): array
    {
        $logEntrySourceFrequenciesItems = $this->cacheItemPool->getItem(self::MOST_FREQUENT_SOURCES_CACHE_KEY);

        if (!$logEntrySourceFrequenciesItems->isHit()) {
            $logEntrySourceFrequencies = $this->logEntryRepository->getMostFrequentSources();

            $logEntrySourceFrequenciesItems->set($logEntrySourceFrequencies);
            $logEntrySourceFrequenciesItems->expiresAfter(self::CACHE_TTL);

            $this->cacheItemPool->save($logEntrySourceFrequenciesItems);
        }

        /* @var list<LogEntrySourceFrequency> */
        return $logEntrySourceFrequenciesItems->get();
    }

    /**
     * Retrieves the distribution of tags across log entries.
     *
     * @return list<LogEntryTagDistribution> list of tag distributions
     */
    public function getTagDistribution(): array
    {
        $logEntryTagDistributionsItem = $this->cacheItemPool->getItem(self::TAG_DISTRIBUTION_CACHE_KEY);

        if (!$logEntryTagDistributionsItem->isHit()) {
            $logEntryTagDistributions = $this->logEntryRepository->getTagDistribution();

            $logEntryTagDistributionsItem->set($logEntryTagDistributions);
            $logEntryTagDistributionsItem->expiresAfter(self::CACHE_TTL);

            $this->cacheItemPool->save($logEntryTagDistributionsItem);
        }

        /* @var list<LogEntryTagDistribution> */
        return $logEntryTagDistributionsItem->get();
    }

    /**
     * Retrieves the count of log entries over a given time frequency.
     *
     * @param Frequency $frequency The frequency at which to calculate (e.g., daily, weekly).
     *
     * @return list<LogEntryFrequencyCount> list of log entry frequency counts
     */
    public function getLogEntryCountByFrequency(Frequency $frequency): array
    {
        $cacheKey = Str\format(self::LOG_ENTRY_COUNT_CACHE_KEY_FORMAT, $frequency->value);

        $logEntryFrequencyCountsItem = $this->cacheItemPool->getItem($cacheKey);

        if (!$logEntryFrequencyCountsItem->isHit()) {
            $logEntryFrequencyCounts = $this->logEntryRepository->getLogEntryCountByFrequency($frequency);

            $logEntryFrequencyCountsItem->set($logEntryFrequencyCounts);
            $logEntryFrequencyCountsItem->expiresAfter(self::CACHE_TTL);

            $this->cacheItemPool->save($logEntryFrequencyCountsItem);
        }

        /* @var list<LogEntryFrequencyCount> */
        return $logEntryFrequencyCountsItem->get();
    }
}
