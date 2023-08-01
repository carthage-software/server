<?php

declare(strict_types=1);

namespace Carthage\Application\MetricCollection\Query\Histogram;

use Carthage\Application\Shared\Query\QueryInterface;
use Carthage\Domain\MetricCollection\Filter\Histogram\HistogramDataPointFilter;
use Carthage\Domain\MetricCollection\Resource\Histogram\HistogramDataPointResource;
use Carthage\Domain\Shared\Resource\CollectionResourceInterface;

/**
 * @implements QueryInterface<CollectionResourceInterface<HistogramDataPointResource>>
 */
final readonly class GetHistogramDataPointCollectionQuery implements QueryInterface
{
    public function __construct(
        public HistogramDataPointFilter $histogramDataPointFilter,
    ) {
    }
}
