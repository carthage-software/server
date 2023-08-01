<?php

declare(strict_types=1);

namespace Carthage\Domain\MetricCollection\Event\Histogram;

use Symfony\Component\Uid\Ulid;

final class HistogramCreatedEvent
{
    public function __construct(
        public Ulid $histogramId,
    ) {
    }
}
