<?php

declare(strict_types=1);

namespace Carthage\Domain\LogManagement\DataTransferObject\Log;

use Carthage\Domain\Shared\Entity\Identity;
use DateTimeImmutable;

final class CreateLogEntry extends CollectLogEntry
{
    /**
     * The unique identifier of the associated log.
     */
    public Identity $logIdentity;

    /**
     * @param Identity $logIdentity - The identity of the associated log
     * @param non-empty-string $source - The source of the entry
     * @param array<string, mixed> $context - The context of the entry
     * @param array<string, mixed> $attributes - The attributes of the entry
     * @param list<non-empty-string> $tags - The tags associated with the entry
     * @param dateTimeImmutable $occurredAt - The timestamp indicating when the entry occurred
     */
    public function __construct(Identity $logIdentity, string $source, array $context, array $attributes, array $tags, DateTimeImmutable $occurredAt)
    {
        parent::__construct($source, $context, $attributes, $tags, $occurredAt);

        $this->logIdentity = $logIdentity;
    }
}
