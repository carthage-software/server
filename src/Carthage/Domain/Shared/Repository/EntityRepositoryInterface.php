<?php

declare(strict_types=1);

namespace Carthage\Domain\Shared\Repository;

use Carthage\Domain\Shared\Criteria\Criteria;
use Carthage\Domain\Shared\Entity\Entity;
use Carthage\Domain\Shared\Entity\Identity;
use Carthage\Domain\Shared\Filter\FilterInterface;

/**
 * @template T of Entity
 */
interface EntityRepositoryInterface
{
    /**
     * @return T|null
     */
    public function findOne(Identity $identity): ?Entity;

    /**
     * @return T|null
     */
    public function findOneMatching(Criteria $criteria): ?Entity;

    /**
     * Paginate the entity using the provided criteria.
     *
     * @return Page<T>
     */
    public function paginate(FilterInterface $filter): Page;

    /**
     * @param T $entity
     */
    public function persist(Entity $entity, bool $flush = true): void;

    /**
     * @param T $entity
     */
    public function remove(Entity $entity, bool $flush = true): void;
}
