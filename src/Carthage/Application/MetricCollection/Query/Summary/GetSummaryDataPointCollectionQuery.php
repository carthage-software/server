<?php

declare(strict_types=1);

namespace Carthage\Application\MetricCollection\Query\Summary;

use Carthage\Application\Shared\Query\QueryInterface;
use Carthage\Domain\MetricCollection\Filter\Summary\SummaryDataPointFilter;
use Carthage\Domain\MetricCollection\Resource\Summary\SummaryDataPointResource;
use Carthage\Domain\Shared\Resource\CollectionResourceInterface;

/**
 * @implements QueryInterface<CollectionResourceInterface<SummaryDataPointResource>>
 */
final readonly class GetSummaryDataPointCollectionQuery implements QueryInterface
{
    public function __construct(
        public SummaryDataPointFilter $summaryDataPointFilter,
    ) {
    }
}
