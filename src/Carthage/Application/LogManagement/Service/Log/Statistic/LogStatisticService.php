<?php

declare(strict_types=1);

namespace Carthage\Application\LogManagement\Service\Log\Statistic;

use Carthage\Domain\LogManagement\Enum\Log\Statistics\Frequency;
use Carthage\Domain\LogManagement\Repository\Log\LogRepositoryInterface;
use Carthage\Domain\LogManagement\ValueObject\Log\Statistic\LogFrequencyCount;
use Carthage\Domain\LogManagement\ValueObject\Log\Statistic\LogLevelStatistics;
use Psl\Str;
use Psr\Cache\CacheItemPoolInterface;

final readonly class LogStatisticService
{
    private const CACHE_TTL = 1800; // 30 minutes
    private const LOG_PERCENTAGE_BY_LEVEL_CACHE_KEY = 'log_level_statistics';
    private const LOG_FREQUENCY_COUNT_CACHE_KEY_FORMAT = 'log_frequency_count_%s';

    public function __construct(
        private LogRepositoryInterface $logRepository,
        private CacheItemPoolInterface $cacheItemPool,
    ) {
    }

    /**
     * Retrieves the percentage of logs for each log level.
     *
     * @return list<LogLevelStatistics> a list of log level statistics, including the level, count, and percentage
     */
    public function getLogPercentageByLevel(): array
    {
        $logLevelStatisticsItem = $this->cacheItemPool->getItem(self::LOG_PERCENTAGE_BY_LEVEL_CACHE_KEY);

        if (!$logLevelStatisticsItem->isHit()) {
            $logLevelStatistics = $this->logRepository->getLogPercentageByLevel();

            $logLevelStatisticsItem->set($logLevelStatistics);
            $logLevelStatisticsItem->expiresAfter(self::CACHE_TTL);

            $this->cacheItemPool->save($logLevelStatisticsItem);
        }

        /* @var list<LogLevelStatistics> $logLevelStatistics */
        return $logLevelStatisticsItem->get();
    }

    /**
     * Retrieves the count of logs over a given time frequency.
     *
     * @param Frequency $frequency The frequency at which to calculate (e.g., daily, weekly).
     *
     * @return list<LogFrequencyCount> a list of log frequency counts, including the date and count
     */
    public function getLogCountByFrequency(Frequency $frequency): array
    {
        $cacheKey = Str\format(self::LOG_FREQUENCY_COUNT_CACHE_KEY_FORMAT, $frequency->value);

        $logFrequencyCountsItem = $this->cacheItemPool->getItem($cacheKey);

        if (!$logFrequencyCountsItem->isHit()) {
            $logFrequencyCounts = $this->logRepository->getLogCountByFrequency($frequency);

            $logFrequencyCountsItem->set($logFrequencyCounts);
            $logFrequencyCountsItem->expiresAfter(self::CACHE_TTL);

            $this->cacheItemPool->save($logFrequencyCountsItem);
        }

        /* @var list<LogFrequencyCount> $logFrequencyCounts */
        return $logFrequencyCountsItem->get();
    }
}
