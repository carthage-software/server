<?php

declare(strict_types=1);

namespace Carthage\Application\LogManagement\Resource\Log;

use Carthage\Application\Shared\Resource\ResourceInterface;
use Carthage\Domain\LogManagement\Entity\Log\Log;
use Carthage\Domain\LogManagement\Enum\Log\Level;
use Carthage\Domain\Shared\Entity\Identity;
use DateTimeImmutable;

final class LogResource implements ResourceInterface
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
    public function getType(): string
    {
        return self::TYPE;
    }
}
