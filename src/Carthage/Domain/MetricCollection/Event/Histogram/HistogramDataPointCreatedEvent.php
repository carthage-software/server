<?php

declare(strict_types=1);

namespace Carthage\Domain\MetricCollection\Event\Histogram;

use Carthage\Domain\Shared\Entity\Identity;

final class HistogramDataPointCreatedEvent
{
    public function __construct(
        public Identity $histogramDataPointIdentity,
    ) {
    }
}
