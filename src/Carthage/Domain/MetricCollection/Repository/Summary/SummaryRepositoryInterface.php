<?php

declare(strict_types=1);

namespace Carthage\Domain\MetricCollection\Repository\Summary;

use Carthage\Domain\MetricCollection\Entity\Summary\Summary;
use Carthage\Domain\Shared\Repository\EntityRepositoryInterface;

/**
 * @extends EntityRepositoryInterface<Summary>
 */
interface SummaryRepositoryInterface extends EntityRepositoryInterface
{
    public function findOneWithNameInNamespace(string $name, string $namespace): ?Summary;
}
