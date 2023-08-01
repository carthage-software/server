<?php

declare(strict_types=1);

namespace Carthage\Domain\MetricCollection\Entity\Gauge;

use Carthage\Domain\MetricCollection\Entity\Metric\Metric;

/**
 * The Gauge class represents a gauge metric, which is a metric that represents a single numerical value that can
 * arbitrarily go up and down.
 *
 * Gauges are typically used to represent values such as the current memory usage of a process,
 * or the current number of concurrent users on a website.
 *
 * @extends Metric<GaugeDataPoint>
 */
class Gauge extends Metric
{
}
