<?php

declare(strict_types=1);

namespace Carthage\Application\Shared;

use Carthage\Application\Shared\Query\QueryInterface;

interface QueryBusInterface
{
    /**
     * @template T
     *
     * @param QueryInterface<T> $query
     *
     * @return T
     */
    public function ask(QueryInterface $query): mixed;
}
