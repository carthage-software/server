<?php

declare(strict_types=1);

namespace Carthage\Domain\MetricCollection\Event\Histogram;

use Carthage\Domain\Shared\Entity\Identity;

final class HistogramCreatedEvent
{
    public function __construct(
        public Identity $histogramIdentity,
    ) {
    }
}
