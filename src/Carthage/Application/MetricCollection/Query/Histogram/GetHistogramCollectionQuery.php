<?php

declare(strict_types=1);

namespace Carthage\Application\MetricCollection\Query\Histogram;

use Carthage\Application\MetricCollection\Resource\Histogram\HistogramResource;
use Carthage\Application\Shared\Query\QueryInterface;
use Carthage\Application\Shared\Resource\CollectionResourceInterface;
use Carthage\Domain\MetricCollection\Filter\Histogram\HistogramFilter;

/**
 * @implements QueryInterface<CollectionResourceInterface<HistogramResource>>
 */
final readonly class GetHistogramCollectionQuery implements QueryInterface
{
    public function __construct(
        public HistogramFilter $histogramFilter,
    ) {
    }
}
