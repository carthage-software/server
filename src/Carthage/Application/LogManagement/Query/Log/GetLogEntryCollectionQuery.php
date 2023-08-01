<?php

declare(strict_types=1);

namespace Carthage\Application\LogManagement\Query\Log;

use Carthage\Application\Shared\Query\QueryInterface;
use Carthage\Domain\LogManagement\Filter\Log\LogEntryFilter;
use Carthage\Domain\LogManagement\Resource\Log\LogEntryResource;
use Carthage\Domain\Shared\Resource\CollectionResourceInterface;

/**
 * @implements QueryInterface<CollectionResourceInterface<LogEntryResource>>
 */
final readonly class GetLogEntryCollectionQuery implements QueryInterface
{
    public function __construct(
        public LogEntryFilter $logEntryFilter,
    ) {
    }
}
