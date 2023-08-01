<?php

declare(strict_types=1);

namespace Carthage\Domain\MetricCollection\Repository\Histogram;

use Carthage\Domain\MetricCollection\Entity\Histogram\Histogram;
use Carthage\Domain\Shared\Repository\EntityRepositoryInterface;

/**
 * @extends EntityRepositoryInterface<Histogram>
 */
interface HistogramRepositoryInterface extends EntityRepositoryInterface
{
    public function findOneWithNameInNamespace(string $name, string $namespace): ?Histogram;
}
