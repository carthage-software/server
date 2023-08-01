<?php

declare(strict_types=1);

namespace Carthage\Application\MetricCollection\QueryHandler\Metric;

use Carthage\Application\MetricCollection\Query\Metric\GetMetricCollectionQuery;
use Carthage\Application\Shared\QueryHandler\QueryHandlerInterface;
use Carthage\Domain\MetricCollection\Repository\Metric\MetricRepositoryInterface;
use Carthage\Domain\MetricCollection\Resource\Metric\MetricResource;
use Carthage\Domain\Shared\Resource\CollectionResourceInterface;
use Carthage\Domain\Shared\Resource\PaginatedCollectionResource;

final readonly class GetMetricCollectionQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private MetricRepositoryInterface $metricRepository,
    ) {
    }

    /**
     * @return CollectionResourceInterface<MetricResource>
     */
    public function __invoke(GetMetricCollectionQuery $query): CollectionResourceInterface
    {
        $metricPage = $this->metricRepository->paginate($query->metricFilter);

        return PaginatedCollectionResource::fromPage($metricPage, MetricResource::fromMetric(...));
    }
}
