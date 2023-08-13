<?php

declare(strict_types=1);

namespace Carthage\Application\LogManagement\QueryHandler\Log\Statistic;

use Carthage\Application\LogManagement\Query\Log\Statistic\GetLogEntryFrequencyCountCollectionQuery;
use Carthage\Application\LogManagement\Resource\Log\Statistic\LogEntryFrequencyCountResource;
use Carthage\Application\LogManagement\Service\Log\Statistic\LogEntryStatisticsService;
use Carthage\Application\Shared\QueryHandler\QueryHandlerInterface;
use Carthage\Application\Shared\Resource\CollectionResource;

final readonly class GetLogEntryFrequencyCountCollectionQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private LogEntryStatisticsService $logEntryStatisticsService
    ) {
    }

    /**
     * @return CollectionResource<LogEntryFrequencyCountResource>
     */
    public function __invoke(GetLogEntryFrequencyCountCollectionQuery $query): CollectionResource
    {
        $logEntryCountByFrequencies = $this->logEntryStatisticsService->getLogEntryCountByFrequency($query->frequency);

        return CollectionResource::fromItems(
            $logEntryCountByFrequencies,
            LogEntryFrequencyCountResource::fromLogEntryFrequencyCount(...),
        );
    }
}
