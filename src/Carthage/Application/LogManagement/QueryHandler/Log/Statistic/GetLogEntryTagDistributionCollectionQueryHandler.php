<?php

declare(strict_types=1);

namespace Carthage\Application\LogManagement\QueryHandler\Log\Statistic;

use Carthage\Application\LogManagement\Query\Log\Statistic\GetLogEntryTagDistributionCollectionQuery;
use Carthage\Application\LogManagement\Resource\Log\Statistic\LogEntryTagDistributionResource;
use Carthage\Application\LogManagement\Service\Log\Statistic\LogEntryStatisticsService;
use Carthage\Application\Shared\QueryHandler\QueryHandlerInterface;
use Carthage\Application\Shared\Resource\SimpleCollectionResource;

final readonly class GetLogEntryTagDistributionCollectionQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private LogEntryStatisticsService $logEntryStatisticsService,
    ) {
    }

    /**
     * @return SimpleCollectionResource<LogEntryTagDistributionResource>
     */
    public function __invoke(GetLogEntryTagDistributionCollectionQuery $query): SimpleCollectionResource
    {
        $logEntryTagDistributions = $this->logEntryStatisticsService->getTagDistribution();

        return SimpleCollectionResource::fromItems(
            $logEntryTagDistributions,
            LogEntryTagDistributionResource::fromLogEntryTagDistribution(...),
        );
    }
}
