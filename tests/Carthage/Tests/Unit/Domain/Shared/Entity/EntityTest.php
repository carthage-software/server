<?php

declare(strict_types=1);

namespace Carthage\Tests\Unit\Domain\Shared\Entity;

use Carthage\Domain\Shared\Entity\Entity;
use Carthage\Domain\Shared\Entity\Identity;
use PHPUnit\Framework\TestCase;

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

        $id = new Identity('foo');

        $entity->id = $id;

        self::assertSame($id, $entity->getIdentity());
        self::assertSame($id, $entity->id);
    }
}
