<?php

declare(strict_types=1);

namespace Carthage\Application\LogManagement\QueryHandler\Log\Statistic;

use Carthage\Application\LogManagement\Query\Log\Statistic\GetLogFrequencyCountCollectionQuery;
use Carthage\Application\LogManagement\Resource\Log\Statistic\LogFrequencyCountResource;
use Carthage\Application\LogManagement\Service\Log\Statistic\LogStatisticService;
use Carthage\Application\Shared\QueryHandler\QueryHandlerInterface;
use Carthage\Application\Shared\Resource\SimpleCollectionResource;

final readonly class GetLogFrequencyCountCollectionQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private LogStatisticService $logStatisticService,
    ) {
    }

    /**
     * @return SimpleCollectionResource<LogFrequencyCountResource>
     */
    public function __invoke(GetLogFrequencyCountCollectionQuery $query): SimpleCollectionResource
    {
        $logFrequencyCounts = $this->logStatisticService->getLogCountByFrequency($query->frequency);

        return SimpleCollectionResource::fromItems(
            $logFrequencyCounts,
            LogFrequencyCountResource::fromLogFrequencyCount(...),
        );
    }
}
