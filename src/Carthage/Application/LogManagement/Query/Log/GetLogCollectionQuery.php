<?php

declare(strict_types=1);

namespace Carthage\Application\LogManagement\Query\Log;

use Carthage\Application\Shared\Query\QueryInterface;
use Carthage\Domain\LogManagement\Filter\Log\LogFilter;
use Carthage\Domain\LogManagement\Resource\Log\LogResource;
use Carthage\Domain\Shared\Resource\CollectionResourceInterface;

/**
 * @implements QueryInterface<CollectionResourceInterface<LogResource>>
 */
final readonly class GetLogCollectionQuery implements QueryInterface
{
    public function __construct(
        public LogFilter $filter,
    ) {
    }
}
