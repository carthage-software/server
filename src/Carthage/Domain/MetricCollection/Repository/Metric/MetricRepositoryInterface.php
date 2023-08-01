<?php

declare(strict_types=1);

namespace Carthage\Domain\MetricCollection\Repository\Metric;

use Carthage\Domain\MetricCollection\Entity\Metric\Metric;
use Carthage\Domain\Shared\Repository\EntityRepositoryInterface;

/**
 * @extends EntityRepositoryInterface<Metric>
 */
interface MetricRepositoryInterface extends EntityRepositoryInterface
{
    /**
     * @return list<non-empty-string>
     */
    public function findAllNamespaces(): array;
}
