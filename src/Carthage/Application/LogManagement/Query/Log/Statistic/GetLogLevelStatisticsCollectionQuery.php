<?php

declare(strict_types=1);

namespace Carthage\Application\LogManagement\Query\Log\Statistic;

use Carthage\Application\Shared\Query\QueryInterface;
use Carthage\Domain\LogManagement\Resource\Log\Statistic\LogLevelStatisticsResource;
use Carthage\Domain\Shared\Resource\CollectionResourceInterface;

/**
 * @implements QueryInterface<CollectionResourceInterface<LogLevelStatisticsResource>>
 */
final readonly class GetLogLevelStatisticsCollectionQuery implements QueryInterface
{
}
