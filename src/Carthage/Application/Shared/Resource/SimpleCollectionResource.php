<?php

declare(strict_types=1);

namespace Carthage\Application\Shared\Resource;

use Closure;
use Generator;
use Psl\Iter;

/**
 * @template T of ResourceInterface
 *
 * @implements CollectionResourceInterface<T>
 */
final readonly class SimpleCollectionResource implements CollectionResourceInterface
{
    private const TYPE = 'simple_collection';

    /**
     * @param iterable<T> $items
     */
    private function __construct(
        public iterable $items,
    ) {
    }

    /**
     * @template TFrom
     * @template TInto of ResourceInterface
     *
     * @param iterable<TFrom> $items
     * @param (Closure(TFrom): TInto) $mapper
     *
     * @return static<TInto>
     */
    public static function fromItems(iterable $items, Closure $mapper): CollectionResourceInterface
    {
        return new self(Iter\Iterator::from(
            /**
             * @return Generator<int, TInto, mixed, void>
             */
            static function () use ($items, $mapper): Generator {
                foreach ($items as $item) {
                    yield $mapper($item);
                }
            },
        ));
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
}
