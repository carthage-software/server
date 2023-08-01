<?php

declare(strict_types=1);

namespace Carthage\Domain\Shared\Resource;

use Carthage\Domain\Shared\Repository\Page;
use Closure;
use Generator;
use Psl\Iter;

/**
 * @template T of ResourceInterface
 *
 * @implements CollectionResourceInterface<T>
 */
final readonly class PaginatedCollectionResource implements CollectionResourceInterface
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

    /**
     * @return iterable<T>
     */
    public function getItems(): iterable
    {
        return $this->items;
    }

    /**
     * @return array{
     *     "@type": non-empty-string,
     *     "@page": int,
     *     "@items_per_page": int,
     *     "@total_items": int,
     *     "@first": int,
     *     "@last": int,
     *     "@next": int|null,
     *     "@previous": int|null,
     *     "items": iterable<T>,
     * }
     */
    public function jsonSerialize(): array
    {
        return [
            '@type' => self::TYPE,
            '@page' => $this->page,
            '@items_per_page' => $this->itemsPerPage,
            '@total_items' => $this->totalItems,
            '@first' => $this->first,
            '@last' => $this->last,
            '@next' => $this->next,
            '@previous' => $this->previous,
            'items' => $this->items,
        ];
    }
}
