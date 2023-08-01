<?php

declare(strict_types=1);

namespace Carthage\Domain\Shared\Resource;

/**
 * @template T of ResourceInterface
 */
interface CollectionResourceInterface extends ResourceInterface
{
    /**
     * Gets the items of the collection.
     *
     * @return iterable<T>
     */
    public function getItems(): iterable;
}
