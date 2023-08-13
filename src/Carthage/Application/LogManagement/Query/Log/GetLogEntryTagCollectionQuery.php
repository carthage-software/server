<?php

declare(strict_types=1);

namespace Carthage\Application\LogManagement\Query\Log;

use Carthage\Application\LogManagement\Resource\Log\LogEntryTagResource;
use Carthage\Application\Shared\Query\QueryInterface;
use Carthage\Application\Shared\Resource\CollectionResource;

/**
 * @implements QueryInterface<CollectionResource<LogEntryTagResource>>
 */
final class GetLogEntryTagCollectionQuery implements QueryInterface
{
}
