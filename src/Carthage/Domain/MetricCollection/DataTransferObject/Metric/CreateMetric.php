<?php

declare(strict_types=1);

namespace Carthage\Domain\MetricCollection\DataTransferObject\Metric;

abstract class CreateMetric
{
    /**
     * @var non-empty-string the namespace of the metric
     */
    public string $namespace;

    /**
     * @var non-empty-string the name of the metric
     */
    public string $name;

    /**
     * @var non-empty-string|null The description of the metric. Null if not provided.
     */
    public ?string $description = null;

    /**
     * @var non-empty-string|null The unit of the metric. Null if not provided.
     */
    public ?string $unit = null;

    /**
     * @param non-empty-string $namespace the namespace of the metric
     * @param non-empty-string $name the name of the metric
     * @param non-empty-string|null $description The description of the metric. Null if not provided.
     * @param non-empty-string|null $unit The unit of the metric. Null if not provided.
     */
    public function __construct(string $namespace, string $name, ?string $description = null, ?string $unit = null)
    {
        $this->namespace = $namespace;
        $this->name = $name;
        $this->description = $description;
        $this->unit = $unit;
    }
}
