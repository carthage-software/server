<?php

declare(strict_types=1);

namespace Carthage\Domain\MetricCollection\Event\Gauge;

use Carthage\Domain\Shared\Entity\Identity;

final class GaugeDeletedEvent
{
    public function __construct(
        public Identity $gaugeIdentity,
    ) {
    }
}
