<?php

declare(strict_types=1);

namespace Carthage\Domain\MetricCollection\Filter\Metric;

use Carthage\Domain\Shared\Criteria;
use Carthage\Domain\Shared\Criteria\Enum\OrderDirection;
use Carthage\Domain\Shared\Entity\Identity;
use Carthage\Domain\Shared\Filter\PaginationFilter;
use DateTimeImmutable;

abstract class MetricDataPointFilter extends PaginationFilter
{
    public null|Identity $metricIdentity = null;

    /**
     * @var non-empty-string|null The source from which this data point was generated. Null if not provided.
     */
    public null|string $source = null;

    /**
     * @var DateTimeImmutable|null The start timestamp of the data point. Null if not provided.
     */
    public null|DateTimeImmutable $after = null;

    /**
     * @var DateTimeImmutable|null The end timestamp of the data point. Null if not provided.
     */
    public null|DateTimeImmutable $before = null;

    /**
     * @var OrderDirection The direction to sort the metrics in. Defaults to descending order.
     */
    public OrderDirection $order = OrderDirection::Descending;

    /**
     * Returns a Criteria object based on the properties of this filter.
     */
    public function getCriteria(): Criteria\Criteria
    {
        $expressions = [];

        if (null !== $this->metricIdentity) {
            $expressions[] = Criteria\Expression\Comparison::equal('metric', $this->metricIdentity);
        }

        if (null !== $this->source) {
            $expressions[] = Criteria\Expression\Comparison::equal('source', $this->source);
        }

        if (null !== $this->after) {
            $expressions[] = Criteria\Expression\Comparison::greaterThanOrEqual('startAt', $this->after);
        }

        if (null !== $this->before) {
            $expressions[] = Criteria\Expression\Comparison::lessThanOrEqual('endAt', $this->before);
        }

        return Criteria\Criteria::create(...$expressions)
            ->orderBy('createdAt', $this->order);
    }
}
