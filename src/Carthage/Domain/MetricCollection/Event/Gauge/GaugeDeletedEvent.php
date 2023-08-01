<?php

declare(strict_types=1);

namespace Carthage\Domain\MetricCollection\Event\Gauge;

use Symfony\Component\Uid\Ulid;

final class GaugeDeletedEvent
{
    public function __construct(
        public Ulid $gaugeId,
    ) {
    }
}