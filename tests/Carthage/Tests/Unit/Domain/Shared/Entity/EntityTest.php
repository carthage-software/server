<?php

declare(strict_types=1);

namespace Carthage\Tests\Unit\Domain\Shared\Entity;

use Carthage\Domain\Shared\Entity\Entity;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Ulid;

final class EntityTest extends TestCase
{
    public function testGetIdentityUninitialized(): void
    {
        $entity = new class() extends Entity {
        };

        $this->expectExceptionMessage('Attempted to get the identity of an entity that has not been persisted.');
        $entity->getIdentity();
    }

    public function testGetIdentity(): void
    {
        $entity = new class() extends Entity {};

        $id = Ulid::fromString('00000000000000000000000000');

        $entity->id = $id;

        self::assertSame($id, $entity->getIdentity());
    }
}
