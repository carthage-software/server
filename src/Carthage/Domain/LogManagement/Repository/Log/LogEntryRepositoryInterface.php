<?php

declare(strict_types=1);

namespace Carthage\Domain\LogManagement\Repository\Log;

use Carthage\Domain\LogManagement\Entity\Log\LogEntry;
use Carthage\Domain\Shared\Repository\EntityRepositoryInterface;

/**
 * @extends EntityRepositoryInterface<LogEntry>
 */
interface LogEntryRepositoryInterface extends EntityRepositoryInterface
{
}
