<?php

declare(strict_types=1);

namespace Carthage\Application\MetricCollection\QueryHandler\Summary;

use Carthage\Application\MetricCollection\Query\Summary\GetSummaryDataPointCollectionQuery;
use Carthage\Application\MetricCollection\Resource\Summary\SummaryDataPointResource;
use Carthage\Application\Shared\QueryHandler\QueryHandlerInterface;
use Carthage\Application\Shared\Resource\CollectionResourceInterface;
use Carthage\Application\Shared\Resource\PaginatedCollectionResource;
use Carthage\Domain\MetricCollection\Repository\Summary\SummaryDataPointRepositoryInterface;

final readonly class GetSummaryDataPointCollectionQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private SummaryDataPointRepositoryInterface $summaryDataPointRepository,
    ) {
    }

    /**
     * @return CollectionResourceInterface<SummaryDataPointResource>
     */
    public function __invoke(GetSummaryDataPointCollectionQuery $query): CollectionResourceInterface
    {
        $summaryDataPointPage = $this->summaryDataPointRepository->paginate($query->summaryDataPointFilter);

        return PaginatedCollectionResource::fromPage($summaryDataPointPage, SummaryDataPointResource::fromSummaryDataPoint(...));
    }
}
