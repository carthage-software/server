<?php

declare(strict_types=1);

namespace Carthage\Application\LogManagement\Resource\Log;

use Carthage\Application\Shared\Resource\ResourceInterface;
use Carthage\Domain\LogManagement\Entity\Log\LogEntry;
use Carthage\Domain\Shared\Entity\Identity;
use DateTimeImmutable;

final class LogEntryResource implements ResourceInterface
{
    private const TYPE = 'log_entry';

    /**
     * @param non-empty-string $source
     * @param array<string, mixed> $context
     * @param array<string, mixed> $attributes
     * @param list<non-empty-string> $tags
     */
    public function __construct(
        public Identity $identity,
        public Identity $logIdentity,
        public string $source,
        public array $context,
        public array $attributes,
        public array $tags,
        public DateTimeImmutable $occurredAt,
        public DateTimeImmutable $createdAt,
        public DateTimeImmutable $updatedAt,
    ) {
    }

    public static function fromLogEntry(LogEntry $logEntry): self
    {
        return new self(
            $logEntry->getIdentity(),
            $logEntry->log->getIdentity(),
            $logEntry->source,
            $logEntry->context,
            $logEntry->attributes,
            $logEntry->tags,
            $logEntry->occurredAt,
            $logEntry->createdAt,
            $logEntry->updatedAt,
        );
    }

    /**
     * {@inheritDoc}
     */
    public function getType(): string
    {
        return self::TYPE;
    }
}
