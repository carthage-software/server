<?php

declare(strict_types=1);

namespace Carthage\Application\LogManagement\Resource\Log\Statistic;

use Carthage\Application\Shared\Resource\ResourceInterface;
use Carthage\Domain\LogManagement\ValueObject\Log\Statistic\LogEntrySourceFrequency;

final readonly class LogEntrySourceFrequencyResource implements ResourceInterface
{
    private const TYPE = 'log_entry_source_frequency';

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

    public static function fromLogEntrySourceFrequency(LogEntrySourceFrequency $logEntrySourceFrequency): self
    {
        return new self(
            $logEntrySourceFrequency->source,
            $logEntrySourceFrequency->count,
            $logEntrySourceFrequency->percentage,
        );
    }

    public function getType(): string
    {
        return self::TYPE;
    }
}
