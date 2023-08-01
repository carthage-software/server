<?php

declare(strict_types=1);

namespace Carthage\Application\MetricCollection\Query\Gauge;

use Carthage\Application\Shared\Query\QueryInterface;
use Carthage\Domain\MetricCollection\Filter\Gauge\GaugeDataPointFilter;
use Carthage\Domain\MetricCollection\Resource\Gauge\GaugeDataPointResource;
use Carthage\Domain\Shared\Resource\CollectionResourceInterface;

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
