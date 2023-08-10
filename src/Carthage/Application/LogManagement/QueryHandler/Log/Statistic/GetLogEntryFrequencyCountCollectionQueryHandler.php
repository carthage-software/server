<?php

declare(strict_types=1);

namespace Carthage\Application\LogManagement\QueryHandler\Log\Statistic;

use Carthage\Application\LogManagement\Query\Log\Statistic\GetLogEntryFrequencyCountCollectionQuery;
use Carthage\Application\LogManagement\Service\Log\Statistic\LogEntryStatisticsService;
use Carthage\Application\Shared\QueryHandler\QueryHandlerInterface;
use Carthage\Domain\LogManagement\Resource\Log\Statistic\LogEntryFrequencyCountResource;
use Carthage\Domain\Shared\Resource\SimpleCollectionResource;

final readonly class GetLogEntryFrequencyCountCollectionQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private LogEntryStatisticsService $logEntryStatisticsService
    ) {
    }

    /**
     * @return SimpleCollectionResource<LogEntryFrequencyCountResource>
     */
    public function __invoke(GetLogEntryFrequencyCountCollectionQuery $query): SimpleCollectionResource
    {
        $logEntryCountByFrequencies = $this->logEntryStatisticsService->getLogEntryCountByFrequency($query->frequency);

        return SimpleCollectionResource::fromItems(
            $logEntryCountByFrequencies,
            LogEntryFrequencyCountResource::fromLogEntryFrequencyCount(...),
        );
    }
}
