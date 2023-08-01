<?php

declare(strict_types=1);

namespace Carthage\Application\MetricCollection\QueryHandler\Histogram;

use Carthage\Application\MetricCollection\Query\Histogram\GetHistogramCollectionQuery;
use Carthage\Application\Shared\QueryHandler\QueryHandlerInterface;
use Carthage\Domain\MetricCollection\Repository\Histogram\HistogramRepositoryInterface;
use Carthage\Domain\MetricCollection\Resource\Histogram\HistogramResource;
use Carthage\Domain\Shared\Resource\CollectionResourceInterface;
use Carthage\Domain\Shared\Resource\PaginatedCollectionResource;

final readonly class GetHistogramCollectionQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private HistogramRepositoryInterface $histogramRepository,
    ) {
    }

    /**
     * @return CollectionResourceInterface<HistogramResource>
     */
    public function __invoke(GetHistogramCollectionQuery $query): CollectionResourceInterface
    {
        $histogramPage = $this->histogramRepository->paginate($query->histogramFilter);

        return PaginatedCollectionResource::fromPage($histogramPage, HistogramResource::fromHistogram(...));
    }
}
