<?php

declare(strict_types=1);

namespace Carthage\Domain\LogManagement\Entity\Log;

use Carthage\Domain\LogManagement\Enum\Log\Level;
use Carthage\Domain\Shared\Entity\Entity;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * The Log class represents a structured log message.
 *
 * It contains information about the log namespace, level, message template, and related log entries.
 */
class Log extends Entity
{
    /**
     * The namespace the log is associated with.
     *
     * @var non-empty-string
     */
    public string $namespace;

    /**
     * The severity level of the log.
     */
    public Level $level;

    /**
     * The template for formatting the message.
     *
     * @var non-empty-string
     */
    public string $template;

    /**
     * The timestamp when the first log entry associated with this log occurred.
     */
    public ?DateTimeImmutable $firstEntryOccurredAt = null;

    /**
     * The timestamp when the last log entry associated with this log occurred.
     */
    public ?DateTimeImmutable $lastEntryOccurredAt = null;

    /**
     * A collection of log entries associated with this log.
     *
     * @var Collection<int, LogEntry>
     */
    public Collection $entries;

    /**
     * Constructor for the Message class.
     *
     * It initializes a new message with a namespace, level, and message template.
     *
     * @param non-empty-string $namespace - The message namespace
     * @param level $level - The message severity level
     * @param non-empty-string $template - The message template
     */
    public function __construct(string $namespace, Level $level, string $template)
    {
        parent::__construct();

        $this->namespace = $namespace;
        $this->level = $level;
        $this->template = $template;
        $this->entries = new ArrayCollection();
    }

    /**
     * Adds a new log entry to the log.
     *
     * @param non-empty-string $source - The source of the log entry
     * @param array<string, mixed> $context - The context of the log entry
     * @param array<string, mixed> $attributes - The attributes of the log entry
     * @param list<non-empty-string> $tags - The tags of the log entry
     */
    public function addLogEntry(string $source, array $context, array $attributes, array $tags, DateTimeImmutable $occurredAt): LogEntry
    {
        $entry = new LogEntry($this, $source, $context, $attributes, $tags, $occurredAt);

        $this->entries->add($entry);

        // Update the first entry occurred at timestamp if it is null or the new entry occurred before the current value.
        if (null === $this->firstEntryOccurredAt) {
            $this->firstEntryOccurredAt = $occurredAt;
        } elseif ($occurredAt < $this->firstEntryOccurredAt) {
            $this->firstEntryOccurredAt = $occurredAt;
        }

        // Update the last entry occurred at timestamp if it is null or the new entry occurred after the current value.
        if (null === $this->lastEntryOccurredAt) {
            $this->lastEntryOccurredAt = $occurredAt;
        } elseif ($occurredAt > $this->lastEntryOccurredAt) {
            $this->lastEntryOccurredAt = $occurredAt;
        }

        return $entry;
    }
}
