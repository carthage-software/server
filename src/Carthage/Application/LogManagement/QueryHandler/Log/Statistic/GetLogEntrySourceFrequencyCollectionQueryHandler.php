<?php

declare(strict_types=1);

namespace Carthage\Application\LogManagement\QueryHandler\Log\Statistic;

use Carthage\Application\LogManagement\Query\Log\Statistic\GetLogEntrySourceFrequencyCollectionQuery;
use Carthage\Application\LogManagement\Resource\Log\Statistic\LogEntrySourceFrequencyResource;
use Carthage\Application\LogManagement\Service\Log\Statistic\LogEntryStatisticsService;
use Carthage\Application\Shared\QueryHandler\QueryHandlerInterface;
use Carthage\Application\Shared\Resource\CollectionResource;

final readonly class GetLogEntrySourceFrequencyCollectionQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private LogEntryStatisticsService $logEntryStatisticsService
    ) {
    }

    /**
     * @return CollectionResource<LogEntrySourceFrequencyResource>
     */
    public function __invoke(GetLogEntrySourceFrequencyCollectionQuery $query): CollectionResource
    {
        $logEntryCountBySourceFrequencies = $this->logEntryStatisticsService->getMostFrequentSources();

        return CollectionResource::fromItems(
            $logEntryCountBySourceFrequencies,
            LogEntrySourceFrequencyResource::fromLogEntrySourceFrequency(...),
        );
    }
}
