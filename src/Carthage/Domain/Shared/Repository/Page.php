<?php

declare(strict_types=1);

namespace Carthage\Domain\Shared\Repository;

use Countable;
use Iterator;
use IteratorAggregate;
use Psl\Math;

/**
 * @template T
 *
 * @implements IteratorAggregate<int<0, max>, T>
 */
final readonly class Page implements Countable, IteratorAggregate
{
    /**
     * @param iterable<T> $items
     * @param int<0, max> $count
     * @param positive-int $page
     * @param int<0, max> $totalItems
     * @param positive-int $itemsPerPage
     */
    public function __construct(
        public iterable $items,
        public int $count,
        public int $page,
        public int $totalItems,
        public int $itemsPerPage,
    ) {
    }

    public function hasPrevious(): bool
    {
        return $this->page > 1;
    }

    public function getPrevious(): ?int
    {
        if ($this->hasPrevious()) {
            $previous = $this->page - 1;
            $last = (int) Math\ceil($this->totalItems / $this->itemsPerPage);

            return Math\minva($previous, $last);
        }

        return null;
    }

    public function hasNext(): bool
    {
        return $this->page < (int) Math\ceil($this->totalItems / $this->itemsPerPage);
    }

    public function getNext(): ?int
    {
        if ($this->hasNext()) {
            return $this->page + 1;
        }

        return null;
    }

    public function getFirst(): int
    {
        return 1;
    }

    public function getLast(): int
    {
        return (int) Math\ceil($this->totalItems / $this->itemsPerPage);
    }

    public function count(): int
    {
        return $this->count;
    }

    /**
     * @return Iterator<T>
     */
    public function getIterator(): Iterator
    {
        yield from $this->items;
    }
}
