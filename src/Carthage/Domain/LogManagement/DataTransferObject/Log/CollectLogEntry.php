<?php

declare(strict_types=1);

namespace Carthage\Domain\LogManagement\DataTransferObject\Log;

use Carthage\Domain\LogManagement\Entity\Log\Log;
use DateTimeImmutable;

class CollectLogEntry
{
    /**
     * The source of the entry, indicating what part of the system the entry is from.
     *
     * @var non-empty-string
     */
    public string $source;

    /**
     * The context of the entry, providing additional information to help understand the entry.
     *
     * @var array<string, mixed>
     */
    public array $context;

    /**
     * The attributes of the entry, providing additional information not included in the main message.
     *
     * @var array<string, mixed>
     */
    public array $attributes;

    /**
     * The tags associated with the entry, useful for categorizing and filtering entries.
     *
     * @var list<non-empty-string>
     */
    public array $tags;

    /**
     * The timestamp indicating when the entry occurred.
     */
    public DateTimeImmutable $occurredAt;

    /**
     * @param non-empty-string $source - The source of the entry
     * @param array<string, mixed> $context - The context of the entry
     * @param array<string, mixed> $attributes - The attributes of the entry
     * @param list<non-empty-string> $tags - The tags associated with the entry
     * @param dateTimeImmutable $occurredAt - The timestamp indicating when the entry occurred
     */
    public function __construct(string $source, array $context, array $attributes, array $tags, DateTimeImmutable $occurredAt)
    {
        $this->source = $source;
        $this->context = $context;
        $this->attributes = $attributes;
        $this->tags = $tags;
        $this->occurredAt = $occurredAt;
    }

    public function toCreateLogEntry(Log $log): CreateLogEntry
    {
        return new CreateLogEntry(
            $log->getIdentity(),
            $this->source,
            $this->context,
            $this->attributes,
            $this->tags,
            $this->occurredAt
        );
    }
}
