<?php

declare(strict_types=1);

namespace Carthage\Domain\LogManagement\Resource\Log\Statistic;

use Carthage\Domain\LogManagement\ValueObject\Log\Statistic\LogFrequencyCount;
use Carthage\Domain\Shared\Resource\ResourceInterface;
use DateTimeImmutable;
use DateTimeInterface;

final readonly class LogFrequencyCountResource implements ResourceInterface
{
    private const TYPE = 'log_frequency_count';

    /**
     * @param positive-int $count
     */
    public function __construct(
        private DateTimeImmutable $date,
        private int $count,
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

    /**
     * @return array{
     *      "@type": non-empty-string,
     *      "date": non-empty-string,
     *      "count": positive-int,
     *  }
     */
    public function jsonSerialize(): array
    {
        return [
            '@type' => $this->getType(),
            'date' => $this->date->format(DateTimeInterface::RFC3339_EXTENDED),
            'count' => $this->count,
        ];
    }
}
