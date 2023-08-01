<?php

declare(strict_types=1);

namespace Carthage\Domain\MetricCollection\Entity\Summary;

use Carthage\Domain\MetricCollection\Entity\Metric\Metric;
use Carthage\Domain\MetricCollection\Enum\Metric\Temporality;

/**
 * The Summary class represents a summary metric, which is a metric that represents the total summary of a series of measurements
 * over a period of time.
 *
 * Summaries are typically used to represent values such as the total number of requests handled by a server,
 * or the total amount of data sent by an application.
 *
 * @extends Metric<SummaryDataPoint>
 */
class Summary extends Metric
{
    /**
     * @var Temporality the temporality of the summary metric
     */
    public Temporality $temporality;

    /**
     * @param non-empty-string $namespace the namespace of the metric
     * @param non-empty-string $name the name of the metric
     * @param Temporality $temporality the temporality of the summary metric
     * @param non-empty-string|null $description The description of the metric. Null if not provided.
     * @param non-empty-string|null $unit The unit of the metric. Null if not provided.
     */
    public function __construct(string $namespace, string $name, Temporality $temporality, ?string $description = null, ?string $unit = null)
    {
        parent::__construct($namespace, $name, $description, $unit);

        $this->temporality = $temporality;
    }
}
