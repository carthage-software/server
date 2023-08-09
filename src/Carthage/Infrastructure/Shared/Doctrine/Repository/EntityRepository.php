<?php

declare(strict_types=1);

namespace Carthage\Infrastructure\Shared\Doctrine\Repository;

use Carthage\Domain\Shared\Criteria\Criteria;
use Carthage\Domain\Shared\Entity\Entity;
use Carthage\Domain\Shared\Entity\Identity;
use Carthage\Domain\Shared\Filter\FilterInterface;
use Carthage\Domain\Shared\Repository\EntityRepositoryInterface;
use Carthage\Domain\Shared\Repository\Page;
use Carthage\Infrastructure\Shared\Doctrine\Criteria\DoctrineCriteriaTransformer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\Query\QueryException;

use function count;

/**
 * @template T of Entity
 *
 * @template-extends ServiceEntityRepository<T>
 */
abstract class EntityRepository extends ServiceEntityRepository implements EntityRepositoryInterface
{
    /**
     * @return T|null
     */
    public function findOne(Identity $identity): ?Entity
    {
        return $this->findOneBy([
            'id' => $identity->value,
        ]);
    }

    /**
     * @throws NonUniqueResultException
     * @throws QueryException
     *
     * @return T|null
     */
    public function findOneMatching(Criteria $criteria): ?Entity
    {
        return $this->createQueryBuilder('entity')
            ->addCriteria(DoctrineCriteriaTransformer::transform($criteria))
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * {@inheritDoc}
     *
     * @throws NoResultException
     * @throws NonUniqueResultException
     * @throws QueryException
     *
     * @return Page<T>
     */
    public function paginate(FilterInterface $filter): Page
    {
        $criteria = DoctrineCriteriaTransformer::transform($filter->getCriteria());
        // for count query, we need to remove the order by clause and the limit clause.
        $count_criteria = (clone $criteria)->orderBy([]);

        /**
         * @var int $total_items_count
         */
        $total_items_count = $this->createQueryBuilder('c')
            ->select('COUNT(c)')
            ->addCriteria($count_criteria)
            ->getQuery()
            ->getSingleScalarResult();

        /** @var list<T> $items */
        $items = $this->createQueryBuilder('c')
            ->addCriteria($criteria)
            ->addOrderBy('c.id', 'DESC')
            ->setFirstResult(($filter->getPage() - 1) * $filter->getItemsPerPage())
            ->setMaxResults($filter->getItemsPerPage())
            ->getQuery()
            ->getResult();

        return new Page($items, count($items), $filter->getPage(), $total_items_count, $filter->getItemsPerPage());
    }

    public function persist(Entity $entity, bool $flush = true): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Entity $entity, bool $flush = true): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
