<?php

declare(strict_types=1);

namespace Carthage\Domain\LogManagement\Resource\Log\Statistic;

use Carthage\Domain\LogManagement\ValueObject\Log\Statistic\LogEntryTagDistribution;
use Carthage\Domain\Shared\Resource\ResourceInterface;

final readonly class LogEntryTagDistributionResource implements ResourceInterface
{
    private const TYPE = 'log_entry_tag_distribution';

    /**
     * @param non-empty-string $tag
     * @param positive-int $count
     */
    public function __construct(
        private string $tag,
        private int $count,
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

    /**
     * @return array{
     *      "@type": non-empty-string,
     *      "tag": non-empty-string,
     *      "count": positive-int,
     *  }
     */
    public function jsonSerialize(): array
    {
        return [
            '@type' => $this->getType(),
            'tag' => $this->tag,
            'count' => $this->count,
        ];
    }
}
