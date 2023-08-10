<?php

declare(strict_types=1);

namespace Carthage\Domain\LogManagement\ValueObject\Log\Statistic;

final class LogEntryTagDistribution
{
    /**
     * @param non-empty-string $tag
     * @param positive-int $count
     */
    public function __construct(
        public string $tag,
        public int $count,
    ) {
    }
}
