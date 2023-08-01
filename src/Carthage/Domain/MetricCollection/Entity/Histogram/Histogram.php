<?php

declare(strict_types=1);

namespace Carthage\Domain\MetricCollection\Entity\Histogram;

use Carthage\Domain\MetricCollection\Entity\Metric\Metric;
use Carthage\Domain\MetricCollection\Enum\Metric\Temporality;

/**
 * The Histogram class represents a histogram metric, which is a metric that represents the distribution of a set of values.
 *
 * @extends Metric<HistogramDataPoint>
 */
class Histogram extends Metric
{
    /**
     * @var Temporality the temporality of the histogram
     */
    public Temporality $temporality;

    /**
     * @param non-empty-string $namespace the namespace of the metric
     * @param non-empty-string $name the name of the metric
     * @param Temporality $temporality the temporality of the histogram
     * @param non-empty-string|null $description The description of the metric. Null if not provided.
     * @param non-empty-string|null $unit The unit of the metric. Null if not provided.
     */
    public function __construct(string $namespace, string $name, Temporality $temporality, ?string $description = null, ?string $unit = null)
    {
        parent::__construct($namespace, $name, $description, $unit);

        $this->temporality = $temporality;
    }
}
