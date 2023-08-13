<?php

declare(strict_types=1);

namespace Carthage\Application\MetricCollection\QueryHandler\Histogram;

use Carthage\Application\MetricCollection\Query\Histogram\GetHistogramCollectionQuery;
use Carthage\Application\MetricCollection\Resource\Histogram\HistogramResource;
use Carthage\Application\Shared\QueryHandler\QueryHandlerInterface;
use Carthage\Application\Shared\Resource\PaginatedCollectionResource;
use Carthage\Domain\MetricCollection\Repository\Histogram\HistogramRepositoryInterface;

final readonly class GetHistogramCollectionQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private HistogramRepositoryInterface $histogramRepository,
    ) {
    }

    /**
     * @return PaginatedCollectionResource<HistogramResource>
     */
    public function __invoke(GetHistogramCollectionQuery $query): PaginatedCollectionResource
    {
        $histogramPage = $this->histogramRepository->paginate($query->histogramFilter);

        return PaginatedCollectionResource::fromPage($histogramPage, HistogramResource::fromHistogram(...));
    }
}
