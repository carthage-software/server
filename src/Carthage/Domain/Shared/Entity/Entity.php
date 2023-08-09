<?php

declare(strict_types=1);

namespace Carthage\Domain\Shared\Entity;

use DateTimeImmutable;
use Psl;

abstract class Entity
{
    public ?Identity $id = null;

    public DateTimeImmutable $createdAt;
    public DateTimeImmutable $updatedAt;

    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
    }

    /**
     * @throws Psl\Exception\InvariantViolationException if the identity is not set
     */
    public function getIdentity(): Identity
    {
        Psl\invariant(null !== $this->id, 'Attempted to get the identity of an entity that has not been persisted.');

        return $this->id;
    }
}
