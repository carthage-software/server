<?php

declare(strict_types=1);

namespace Carthage\Domain\MetricCollection\Filter\Summary;

use Carthage\Domain\MetricCollection\Filter\Metric\MetricDataPointFilter;
use Carthage\Domain\Shared\Criteria;

final class SummaryDataPointFilter extends MetricDataPointFilter
{
    /**
     * @var int|float|null The minimum value of the sum data point filter. Null if not provided.
     */
    public int|float|null $minValue = null;

    /**
     * @var int|float|null The maximum value of the sum data point filter. Null if not provided.
     */
    public int|float|null $maxValue = null;

    /**
     * {@inheritDoc}
     */
    public function getCriteria(): Criteria\Criteria
    {
        $criteria = parent::getCriteria();
        $expressions = [];

        if (null !== $this->minValue) {
            $expressions[] = Criteria\Expression\Comparison::greaterThanOrEqual('value', $this->minValue);
        }

        if (null !== $this->maxValue) {
            $expressions[] = Criteria\Expression\Comparison::lessThanOrEqual('value', $this->maxValue);
        }

        return Criteria\Criteria::create(...$expressions)->merge($criteria);
    }
}
