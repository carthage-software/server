<?php

declare(strict_types=1);

namespace Carthage\Infrastructure\Shared\Doctrine\EventListener;

use Carthage\Domain\Shared\Entity\Entity;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;
use Psr\Clock\ClockInterface;

#[AsDoctrineListener(Events::preUpdate)]
final readonly class EntityUpdateListener
{
    public function __construct(
        private ClockInterface $clock,
    ) {
    }

    public function preUpdate(PreUpdateEventArgs $eventArgs): void
    {
        $object = $eventArgs->getObject();
        if (!$object instanceof Entity) {
            return;
        }

        $datetime = $this->clock->now();

        $object->updatedAt = $datetime;
    }
}
