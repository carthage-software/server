<?php

declare(strict_types=1);

namespace Carthage\Application\MetricCollection\Query\Histogram;

use Carthage\Application\MetricCollection\Resource\Histogram\HistogramDataPointResource;
use Carthage\Application\Shared\Query\QueryInterface;
use Carthage\Application\Shared\Resource\PaginatedCollectionResource;
use Carthage\Domain\MetricCollection\Filter\Histogram\HistogramDataPointFilter;

/**
 * @implements QueryInterface<PaginatedCollectionResource<HistogramDataPointResource>>
 */
final readonly class GetHistogramDataPointCollectionQuery implements QueryInterface
{
    public function __construct(
        public HistogramDataPointFilter $histogramDataPointFilter,
    ) {
    }
}
