<?php

declare(strict_types=1);

namespace Carthage\Application\LogManagement\QueryHandler\Log\Statistic;

use Carthage\Application\LogManagement\Query\Log\Statistic\GetLogFrequencyCountCollectionQuery;
use Carthage\Application\LogManagement\Resource\Log\Statistic\LogFrequencyCountResource;
use Carthage\Application\LogManagement\Service\Log\Statistic\LogStatisticService;
use Carthage\Application\Shared\QueryHandler\QueryHandlerInterface;
use Carthage\Application\Shared\Resource\CollectionResource;

final readonly class GetLogFrequencyCountCollectionQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private LogStatisticService $logStatisticService,
    ) {
    }

    /**
     * @return CollectionResource<LogFrequencyCountResource>
     */
    public function __invoke(GetLogFrequencyCountCollectionQuery $query): CollectionResource
    {
        $logFrequencyCounts = $this->logStatisticService->getLogCountByFrequency($query->frequency);

        return CollectionResource::fromItems(
            $logFrequencyCounts,
            LogFrequencyCountResource::fromLogFrequencyCount(...),
        );
    }
}
