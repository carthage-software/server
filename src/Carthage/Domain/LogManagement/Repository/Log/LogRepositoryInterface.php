<?php

declare(strict_types=1);

namespace Carthage\Domain\LogManagement\Repository\Log;

use Carthage\Domain\LogManagement\Entity\Log\Log;
use Carthage\Domain\LogManagement\Enum\Log\Level;
use Carthage\Domain\Shared\Repository\EntityRepositoryInterface;

/**
 * @extends EntityRepositoryInterface<Log>
 */
interface LogRepositoryInterface extends EntityRepositoryInterface
{
    /**
     * @return list<non-empty-string>
     */
    public function findAllNamespaces(): array;

    public function findByLevelAndTemplateInNamespace(Level $level, string $template, string $namespace): ?Log;
}
