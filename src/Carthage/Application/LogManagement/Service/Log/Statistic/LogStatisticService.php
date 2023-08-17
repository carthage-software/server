<?php

declare(strict_types=1);

namespace Carthage\Application\LogManagement\Service\Log\Statistic;

use Carthage\Domain\LogManagement\Enum\Log\Statistics\Frequency;
use Carthage\Domain\LogManagement\Repository\Log\LogRepositoryInterface;
use Carthage\Domain\LogManagement\ValueObject\Log\Statistic\LogFrequencyCount;
use Carthage\Domain\LogManagement\ValueObject\Log\Statistic\LogLevelStatistic;
use DateTimeImmutable;
use Psl\Str;
use Psr\Cache\CacheItemPoolInterface;

final readonly class LogStatisticService
{
    private const CACHE_DATE_FORMAT = 'Y_m_d';
    private const CACHE_TTL = 1800; // 30 minutes
    private const LOG_PERCENTAGE_BY_LEVEL_CACHE_KEY_FORMAT = 'log_level_statistics_%s_%s';
    private const LOG_FREQUENCY_COUNT_CACHE_KEY_FORMAT = 'log_frequency_count_%s_%s_%s';

    public function __construct(
        private LogRepositoryInterface $logRepository,
        private CacheItemPoolInterface $cacheItemPool,
    ) {
    }

    /**
     * Retrieves the percentage of logs for each log level.
     *
     * @return list<LogLevelStatistic> a list of log level statistics, including the level, count, and percentage
     */
    public function getLogPercentageByLevel(DateTimeImmutable $from, DateTimeImmutable $to): array
    {
        $logLevelStatisticsItem = $this->cacheItemPool->getItem(Str\format(
            self::LOG_PERCENTAGE_BY_LEVEL_CACHE_KEY_FORMAT,
            $from->format(self::CACHE_DATE_FORMAT),
            $to->format(self::CACHE_DATE_FORMAT),
        ));

        if (!$logLevelStatisticsItem->isHit()) {
            $logLevelStatistics = $this->logRepository->getLogPercentageByLevel($from, $to);

            $logLevelStatisticsItem->set($logLevelStatistics);
            $logLevelStatisticsItem->expiresAfter(self::CACHE_TTL);

            $this->cacheItemPool->save($logLevelStatisticsItem);
        }

        /* @var list<LogLevelStatistic> $logLevelStatistics */
        return $logLevelStatisticsItem->get();
    }

    /**
     * Retrieves the count of logs over a given time frequency.
     *
     * @param Frequency $frequency The frequency at which to calculate (e.g., daily, weekly).
     *
     * @return list<LogFrequencyCount> a list of log frequency counts, including the date and count
     */
    public function getLogCountByFrequency(Frequency $frequency, DateTimeImmutable $from, DateTimeImmutable $to): array
    {
        $logFrequencyCountsItem = $this->cacheItemPool->getItem(Str\format(
            self::LOG_FREQUENCY_COUNT_CACHE_KEY_FORMAT,
            $frequency->value,
            $from->format(self::CACHE_DATE_FORMAT),
            $to->format(self::CACHE_DATE_FORMAT),
        ));

        if (!$logFrequencyCountsItem->isHit()) {
            $logFrequencyCounts = $this->logRepository->getLogCountByFrequency($frequency, $from, $to);

            $logFrequencyCountsItem->set($logFrequencyCounts);
            $logFrequencyCountsItem->expiresAfter(self::CACHE_TTL);

            $this->cacheItemPool->save($logFrequencyCountsItem);
        }

        /* @var list<LogFrequencyCount> $logFrequencyCounts */
        return $logFrequencyCountsItem->get();
    }
}
