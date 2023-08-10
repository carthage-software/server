<?php

declare(strict_types=1);

namespace Carthage\Domain\LogManagement\ValueObject\Log\Statistic;

final class LogEntrySourceFrequency
{
    /**
     * @param non-empty-string $source
     * @param positive-int $count
     */
    public function __construct(
        public string $source,
        public int $count,
        public float $percentage,
    ) {
    }
}
