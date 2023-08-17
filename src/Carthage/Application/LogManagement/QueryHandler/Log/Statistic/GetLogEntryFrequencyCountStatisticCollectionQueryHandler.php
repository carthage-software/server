<?php

declare(strict_types=1);

namespace Carthage\Application\LogManagement\QueryHandler\Log\Statistic;

use Carthage\Application\LogManagement\Query\Log\Statistic\GetLogEntryFrequencyCountStatisticCollectionQuery;
use Carthage\Application\LogManagement\Resource\Log\Statistic\LogEntryFrequencyCountResource;
use Carthage\Application\LogManagement\Resource\Log\Statistic\StatisticCollectionResource;
use Carthage\Application\LogManagement\Service\Log\Statistic\LogEntryStatisticsService;
use Carthage\Application\Shared\QueryHandler\QueryHandlerInterface;
use Psr\Clock\ClockInterface;

final readonly class GetLogEntryFrequencyCountStatisticCollectionQueryHandler implements QueryHandlerInterface
{
    private const DEFAULT_FROM = '-1 month';
    private const DEFAULT_TO = 'now';

    public function __construct(
        private ClockInterface $clock,
        private LogEntryStatisticsService $logEntryStatisticsService,
    ) {
    }

    /**
     * @return StatisticCollectionResource<LogEntryFrequencyCountResource>
     */
    public function __invoke(GetLogEntryFrequencyCountStatisticCollectionQuery $query): StatisticCollectionResource
    {
        $from = $query->from ?? $this->clock->now()->modify(self::DEFAULT_FROM);
        $to = $query->to ?? $this->clock->now()->modify(self::DEFAULT_TO);

        $logEntryCountByFrequencies = $this
            ->logEntryStatisticsService
            ->getLogEntryCountByFrequency($query->frequency, $from, $to)
        ;

        return StatisticCollectionResource::fromItems($logEntryCountByFrequencies, $from, $to, LogEntryFrequencyCountResource::fromLogEntryFrequencyCount(...));
    }
}
