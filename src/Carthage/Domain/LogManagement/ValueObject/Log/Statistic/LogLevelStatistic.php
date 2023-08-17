<?php

declare(strict_types=1);

namespace Carthage\Domain\LogManagement\ValueObject\Log\Statistic;

use Carthage\Domain\LogManagement\Enum\Log\Level;

final readonly class LogLevelStatistic
{
    /**
     * @param positive-int $count
     */
    public function __construct(
        public Level $level,
        public int $count,
        public float $percentage,
    ) {
    }
}
