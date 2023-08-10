<?php

declare(strict_types=1);

namespace Carthage\Domain\LogManagement\ValueObject\Log\Statistic;

use DateTimeImmutable;

final readonly class LogEntryFrequencyCount
{
    /**
     * @param positive-int $count
     */
    public function __construct(
        public DateTimeImmutable $date,
        public int $count,
    ) {
    }
}
