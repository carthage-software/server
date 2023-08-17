<?php

declare(strict_types=1);

namespace Carthage\Application\LogManagement\Service\Log\Statistic;

use Carthage\Domain\LogManagement\Enum\Log\Statistics\Frequency;
use Carthage\Domain\LogManagement\Repository\Log\LogEntryRepositoryInterface;
use Carthage\Domain\LogManagement\ValueObject\Log\Statistic\LogEntryFrequencyCount;
use Carthage\Domain\LogManagement\ValueObject\Log\Statistic\LogEntrySourceFrequency;
use Carthage\Domain\LogManagement\ValueObject\Log\Statistic\LogEntryTagDistribution;
use DateTimeImmutable;
use Psl\Str;
use Psr\Cache\CacheItemPoolInterface;

final readonly class LogEntryStatisticsService
{
    private const CACHE_DATE_FORMAT = 'Y_m_d';
    private const CACHE_TTL = 1800;
    private const MOST_FREQUENT_SOURCES_CACHE_KEY_FORMAT = 'most_frequent_sources_%s_%s';
    private const TAG_DISTRIBUTION_CACHE_KEY_FORMAT = 'tag_distribution_%s_%s';
    private const LOG_ENTRY_COUNT_CACHE_KEY_FORMAT = 'log_entry_count_%s_%s_%s';

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
    public function getMostFrequentSources(DateTimeImmutable $from, DateTimeImmutable $to): array
    {
        $logEntrySourceFrequenciesItems = $this->cacheItemPool->getItem(Str\format(
            self::MOST_FREQUENT_SOURCES_CACHE_KEY_FORMAT,
            $from->format(self::CACHE_DATE_FORMAT),
            $to->format(self::CACHE_DATE_FORMAT),
        ));

        if (!$logEntrySourceFrequenciesItems->isHit()) {
            $logEntrySourceFrequencies = $this->logEntryRepository->getMostFrequentSources($from, $to);

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
    public function getTagDistribution(DateTimeImmutable $from, DateTimeImmutable $to): array
    {
        $logEntryTagDistributionsItem = $this->cacheItemPool->getItem(Str\format(
            self::TAG_DISTRIBUTION_CACHE_KEY_FORMAT,
            $from->format(self::CACHE_DATE_FORMAT),
            $to->format(self::CACHE_DATE_FORMAT),
        ));

        if (!$logEntryTagDistributionsItem->isHit()) {
            $logEntryTagDistributions = $this->logEntryRepository->getTagDistribution($from, $to);

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
    public function getLogEntryCountByFrequency(Frequency $frequency, DateTimeImmutable $from, DateTimeImmutable $to): array
    {
        $logEntryFrequencyCountsItem = $this->cacheItemPool->getItem(Str\format(
            self::LOG_ENTRY_COUNT_CACHE_KEY_FORMAT,
            $frequency->value,
            $from->format(self::CACHE_DATE_FORMAT),
            $to->format(self::CACHE_DATE_FORMAT),
        ));

        if (!$logEntryFrequencyCountsItem->isHit()) {
            $logEntryFrequencyCounts = $this->logEntryRepository->getLogEntryCountByFrequency($frequency, $from, $to);

            $logEntryFrequencyCountsItem->set($logEntryFrequencyCounts);
            $logEntryFrequencyCountsItem->expiresAfter(self::CACHE_TTL);

            $this->cacheItemPool->save($logEntryFrequencyCountsItem);
        }

        /* @var list<LogEntryFrequencyCount> */
        return $logEntryFrequencyCountsItem->get();
    }
}
