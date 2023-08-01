<?php

declare(strict_types=1);

namespace Carthage\Application\MetricCollection\Query\Summary;

use Carthage\Application\Shared\Query\QueryInterface;
use Carthage\Domain\MetricCollection\Filter\Summary\SummaryFilter;
use Carthage\Domain\MetricCollection\Resource\Summary\SummaryResource;
use Carthage\Domain\Shared\Resource\CollectionResourceInterface;

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
