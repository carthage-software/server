<?php

declare(strict_types=1);

namespace Carthage\Application\MetricCollection\QueryHandler\Metric;

use Carthage\Application\MetricCollection\Query\Metric\GetMetricNamespaceCollectionQuery;
use Carthage\Application\MetricCollection\Resource\Metric\MetricNamespaceResource;
use Carthage\Application\Shared\QueryHandler\QueryHandlerInterface;
use Carthage\Application\Shared\Resource\CollectionResource;
use Carthage\Domain\MetricCollection\Repository\Metric\MetricRepositoryInterface;

final readonly class GetMetricNamespaceCollectionQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private MetricRepositoryInterface $metricRepository,
    ) {
    }

    /**
     * @return CollectionResource<MetricNamespaceResource>
     */
    public function __invoke(GetMetricNamespaceCollectionQuery $query): CollectionResource
    {
        $namespaces = $this->metricRepository->findAllNamespaces();

        return CollectionResource::fromItems($namespaces, MetricNamespaceResource::fromNamespace(...));
    }
}
