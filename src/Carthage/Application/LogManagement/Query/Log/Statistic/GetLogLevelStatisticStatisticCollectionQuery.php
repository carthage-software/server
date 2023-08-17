<?php

declare(strict_types=1);

namespace Carthage\Application\LogManagement\Query\Log\Statistic;

use Carthage\Application\LogManagement\Resource\Log\Statistic\LogLevelStatisticResource;
use Carthage\Application\LogManagement\Resource\Log\Statistic\StatisticCollectionResource;
use Carthage\Application\Shared\Query\QueryInterface;
use DateTimeImmutable;

/**
 * @implements QueryInterface<StatisticCollectionResource<LogLevelStatisticResource>>
 */
final readonly class GetLogLevelStatisticStatisticCollectionQuery implements QueryInterface
{
    public function __construct(
        public ?DateTimeImmutable $from = null,
        public ?DateTimeImmutable $to = null,
    ) {
    }
}
