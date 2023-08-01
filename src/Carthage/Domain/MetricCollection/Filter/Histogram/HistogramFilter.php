<?php

declare(strict_types=1);

namespace Carthage\Domain\MetricCollection\Filter\Histogram;

use Carthage\Domain\MetricCollection\Enum\Metric\Temporality;
use Carthage\Domain\MetricCollection\Filter\Metric\MetricFilter;
use Carthage\Domain\Shared\Criteria;

final class HistogramFilter extends MetricFilter
{
    /**
     * @var Temporality|null The temporality of the histogram metric. Null if not provided.
     */
    public ?Temporality $temporality = null;

    /**
     * {@inheritDoc}
     */
    public function getCriteria(): Criteria\Criteria
    {
        $criteria = parent::getCriteria();
        $expressions = [];

        if (null !== $this->temporality) {
            $expressions[] = Criteria\Expression\Comparison::equal('temporality', $this->temporality);
        }

        return Criteria\Criteria::create(...$expressions)->merge($criteria);
    }
}
