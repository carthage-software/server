<?php

declare(strict_types=1);

namespace Carthage\Application\MetricCollection\Query\Gauge;

use Carthage\Application\MetricCollection\Resource\Gauge\GaugeResource;
use Carthage\Application\Shared\Query\QueryInterface;
use Carthage\Application\Shared\Resource\PaginatedCollectionResource;
use Carthage\Domain\MetricCollection\Filter\Gauge\GaugeFilter;

/**
 * @implements QueryInterface<PaginatedCollectionResource<GaugeResource>>
 */
final readonly class GetGaugeCollectionQuery implements QueryInterface
{
    public function __construct(
        public GaugeFilter $gaugeFilter,
    ) {
    }
}
