<?php

declare(strict_types=1);

namespace Carthage\Application\MetricCollection\Query\Summary;

use Carthage\Application\MetricCollection\Resource\Summary\SummaryResource;
use Carthage\Application\Shared\Query\QueryInterface;
use Carthage\Application\Shared\Resource\CollectionResourceInterface;
use Carthage\Domain\MetricCollection\Filter\Summary\SummaryFilter;

/**
 * @implements QueryInterface<CollectionResourceInterface<SummaryResource>>
 */
final readonly class GetSummaryCollectionQuery implements QueryInterface
{
    public function __construct(
        public SummaryFilter $summaryFilter,
    ) {
    }
}
