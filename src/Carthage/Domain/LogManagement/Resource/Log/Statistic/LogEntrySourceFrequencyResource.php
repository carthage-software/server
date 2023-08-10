<?php

declare(strict_types=1);

namespace Carthage\Domain\LogManagement\Resource\Log\Statistic;

use Carthage\Domain\LogManagement\ValueObject\Log\Statistic\LogEntrySourceFrequency;
use Carthage\Domain\Shared\Resource\ResourceInterface;

final readonly class LogEntrySourceFrequencyResource implements ResourceInterface
{
    private const TYPE = 'log_entry_source_frequency';

    /**
     * @param non-empty-string $source
     * @param positive-int $count
     */
    public function __construct(
        private string $source,
        private int $count,
        private float $percentage,
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

    /**
     * @return array{
     *      "@type": non-empty-string,
     *      "source": non-empty-string,
     *      "count": positive-int,
     *      "percentage": float,
     *  }
     */
    public function jsonSerialize(): array
    {
        return [
            '@type' => $this->getType(),
            'source' => $this->source,
            'count' => $this->count,
            'percentage' => $this->percentage,
        ];
    }
}
