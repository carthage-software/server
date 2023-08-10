<?php

declare(strict_types=1);

namespace Carthage\Application\LogManagement\QueryHandler\Log\Statistic;

use Carthage\Application\LogManagement\Query\Log\Statistic\GetLogEntrySourceFrequencyCollectionQuery;
use Carthage\Application\LogManagement\Service\Log\Statistic\LogEntryStatisticsService;
use Carthage\Application\Shared\QueryHandler\QueryHandlerInterface;
use Carthage\Domain\LogManagement\Resource\Log\Statistic\LogEntrySourceFrequencyResource;
use Carthage\Domain\Shared\Resource\SimpleCollectionResource;

final readonly class GetLogEntrySourceFrequencyCollectionQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private LogEntryStatisticsService $logEntryStatisticsService
    ) {
    }

    /**
     * @return SimpleCollectionResource<LogEntrySourceFrequencyResource>
     */
    public function __invoke(GetLogEntrySourceFrequencyCollectionQuery $query): SimpleCollectionResource
    {
        $logEntryCountBySourceFrequencies = $this->logEntryStatisticsService->getMostFrequentSources();

        return SimpleCollectionResource::fromItems(
            $logEntryCountBySourceFrequencies,
            LogEntrySourceFrequencyResource::fromLogEntrySourceFrequency(...),
        );
    }
}
