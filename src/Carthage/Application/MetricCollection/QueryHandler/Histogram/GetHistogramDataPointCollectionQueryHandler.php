<?php

declare(strict_types=1);

namespace Carthage\Application\MetricCollection\QueryHandler\Histogram;

use Carthage\Application\MetricCollection\Query\Histogram\GetHistogramDataPointCollectionQuery;
use Carthage\Application\Shared\QueryHandler\QueryHandlerInterface;
use Carthage\Domain\MetricCollection\Repository\Histogram\HistogramDataPointRepositoryInterface;
use Carthage\Domain\MetricCollection\Resource\Histogram\HistogramDataPointResource;
use Carthage\Domain\Shared\Resource\CollectionResourceInterface;
use Carthage\Domain\Shared\Resource\PaginatedCollectionResource;

final readonly class GetHistogramDataPointCollectionQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private HistogramDataPointRepositoryInterface $histogramDataPointRepository,
    ) {
    }

    /**
     * @return CollectionResourceInterface<HistogramDataPointResource>
     */
    public function __invoke(GetHistogramDataPointCollectionQuery $query): CollectionResourceInterface
    {
        $histogramDataPointPage = $this->histogramDataPointRepository->paginate($query->histogramDataPointFilter);

        return PaginatedCollectionResource::fromPage($histogramDataPointPage, HistogramDataPointResource::fromHistogramDataPoint(...));
    }
}
