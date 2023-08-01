<?php

declare(strict_types=1);

namespace Carthage\Domain\LogManagement\Resource\Log;

use Carthage\Domain\LogManagement\Entity\Log\LogEntry;
use Carthage\Domain\Shared\Resource\ItemResourceInterface;
use DateTimeImmutable;
use DateTimeInterface;
use Symfony\Component\Uid\Ulid;

final class LogEntryResource implements ItemResourceInterface
{
    private const TYPE = 'log_entry';

    /**
     * @param non-empty-string $source
     * @param array<string, mixed> $context
     * @param array<string, mixed> $attributes
     * @param list<non-empty-string> $tags
     */
    public function __construct(
        public Ulid $id,
        public Ulid $log,
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
    public function getIdentity(): Ulid
    {
        return $this->id;
    }

    /**
     * {@inheritDoc}
     */
    public function getType(): string
    {
        return self::TYPE;
    }

    /**
     * Serializes the resource to a JSON representation.
     *
     * @return array{
     *      "@type": non-empty-string,
     *      "@id": string,
     *      "log": string,
     *      "source": non-empty-string,
     *      "context": array<string, mixed>,
     *      "attributes": array<string, mixed>,
     *      "tags": list<string>,
     *      "occurred_at": non-empty-string,
     *      "created_at": non-empty-string,
     *      "updated_at": non-empty-string,
     *  }
     */
    public function jsonSerialize(): array
    {
        return [
            '@type' => $this->getType(),
            '@id' => $this->id->toBase32(),
            'log' => $this->log->toBase32(),
            'source' => $this->source,
            'context' => $this->context,
            'attributes' => $this->attributes,
            'tags' => $this->tags,
            'occurred_at' => $this->occurredAt->format(DateTimeInterface::RFC3339_EXTENDED),
            'created_at' => $this->createdAt->format(DateTimeInterface::RFC3339_EXTENDED),
            'updated_at' => $this->updatedAt->format(DateTimeInterface::RFC3339_EXTENDED),
        ];
    }
}