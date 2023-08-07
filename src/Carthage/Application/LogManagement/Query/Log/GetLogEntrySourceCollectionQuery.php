<?php

declare(strict_types=1);

namespace Carthage\Application\LogManagement\Query\Log;

use Carthage\Application\Shared\Query\QueryInterface;
use Carthage\Domain\LogManagement\Resource\Log\LogEntrySourceResource;
use Carthage\Domain\Shared\Resource\CollectionResourceInterface;

/**
 * @implements QueryInterface<CollectionResourceInterface<LogEntrySourceResource>>
 */
final class GetLogEntrySourceCollectionQuery implements QueryInterface
{
}
