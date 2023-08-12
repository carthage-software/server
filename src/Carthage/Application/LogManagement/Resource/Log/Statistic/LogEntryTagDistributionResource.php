<?php

declare(strict_types=1);

namespace Carthage\Application\LogManagement\Resource\Log\Statistic;

use Carthage\Application\Shared\Resource\ResourceInterface;
use Carthage\Domain\LogManagement\ValueObject\Log\Statistic\LogEntryTagDistribution;

final readonly class LogEntryTagDistributionResource implements ResourceInterface
{
    private const TYPE = 'log_entry_tag_distribution';

    /**
     * @param non-empty-string $tag
     * @param positive-int $count
     */
    public function __construct(
        public string $tag,
        public int $count,
    ) {
    }

    public static function fromLogEntryTagDistribution(LogEntryTagDistribution $logEntryTagDistribution): self
    {
        return new self(
            $logEntryTagDistribution->tag,
            $logEntryTagDistribution->count,
        );
    }

    public function getType(): string
    {
        return self::TYPE;
    }
}
