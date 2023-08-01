<?php

declare(strict_types=1);

namespace Carthage\Domain\LogManagement\Entity\Log;

use Carthage\Domain\Shared\Entity\Entity;
use DateTimeImmutable;

/**
 * The Record class represents an entry in the log.
 *
 * It holds the details of a specific event recorded in the system.
 */
class LogEntry extends Entity
{
    /**
     * The log object associated with the record.
     *
     * This holds the detailed log of the entry.
     */
    public Log $log;

    /**
     * The source of the entry, usually the host (machine) where the entry was created.
     *
     * @var non-empty-string
     */
    public string $source;

    /**
     * The context of the entry.
     *
     * This includes additional data relevant to the entry and is used to format the log message.
     *
     * @var array<string, mixed>
     */
    public array $context;

    /**
     * The attributes associated with the entry.
     *
     * This is used to provide additional information about the entry that is not part of the main message.
     *
     * @var array<string, mixed>
     */
    public array $attributes;

    /**
     * The tags associated with the entry.
     *
     * These can be used to categorize the entry and can be useful for filtering and searching entries.
     *
     * @var list<non-empty-string>
     */
    public array $tags;

    /**
     * The date and time when the entry occurred.
     */
    public DateTimeImmutable $occurredAt;

    /**
     * Constructor for the LogEntry class.
     *
     * It initializes a new instance of the class with the given parameters.
     *
     * @param Log $log - The log object associated with the entry
     * @param non-empty-string $source - The source of the entry
     * @param array<string, mixed> $context - The context of the entry
     * @param array<string, mixed> $attributes - The attributes of the entry
     * @param list<non-empty-string> $tags - The tags associated with the entry
     * @param DateTimeImmutable $occurredAt - The timestamp of the entry's creation
     */
    public function __construct(Log $log, string $source, array $context, array $attributes, array $tags, DateTimeImmutable $occurredAt)
    {
        parent::__construct();

        $this->source = $source;
        $this->log = $log;
        $this->context = $context;
        $this->attributes = $attributes;
        $this->tags = $tags;
        $this->occurredAt = $occurredAt;
    }
}
