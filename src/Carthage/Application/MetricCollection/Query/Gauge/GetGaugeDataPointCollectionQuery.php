<?php

declare(strict_types=1);

namespace Carthage\Application\MetricCollection\Query\Gauge;

use Carthage\Application\MetricCollection\Resource\Gauge\GaugeDataPointResource;
use Carthage\Application\Shared\Query\QueryInterface;
use Carthage\Application\Shared\Resource\CollectionResourceInterface;
use Carthage\Domain\MetricCollection\Filter\Gauge\GaugeDataPointFilter;

/**
 * @implements QueryInterface<CollectionResourceInterface<GaugeDataPointResource>>
 */
final readonly class GetGaugeDataPointCollectionQuery implements QueryInterface
{
    public function __construct(
        public GaugeDataPointFilter $gaugeDataPointFilter,
    ) {
    }
}
