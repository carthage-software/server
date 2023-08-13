<?php

declare(strict_types=1);

namespace Carthage\Application\MetricCollection\QueryHandler\Histogram;

use Carthage\Application\MetricCollection\Query\Histogram\GetHistogramDataPointCollectionQuery;
use Carthage\Application\MetricCollection\Resource\Histogram\HistogramDataPointResource;
use Carthage\Application\Shared\QueryHandler\QueryHandlerInterface;
use Carthage\Application\Shared\Resource\PaginatedCollectionResource;
use Carthage\Domain\MetricCollection\Repository\Histogram\HistogramDataPointRepositoryInterface;

final readonly class GetHistogramDataPointCollectionQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private HistogramDataPointRepositoryInterface $histogramDataPointRepository,
    ) {
    }

    /**
     * @return PaginatedCollectionResource<HistogramDataPointResource>
     */
    public function __invoke(GetHistogramDataPointCollectionQuery $query): PaginatedCollectionResource
    {
        $histogramDataPointPage = $this->histogramDataPointRepository->paginate($query->histogramDataPointFilter);

        return PaginatedCollectionResource::fromPage($histogramDataPointPage, HistogramDataPointResource::fromHistogramDataPoint(...));
    }
}
