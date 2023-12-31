<?php

declare(strict_types=1);

namespace Carthage\Application\LogManagement\Query\Log;

use Carthage\Application\LogManagement\Resource\Log\LogEntryResource;
use Carthage\Application\Shared\Query\QueryInterface;
use Carthage\Application\Shared\Resource\PaginatedCollectionResource;
use Carthage\Domain\LogManagement\Filter\Log\LogEntryFilter;

/**
 * @implements QueryInterface<PaginatedCollectionResource<LogEntryResource>>
 */
final readonly class GetLogEntryCollectionQuery implements QueryInterface
{
    public function __construct(
        public LogEntryFilter $logEntryFilter,
    ) {
    }
}
