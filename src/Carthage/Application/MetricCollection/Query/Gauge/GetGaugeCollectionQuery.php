<?php

declare(strict_types=1);

namespace Carthage\Application\MetricCollection\Query\Gauge;

use Carthage\Application\Shared\Query\QueryInterface;
use Carthage\Domain\MetricCollection\Filter\Gauge\GaugeFilter;
use Carthage\Domain\MetricCollection\Resource\Gauge\GaugeResource;
use Carthage\Domain\Shared\Resource\CollectionResourceInterface;

/**
 * @implements QueryInterface<CollectionResourceInterface<GaugeResource>>
 */
final readonly class GetGaugeCollectionQuery implements QueryInterface
{
    public function __construct(
        public GaugeFilter $gaugeFilter,
    ) {
    }
}
