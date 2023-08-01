<?php

declare(strict_types=1);

namespace Carthage\Application\MetricCollection\QueryHandler\Metric;

use Carthage\Application\MetricCollection\Query\Metric\GetMetricQuery;
use Carthage\Application\Shared\QueryHandler\QueryHandlerInterface;
use Carthage\Domain\MetricCollection\Repository\Metric\MetricRepositoryInterface;
use Carthage\Domain\MetricCollection\Resource\Metric\MetricResource;

final readonly class GetMetricQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private MetricRepositoryInterface $metricRepository,
    ) {
    }

    public function __invoke(GetMetricQuery $query): ?MetricResource
    {
        $metric = $this->metricRepository->findOneMatching($query->criteria);
        if (null === $metric) {
            return null;
        }

        return MetricResource::fromMetric($metric);
    }
}
