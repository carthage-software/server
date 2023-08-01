<?php

declare(strict_types=1);

namespace Carthage\Domain\MetricCollection\DataTransferObject\Histogram;

use Carthage\Domain\MetricCollection\DataTransferObject\Metric\CreateMetric;
use Carthage\Domain\MetricCollection\Enum\Metric\Temporality;

final class CreateHistogram extends CreateMetric
{
    /**
     * @var Temporality The temporality of the histogram. Temporality defines how the data is aggregated over time.
     */
    public Temporality $temporality;

    /**
     * @param non-empty-string $namespace the namespace related to the histogram
     * @param non-empty-string $name the name of the histogram
     * @param Temporality $temporality the temporality of the histogram
     * @param non-empty-string|null $description the optional description of the histogram
     * @param non-empty-string|null $unit the optional unit of the histogram
     */
    public function __construct(string $namespace, string $name, Temporality $temporality, ?string $description = null, ?string $unit = null)
    {
        parent::__construct($namespace, $name, $description, $unit);

        $this->temporality = $temporality;
    }
}
