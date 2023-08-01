<?php

declare(strict_types=1);

namespace Carthage\Infrastructure\LogManagement\Doctrine\Repository\Log;

use Carthage\Domain\LogManagement\Entity\Log\LogEntry;
use Carthage\Domain\LogManagement\Repository\Log\LogEntryRepositoryInterface;
use Carthage\Infrastructure\Shared\Doctrine\Repository\EntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\DependencyInjection\Attribute\AsAlias;

/**
 * @extends EntityRepository<LogEntry>
 */
#[AsAlias(LogEntryRepositoryInterface::class)]
final class LogEntryRepository extends EntityRepository implements LogEntryRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LogEntry::class);
    }
}
