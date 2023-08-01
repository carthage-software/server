<?php

declare(strict_types=1);

namespace Carthage\Application\MetricCollection\QueryHandler\Metric;

use Carthage\Application\MetricCollection\Query\Metric\GetMetricNamespaceCollectionQuery;
use Carthage\Application\Shared\QueryHandler\QueryHandlerInterface;
use Carthage\Domain\MetricCollection\Repository\Metric\MetricRepositoryInterface;
use Carthage\Domain\MetricCollection\Resource\Metric\MetricNamespaceResource;
use Carthage\Domain\Shared\Resource\CollectionResourceInterface;
use Carthage\Domain\Shared\Resource\SimpleCollectionResource;

final readonly class GetMetricNamespaceCollectionQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private MetricRepositoryInterface $metricRepository,
    ) {
    }

    /**
     * @return CollectionResourceInterface<MetricNamespaceResource>
     */
    public function __invoke(GetMetricNamespaceCollectionQuery $query): CollectionResourceInterface
    {
        $namespaces = $this->metricRepository->findAllNamespaces();

        return SimpleCollectionResource::fromItems($namespaces, MetricNamespaceResource::fromNamespace(...));
    }
}
