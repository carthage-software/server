<?php

declare(strict_types=1);

namespace Carthage\Domain\LogManagement\Filter\Log;

use Carthage\Domain\LogManagement\Enum\Log\Level;
use Carthage\Domain\LogManagement\Enum\Log\SortingField;
use Carthage\Domain\Shared\Criteria;
use Carthage\Domain\Shared\Criteria\Enum\OrderDirection;
use Carthage\Domain\Shared\Filter\PaginationFilter;
use DateTimeImmutable;

final class LogFilter extends PaginationFilter
{
    /**
     * @var list<Level> a list of message levels to filter by
     */
    public array $levels = [];

    /**
     * @var string|null a substring that the template should contain
     */
    public ?string $contains = null;

    /**
     * @var DateTimeImmutable|null the earliest creation date a message can have to pass the filter
     */
    public ?DateTimeImmutable $from = null;

    /**
     * @var DateTimeImmutable|null the latest creation date a message can have to pass the filter
     */
    public ?DateTimeImmutable $to = null;

    /**
     * @var SortingField the field to sort the messages by
     */
    public SortingField $sortBy = SortingField::CreatedAt;

    /**
     * @var OrderDirection the direction to sort the messages in
     */
    public OrderDirection $order = OrderDirection::Descending;

    /**
     * Converts this filter into a Criteria object that can be used for querying.
     *
     * @return Criteria\Criteria the resulting criteria object
     */
    public function getCriteria(): Criteria\Criteria
    {
        $expressions = [];

        if ([] !== $this->levels) {
            $expressions[] = Criteria\Expression\Comparison::in('level', $this->levels);
        }

        if (null !== $this->contains) {
            $expressions[] = Criteria\Expression\Comparison::contains('template', $this->contains);
        }

        // do not use `createdAt` for `from` and `to`.
        if (null !== $this->from) {
            $expressions[] = Criteria\Expression\Composition::or(
                Criteria\Expression\Comparison::greaterThanOrEqual('lastEntryOccurredAt', $this->from),
                Criteria\Expression\Comparison::greaterThanOrEqual('firstEntryOccurredAt', $this->from),
            );
        }

        if (null !== $this->to) {
            $expressions[] = Criteria\Expression\Composition::or(
                Criteria\Expression\Comparison::lessThanOrEqual('lastEntryOccurredAt', $this->to),
                Criteria\Expression\Comparison::lessThanOrEqual('firstEntryOccurredAt', $this->to),
            );
        }

        return Criteria\Criteria::create(...$expressions)
            ->orderBy($this->sortBy->value, $this->order);
    }
}
