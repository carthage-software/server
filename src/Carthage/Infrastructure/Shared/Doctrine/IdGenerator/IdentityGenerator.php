<?php

declare(strict_types=1);

namespace Carthage\Infrastructure\Shared\Doctrine\IdGenerator;

use Carthage\Domain\Shared\Entity\Identity;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Id\AbstractIdGenerator;
use RuntimeException;
use Symfony\Component\Uid\Factory\UlidFactory;
use Symfony\Component\Uid\Ulid;

final class IdentityGenerator extends AbstractIdGenerator
{
    private ?UlidFactory $factory;

    public function __construct(?UlidFactory $factory = null)
    {
        $this->factory = $factory;
    }

    public function generateId(EntityManagerInterface $em, $entity): Identity
    {
        if ($this->factory) {
            $ulid = $this->factory->create();
        } else {
            $ulid = new Ulid();
        }

        $ulidValue = $ulid->toRfc4122();
        if ('' === $ulidValue) {
            throw new RuntimeException('Failed to generate a ULID.');
        }

        return new Identity($ulidValue);
    }
}
