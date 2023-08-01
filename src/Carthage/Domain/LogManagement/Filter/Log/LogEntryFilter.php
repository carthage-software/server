<?php

declare(strict_types=1);

namespace Carthage\Domain\LogManagement\Filter\Log;

use Carthage\Domain\Shared\Criteria;
use Carthage\Domain\Shared\Criteria\Enum\OrderDirection;
use Carthage\Domain\Shared\Filter\PaginationFilter;
use DateTimeImmutable;
use Symfony\Component\Uid\Ulid;

final class LogEntryFilter extends PaginationFilter
{
    /**
     * @var Ulid|null the unique identifier of the log to filter by
     */
    public ?Ulid $log = null;

    /**
     * @var string|null the source to filter by
     */
    public ?string $source = null;

    /**
     * @var DateTimeImmutable|null the earliest date an entry can have to pass the filter
     */
    public ?DateTimeImmutable $after = null;

    /**
     * @var DateTimeImmutable|null the latest date an entry can have to pass the filter
     */
    public ?DateTimeImmutable $before = null;

    /**
     * @var OrderDirection the direction to sort the entries in
     */
    public OrderDirection $order = OrderDirection::Descending;

    public function getCriteria(): Criteria\Criteria
    {
        $expressions = [];
        if (null !== $this->log) {
            $expressions[] = Criteria\Expression\Comparison::equal('log', $this->log);
        }

        if (null !== $this->source) {
            $expressions[] = Criteria\Expression\Comparison::equal('source', $this->source);
        }

        if (null !== $this->after) {
            $expressions[] = Criteria\Expression\Comparison::greaterThan('occurredAt', $this->after);
        }

        if (null !== $this->before) {
            $expressions[] = Criteria\Expression\Comparison::lessThan('occurredAt', $this->before);
        }

        return Criteria\Criteria::create(...$expressions)
            ->orderBy('createdAt', $this->order);
    }
}
