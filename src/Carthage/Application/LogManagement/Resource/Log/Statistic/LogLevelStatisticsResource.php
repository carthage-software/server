<?php

declare(strict_types=1);

namespace Carthage\Application\LogManagement\Resource\Log\Statistic;

use Carthage\Application\Shared\Resource\ResourceInterface;
use Carthage\Domain\LogManagement\Enum\Log\Level;
use Carthage\Domain\LogManagement\ValueObject\Log\Statistic\LogLevelStatistics;

final readonly class LogLevelStatisticsResource implements ResourceInterface
{
    private const TYPE = 'log_level_statistics';

    /**
     * @param positive-int $count
     */
    public function __construct(
        public Level $level,
        public int $count,
        public float $percentage,
    ) {
    }

    public static function fromLogLevelStatistics(LogLevelStatistics $logLevelStatistics): self
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
