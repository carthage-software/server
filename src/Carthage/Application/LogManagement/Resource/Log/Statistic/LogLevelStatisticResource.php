<?php

declare(strict_types=1);

namespace Carthage\Application\LogManagement\Resource\Log\Statistic;

use Carthage\Application\Shared\Resource\ResourceInterface;
use Carthage\Domain\LogManagement\Enum\Log\Level;
use Carthage\Domain\LogManagement\ValueObject\Log\Statistic\LogLevelStatistic;

final readonly class LogLevelStatisticResource implements ResourceInterface
{
    private const TYPE = 'log_level_statistic';

    /**
     * @param positive-int $count
     */
    public function __construct(
        public Level $level,
        public int $count,
        public float $percentage,
    ) {
    }

    public static function fromLogLevelStatistics(LogLevelStatistic $logLevelStatistics): self
    {
        return new self(
            $logLevelStatistics->level,
            $logLevelStatistics->count,
            $logLevelStatistics->percentage,
        );
    }

    public function getType(): string
    {
        return self::TYPE;
    }
}
