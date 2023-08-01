<?php

declare(strict_types=1);

namespace Carthage\Domain\MetricCollection\Filter\Metric;

use Carthage\Domain\Shared\Criteria;
use Carthage\Domain\Shared\Criteria\Enum\OrderDirection;
use Carthage\Domain\Shared\Filter\PaginationFilter;

class MetricFilter extends PaginationFilter
{
    /**
     * @var non-empty-string|null The namespace of the metric. Null if not provided.
     */
    public ?string $namespace = null;

    /**
     * @var non-empty-string|null The name of the metric. Null if not provided.
     */
    public ?string $name = null;

    /**
     * @var non-empty-string|null The description of the metric. Null if not provided.
     */
    public ?string $description = null;

    /**
     * @var non-empty-string|null The unit of the metric. Null if not provided.
     */
    public ?string $unit = null;

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
        if (null !== $this->namespace) {
            $expressions[] = Criteria\Expression\Comparison::equal('namespace', $this->namespace);
        }

        if (null !== $this->name) {
            $expressions[] = Criteria\Expression\Comparison::equal('name', $this->name);
        }

        if (null !== $this->description) {
            $expressions[] = Criteria\Expression\Comparison::contains('description', $this->description);
        }

        if (null !== $this->unit) {
            $expressions[] = Criteria\Expression\Comparison::equal('unit', $this->unit);
        }

        return Criteria\Criteria::create(...$expressions)
            ->orderBy('createdAt', $this->order);
    }
}
