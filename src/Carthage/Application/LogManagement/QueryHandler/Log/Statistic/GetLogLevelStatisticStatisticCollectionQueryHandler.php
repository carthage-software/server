<?php

declare(strict_types=1);

namespace Carthage\Application\LogManagement\QueryHandler\Log\Statistic;

use Carthage\Application\LogManagement\Query\Log\Statistic\GetLogLevelStatisticStatisticCollectionQuery;
use Carthage\Application\LogManagement\Resource\Log\Statistic\LogLevelStatisticResource;
use Carthage\Application\LogManagement\Resource\Log\Statistic\StatisticCollectionResource;
use Carthage\Application\LogManagement\Service\Log\Statistic\LogStatisticService;
use Carthage\Application\Shared\QueryHandler\QueryHandlerInterface;
use Psr\Clock\ClockInterface;

final readonly class GetLogLevelStatisticStatisticCollectionQueryHandler implements QueryHandlerInterface
{
    private const DEFAULT_FROM = '-1 month';
    private const DEFAULT_TO = 'now';

    public function __construct(
        private ClockInterface $clock,
        private LogStatisticService $logStatisticService,
    ) {
    }

    /**
     * @return StatisticCollectionResource<LogLevelStatisticResource>
     */
    public function __invoke(GetLogLevelStatisticStatisticCollectionQuery $query): StatisticCollectionResource
    {
        $from = $query->from ?? $this->clock->now()->modify(self::DEFAULT_FROM);
        $to = $query->to ?? $this->clock->now()->modify(self::DEFAULT_TO);

        $logLevelStatistics = $this->logStatisticService->getLogPercentageByLevel($from, $to);

        return StatisticCollectionResource::fromItems($logLevelStatistics, $from, $to, LogLevelStatisticResource::fromLogLevelStatistics(...));
    }
}
