<?php

declare(strict_types=1);

namespace Carthage\Domain\MetricCollection\Filter\Histogram;

use Carthage\Domain\MetricCollection\Filter\Metric\MetricDataPointFilter;
use Carthage\Domain\Shared\Criteria;

final class HistogramDataPointFilter extends MetricDataPointFilter
{
    /**
     * @var int|float|null The lower bound of the data point. Null if not provided.
     */
    public null|int|float $lowerBound = null;

    /**
     * @var int|float|null The upper bound of the data point. Null if not provided.
     */
    public null|int|float $upperBound = null;

    /**
     * @var int|null The count of the data point. Null if not provided.
     */
    public null|int $exactCount = null;

    /**
     * @var int|null The count of the data point. Null if not provided.
     */
    public null|int $minCount = null;

    /**
     * @var int|null The count of the data point. Null if not provided.
     */
    public null|int $maxCount = null;

    /**
     * @var int|float|null The summation of the data point. Null if not provided.
     */
    public null|int|float $summation = null;

    /**
     * @var int|float|null The minimum value of the data point. Null if not provided.
     */
    public null|int|float $minimum = null;

    /**
     * @var int|float|null The maximum value of the data point. Null if not provided.
     */
    public null|int|float $maximum = null;

    /**
     * {@inheritDoc}
     */
    public function getCriteria(): Criteria\Criteria
    {
        $criteria = parent::getCriteria();
        $expressions = [];

        if (null !== $this->lowerBound) {
            $expressions[] = Criteria\Expression\Comparison::equal('lowerBound', $this->lowerBound);
        }

        if (null !== $this->upperBound) {
            $expressions[] = Criteria\Expression\Comparison::equal('upperBound', $this->upperBound);
        }

        if (null !== $this->exactCount) {
            $expressions[] = Criteria\Expression\Comparison::equal('count', $this->exactCount);
        } else {
            if (null !== $this->minCount) {
                $expressions[] = Criteria\Expression\Comparison::greaterThanOrEqual('count', $this->minCount);
            }

            if (null !== $this->maxCount) {
                $expressions[] = Criteria\Expression\Comparison::lessThanOrEqual('count', $this->maxCount);
            }
        }

        if (null !== $this->summation) {
            $expressions[] = Criteria\Expression\Comparison::equal('summation', $this->summation);
        }

        if (null !== $this->minimum) {
            $expressions[] = Criteria\Expression\Comparison::equal('minimum', $this->minimum);
        }

        if (null !== $this->maximum) {
            $expressions[] = Criteria\Expression\Comparison::equal('maximum', $this->maximum);
        }

        return Criteria\Criteria::create(...$expressions)->merge($criteria);
    }
}
