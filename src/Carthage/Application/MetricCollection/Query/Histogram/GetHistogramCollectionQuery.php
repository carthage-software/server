<?php

declare(strict_types=1);

namespace Carthage\Application\MetricCollection\Query\Histogram;

use Carthage\Application\Shared\Query\QueryInterface;
use Carthage\Domain\MetricCollection\Filter\Histogram\HistogramFilter;
use Carthage\Domain\MetricCollection\Resource\Histogram\HistogramResource;
use Carthage\Domain\Shared\Resource\CollectionResourceInterface;

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
