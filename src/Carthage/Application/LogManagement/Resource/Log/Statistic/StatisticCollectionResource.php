<?php

declare(strict_types=1);

namespace Carthage\Application\LogManagement\Resource\Log\Statistic;

use Carthage\Application\Shared\Resource\ResourceInterface;
use Closure;
use DateTimeImmutable;
use Generator;
use Psl\Iter;

/**
 * @template T of ResourceInterface
 */
final class StatisticCollectionResource implements ResourceInterface
{
    private const TYPE = 'statistic_collection';

    /**
     * @param iterable<T> $items
     */
    private function __construct(
        public DateTimeImmutable $from,
        public DateTimeImmutable $to,
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
     * @return self<TInto>
     */
    public static function fromItems(iterable $items, DateTimeImmutable $from, DateTimeImmutable $to, Closure $mapper): self
    {
        return new self($from, $to, Iter\Iterator::from(
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
}
