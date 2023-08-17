<?php

declare(strict_types=1);

namespace Carthage\Application\LogManagement\QueryHandler\Log\Statistic;

use Carthage\Application\LogManagement\Query\Log\Statistic\GetLogFrequencyCountStatisticCollectionQuery;
use Carthage\Application\LogManagement\Resource\Log\Statistic\LogFrequencyCountResource;
use Carthage\Application\LogManagement\Resource\Log\Statistic\StatisticCollectionResource;
use Carthage\Application\LogManagement\Service\Log\Statistic\LogStatisticService;
use Carthage\Application\Shared\QueryHandler\QueryHandlerInterface;
use Psr\Clock\ClockInterface;

final readonly class GetLogFrequencyCountStatisticCollectionQueryHandler implements QueryHandlerInterface
{
    private const DEFAULT_FROM = '-1 month';
    private const DEFAULT_TO = 'now';

    public function __construct(
        private ClockInterface $clock,
        private LogStatisticService $logStatisticService,
    ) {
    }

    /**
     * @return StatisticCollectionResource<LogFrequencyCountResource>
     */
    public function __invoke(GetLogFrequencyCountStatisticCollectionQuery $query): StatisticCollectionResource
    {
        $from = $query->from ?? $this->clock->now()->modify(self::DEFAULT_FROM);
        $to = $query->to ?? $this->clock->now()->modify(self::DEFAULT_TO);

        $logFrequencyCounts = $this
            ->logStatisticService
            ->getLogCountByFrequency($query->frequency, $from, $to)
        ;

        return StatisticCollectionResource::fromItems($logFrequencyCounts, $from, $to, LogFrequencyCountResource::fromLogFrequencyCount(...));
    }
}
