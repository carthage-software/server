<?php

declare(strict_types=1);

namespace Carthage\Domain\MetricCollection\DataTransferObject\Summary;

use Carthage\Domain\MetricCollection\DataTransferObject\Metric\CreateMetric;
use Carthage\Domain\MetricCollection\Enum\Metric\Temporality;

final class CreateSummary extends CreateMetric
{
    /**
     * @var Temporality the temporality of the summary
     */
    public Temporality $temporality;

    /**
     * @param non-empty-string $namespace the namespace of the metric
     * @param non-empty-string $name the name of the metric
     * @param non-empty-string|null $description The description of the metric. Null if not provided.
     * @param non-empty-string|null $unit The unit of the metric. Null if not provided.
     */
    public function __construct(string $namespace, string $name, Temporality $temporality, ?string $description = null, ?string $unit = null)
    {
        parent::__construct($namespace, $name, $description, $unit);

        $this->temporality = $temporality;
    }
}
