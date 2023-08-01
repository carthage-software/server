<?php

declare(strict_types=1);

namespace Carthage\Domain\MetricCollection\Repository\Gauge;

use Carthage\Domain\MetricCollection\Entity\Gauge\Gauge;
use Carthage\Domain\Shared\Repository\EntityRepositoryInterface;

/**
 * @extends EntityRepositoryInterface<Gauge>
 */
interface GaugeRepositoryInterface extends EntityRepositoryInterface
{
    public function findOneWithNameInNamespace(string $name, string $namespace): ?Gauge;
}
