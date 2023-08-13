<?php

declare(strict_types=1);

namespace Carthage\Application\LogManagement\QueryHandler\Log\Statistic;

use Carthage\Application\LogManagement\Query\Log\Statistic\GetLogEntryTagDistributionCollectionQuery;
use Carthage\Application\LogManagement\Resource\Log\Statistic\LogEntryTagDistributionResource;
use Carthage\Application\LogManagement\Service\Log\Statistic\LogEntryStatisticsService;
use Carthage\Application\Shared\QueryHandler\QueryHandlerInterface;
use Carthage\Application\Shared\Resource\CollectionResource;

final readonly class GetLogEntryTagDistributionCollectionQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private LogEntryStatisticsService $logEntryStatisticsService,
    ) {
    }

    /**
     * @return CollectionResource<LogEntryTagDistributionResource>
     */
    public function __invoke(GetLogEntryTagDistributionCollectionQuery $query): CollectionResource
    {
        $logEntryTagDistributions = $this->logEntryStatisticsService->getTagDistribution();

        return CollectionResource::fromItems(
            $logEntryTagDistributions,
            LogEntryTagDistributionResource::fromLogEntryTagDistribution(...),
        );
    }
}
