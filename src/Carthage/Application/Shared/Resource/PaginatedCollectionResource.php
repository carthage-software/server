<?php

declare(strict_types=1);

namespace Carthage\Application\Shared\Resource;

use Carthage\Domain\Shared\Repository\Page;
use Closure;
use Generator;
use Psl\Iter;

/**
 * @template T of ResourceInterface
 */
final readonly class PaginatedCollectionResource implements ResourceInterface
{
    private const TYPE = 'paginated_collection';

    /**
     * @param iterable<T> $items
     */
    private function __construct(
        public iterable $items,
        public int $page,
        public int $itemsPerPage,
        public int $totalItems,
        public int $first,
        public int $last,
        public ?int $next,
        public ?int $previous,
    ) {
    }

    /**
     * @template TFrom
     * @template TInto of ResourceInterface
     *
     * @param Page<TFrom> $page
     * @param (Closure(TFrom): TInto) $mapper
     *
     * @return self<TInto>
     */
    public static function fromPage(Page $page, Closure $mapper): self
    {
        $resources = Iter\Iterator::from(
            /**
             * @return Generator<int, TInto, mixed, void>
             */
            static function () use ($page, $mapper): Generator {
                foreach ($page->items as $item) {
                    yield $mapper($item);
                }
            },
        );

        return new self($resources, $page->page, $page->itemsPerPage, $page->totalItems, $page->getFirst(), $page->getLast(), $page->getNext(), $page->getPrevious());
    }

    /**
     * @return non-empty-string
     */
    public function getType(): string
    {
        return self::TYPE;
    }
}
