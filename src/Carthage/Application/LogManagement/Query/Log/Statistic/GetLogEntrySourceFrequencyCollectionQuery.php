<?php

declare(strict_types=1);

namespace Carthage\Application\LogManagement\Query\Log\Statistic;

use Carthage\Application\LogManagement\Resource\Log\Statistic\LogEntrySourceFrequencyResource;
use Carthage\Application\Shared\Query\QueryInterface;
use Carthage\Application\Shared\Resource\CollectionResource;

/**
 * @implements QueryInterface<CollectionResource<LogEntrySourceFrequencyResource>>
 */
final readonly class GetLogEntrySourceFrequencyCollectionQuery implements QueryInterface
{
}
