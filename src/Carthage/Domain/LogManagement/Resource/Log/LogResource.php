<?php

declare(strict_types=1);

namespace Carthage\Domain\LogManagement\Resource\Log;

use Carthage\Domain\LogManagement\Entity\Log\Log;
use Carthage\Domain\LogManagement\Enum\Log\Level;
use Carthage\Domain\Shared\Entity\Identity;
use Carthage\Domain\Shared\Resource\ItemResourceInterface;
use DateTimeImmutable;
use DateTimeInterface;

final class LogResource implements ItemResourceInterface
{
    private const TYPE = 'log';

    /**
     * @param non-empty-string $namespace - The namespace of the log
     * @param non-empty-string $template - The template for formatting the message
     */
    public function __construct(
        public Identity $identity,
        public string $namespace,
        public Level $level,
        public string $template,
        public ?DateTimeImmutable $firstEntryOccurredAt,
        public ?DateTimeImmutable $lastEntryOccurredAt,
        public DateTimeImmutable $createdAt,
        public DateTimeImmutable $updatedAt,
    ) {
    }

    public static function fromLog(Log $log): self
    {
        return new self(
            $log->getIdentity(),
            $log->namespace,
            $log->level,
            $log->template,
            $log->firstEntryOccurredAt,
            $log->lastEntryOccurredAt,
            $log->createdAt,
            $log->updatedAt,
        );
    }

    /**
     * {@inheritDoc}
     */
    public function getIdentity(): Identity
    {
        return $this->identity;
    }

    /**
     * {@inheritDoc}
     */
    public function getType(): string
    {
        return self::TYPE;
    }

    /**
     * @return array{
     *      "@type": non-empty-string,
     *      "@identity": non-empty-string,
     *      "namespace": non-empty-string,
     *      "level": array{
     *          "name": non-empty-string,
     *          "value": int,
     *      },
     *      "template": non-empty-string,
     *      "first_entry_occurred_at": non-empty-string|null,
     *      "last_entry_occurred_at": non-empty-string|null,
     *      "created_at": non-empty-string,
     *      "updated_at": non-empty-string,
     *  }
     */
    public function jsonSerialize(): array
    {
        return [
            '@type' => $this->getType(),
            '@identity' => $this->identity->value,
            'namespace' => $this->namespace,
            'level' => $this->level->jsonSerialize(),
            'template' => $this->template,
            'first_entry_occurred_at' => $this->firstEntryOccurredAt?->format(DateTimeInterface::RFC3339_EXTENDED),
            'last_entry_occurred_at' => $this->lastEntryOccurredAt?->format(DateTimeInterface::RFC3339_EXTENDED),
            'created_at' => $this->createdAt->format(DateTimeInterface::RFC3339_EXTENDED),
            'updated_at' => $this->updatedAt->format(DateTimeInterface::RFC3339_EXTENDED),
        ];
    }
}
