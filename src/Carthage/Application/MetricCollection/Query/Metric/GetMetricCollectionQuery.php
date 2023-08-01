<?php

declare(strict_types=1);

namespace Carthage\Application\MetricCollection\Query\Metric;

use Carthage\Application\Shared\Query\QueryInterface;
use Carthage\Domain\MetricCollection\Filter\Metric\MetricFilter;
use Carthage\Domain\MetricCollection\Resource\Metric\MetricResource;
use Carthage\Domain\Shared\Resource\CollectionResourceInterface;

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
