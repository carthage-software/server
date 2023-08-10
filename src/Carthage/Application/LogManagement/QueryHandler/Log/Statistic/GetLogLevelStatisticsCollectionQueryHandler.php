<?php

declare(strict_types=1);

namespace Carthage\Application\LogManagement\QueryHandler\Log\Statistic;

use Carthage\Application\LogManagement\Query\Log\Statistic\GetLogLevelStatisticsCollectionQuery;
use Carthage\Application\LogManagement\Service\Log\Statistic\LogStatisticService;
use Carthage\Application\Shared\QueryHandler\QueryHandlerInterface;
use Carthage\Domain\LogManagement\Resource\Log\Statistic\LogLevelStatisticsResource;
use Carthage\Domain\Shared\Resource\SimpleCollectionResource;

final readonly class GetLogLevelStatisticsCollectionQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private LogStatisticService $logStatisticService,
    ) {
    }

    /**
     * @return SimpleCollectionResource<LogLevelStatisticsResource>
     */
    public function __invoke(GetLogLevelStatisticsCollectionQuery $query): SimpleCollectionResource
    {
        $logLevelStatistics = $this->logStatisticService->getLogPercentageByLevel();

        return SimpleCollectionResource::fromItems(
            $logLevelStatistics,
            LogLevelStatisticsResource::fromLogLevelStatistics(...),
        );
    }
}
