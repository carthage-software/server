<?php

declare(strict_types=1);

namespace Carthage\Application\LogManagement\Query\Log\Statistic;

use Carthage\Application\LogManagement\Resource\Log\Statistic\LogEntryTagDistributionResource;
use Carthage\Application\LogManagement\Resource\Log\Statistic\StatisticCollectionResource;
use Carthage\Application\Shared\Query\QueryInterface;
use DateTimeImmutable;

/**
 * @implements QueryInterface<StatisticCollectionResource<LogEntryTagDistributionResource>>
 */
final readonly class GetLogEntryTagDistributionStatisticCollectionQuery implements QueryInterface
{
    public function __construct(
        public ?DateTimeImmutable $from = null,
        public ?DateTimeImmutable $to = null,
    ) {
    }
}
