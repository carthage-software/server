<?php

declare(strict_types=1);

namespace Carthage\Application\MetricCollection\Query\Metric;

use Carthage\Application\MetricCollection\Resource\Metric\MetricResource;
use Carthage\Application\Shared\Query\QueryInterface;
use Carthage\Application\Shared\Resource\CollectionResourceInterface;
use Carthage\Domain\MetricCollection\Filter\Metric\MetricFilter;

/**
 * @implements QueryInterface<CollectionResourceInterface<MetricResource>>
 */
final readonly class GetMetricCollectionQuery implements QueryInterface
{
    public function __construct(
        public MetricFilter $metricFilter,
    ) {
    }
}
