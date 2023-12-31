<?php

declare(strict_types=1);

namespace Carthage\Application\MetricCollection\Query\Summary;

use Carthage\Application\MetricCollection\Resource\Summary\SummaryDataPointResource;
use Carthage\Application\Shared\Query\QueryInterface;
use Carthage\Application\Shared\Resource\PaginatedCollectionResource;
use Carthage\Domain\MetricCollection\Filter\Summary\SummaryDataPointFilter;

/**
 * @implements QueryInterface<PaginatedCollectionResource<SummaryDataPointResource>>
 */
final readonly class GetSummaryDataPointCollectionQuery implements QueryInterface
{
    public function __construct(
        public SummaryDataPointFilter $summaryDataPointFilter,
    ) {
    }
}
