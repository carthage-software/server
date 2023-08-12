<?php

declare(strict_types=1);

namespace Carthage\Application\LogManagement\Resource\Log\Statistic;

use Carthage\Application\Shared\Resource\ResourceInterface;
use Carthage\Domain\LogManagement\ValueObject\Log\Statistic\LogFrequencyCount;
use DateTimeImmutable;

final readonly class LogFrequencyCountResource implements ResourceInterface
{
    private const TYPE = 'log_frequency_count';

    /**
     * @param positive-int $count
     */
    public function __construct(
        public DateTimeImmutable $date,
        public int $count,
    ) {
    }

    public static function fromLogFrequencyCount(LogFrequencyCount $logFrequencyCount): self
    {
        return new self(
            $logFrequencyCount->date,
            $logFrequencyCount->count,
        );
    }

    public function getType(): string
    {
        return self::TYPE;
    }
}
