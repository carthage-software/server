<?php

declare(strict_types=1);

namespace Carthage\Application\MetricCollection\QueryHandler\Metric;

use Carthage\Application\MetricCollection\Query\Metric\GetMetricCollectionQuery;
use Carthage\Application\MetricCollection\Resource\Metric\MetricResource;
use Carthage\Application\Shared\QueryHandler\QueryHandlerInterface;
use Carthage\Application\Shared\Resource\PaginatedCollectionResource;
use Carthage\Domain\MetricCollection\Repository\Metric\MetricRepositoryInterface;

final readonly class GetMetricCollectionQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private MetricRepositoryInterface $metricRepository,
    ) {
    }

    /**
     * @return PaginatedCollectionResource<MetricResource>
     */
    public function __invoke(GetMetricCollectionQuery $query): PaginatedCollectionResource
    {
        $metricPage = $this->metricRepository->paginate($query->metricFilter);

        return PaginatedCollectionResource::fromPage($metricPage, MetricResource::fromMetric(...));
    }
}
