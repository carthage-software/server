<?php

declare(strict_types=1);

namespace Carthage\Application\LogManagement\Query\Log\Statistic;

use Carthage\Application\Shared\Query\QueryInterface;
use Carthage\Domain\LogManagement\Resource\Log\Statistic\LogEntrySourceFrequencyResource;
use Carthage\Domain\Shared\Resource\CollectionResourceInterface;

/**
 * @implements QueryInterface<CollectionResourceInterface<LogEntrySourceFrequencyResource>>
 */
final readonly class GetLogEntrySourceFrequencyCollectionQuery implements QueryInterface
{
}
