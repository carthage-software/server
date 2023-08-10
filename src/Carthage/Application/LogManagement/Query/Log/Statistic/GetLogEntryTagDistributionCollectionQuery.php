<?php

declare(strict_types=1);

namespace Carthage\Application\LogManagement\Query\Log\Statistic;

use Carthage\Application\Shared\Query\QueryInterface;
use Carthage\Domain\LogManagement\Resource\Log\Statistic\LogEntryTagDistributionResource;
use Carthage\Domain\Shared\Resource\CollectionResourceInterface;

/**
 * @implements QueryInterface<CollectionResourceInterface<LogEntryTagDistributionResource>>
 */
final readonly class GetLogEntryTagDistributionCollectionQuery implements QueryInterface
{
}
