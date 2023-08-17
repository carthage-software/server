<?php

declare(strict_types=1);

namespace Carthage\Application\LogManagement\QueryHandler\Log\Statistic;

use Carthage\Application\LogManagement\Query\Log\Statistic\GetLogEntrySourceFrequencyStatisticCollectionQuery;
use Carthage\Application\LogManagement\Resource\Log\Statistic\LogEntrySourceFrequencyResource;
use Carthage\Application\LogManagement\Resource\Log\Statistic\StatisticCollectionResource;
use Carthage\Application\LogManagement\Service\Log\Statistic\LogEntryStatisticsService;
use Carthage\Application\Shared\QueryHandler\QueryHandlerInterface;
use Psr\Clock\ClockInterface;

final readonly class GetLogEntrySourceFrequencyStatisticCollectionQueryHandler implements QueryHandlerInterface
{
    private const DEFAULT_FROM = '-1 month';
    private const DEFAULT_TO = 'now';

    public function __construct(
        private ClockInterface $clock,
        private LogEntryStatisticsService $logEntryStatisticsService,
    ) {
    }

    /**
     * @return StatisticCollectionResource<LogEntrySourceFrequencyResource>
     */
    public function __invoke(GetLogEntrySourceFrequencyStatisticCollectionQuery $query): StatisticCollectionResource
    {
        $from = $query->from ?? $this->clock->now()->modify(self::DEFAULT_FROM);
        $to = $query->to ?? $this->clock->now()->modify(self::DEFAULT_TO);

        $logEntryCountBySourceFrequencies = $this
            ->logEntryStatisticsService
            ->getMostFrequentSources($from, $to)
        ;

        return StatisticCollectionResource::fromItems(
            $logEntryCountBySourceFrequencies,
            $from,
            $to,
            LogEntrySourceFrequencyResource::fromLogEntrySourceFrequency(...),
        );
    }
}
