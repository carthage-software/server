<?php

declare(strict_types=1);

namespace Carthage\Application\LogManagement\Query\Log;

use Carthage\Application\LogManagement\Resource\Log\LogResource;
use Carthage\Application\Shared\Query\QueryInterface;
use Carthage\Application\Shared\Resource\CollectionResourceInterface;
use Carthage\Domain\LogManagement\Filter\Log\LogFilter;

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
