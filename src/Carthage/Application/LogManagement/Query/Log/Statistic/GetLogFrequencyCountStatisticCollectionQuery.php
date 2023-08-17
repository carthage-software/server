<?php

declare(strict_types=1);

namespace Carthage\Application\LogManagement\Query\Log\Statistic;

use Carthage\Application\LogManagement\Resource\Log\Statistic\LogFrequencyCountResource;
use Carthage\Application\LogManagement\Resource\Log\Statistic\StatisticCollectionResource;
use Carthage\Application\Shared\Query\QueryInterface;
use Carthage\Domain\LogManagement\Enum\Log\Statistics\Frequency;
use DateTimeImmutable;

/**
 * @implements QueryInterface<StatisticCollectionResource<LogFrequencyCountResource>>
 */
final readonly class GetLogFrequencyCountStatisticCollectionQuery implements QueryInterface
{
    public function __construct(
        public Frequency $frequency,
        public ?DateTimeImmutable $from = null,
        public ?DateTimeImmutable $to = null,
    ) {
    }
}
