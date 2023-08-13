<?php

declare(strict_types=1);

namespace Carthage\Application\LogManagement\Query\Log\Statistic;

use Carthage\Application\LogManagement\Resource\Log\Statistic\LogEntryTagDistributionResource;
use Carthage\Application\Shared\Query\QueryInterface;
use Carthage\Application\Shared\Resource\CollectionResource;

/**
 * @implements QueryInterface<CollectionResource<LogEntryTagDistributionResource>>
 */
final readonly class GetLogEntryTagDistributionCollectionQuery implements QueryInterface
{
}
