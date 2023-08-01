<?php

declare(strict_types=1);

namespace Carthage\Domain\MetricCollection\Entity\Metric;

use Carthage\Domain\Shared\Entity\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * A metric is a collection of data points.
 *
 * @template-covariant TDataPoint of MetricDataPoint
 */
abstract class Metric extends Entity
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
     * @var Collection<int, TDataPoint> a collection of data points for the metric
     */
    public Collection $dataPoints;

    /**
     * @param non-empty-string $namespace the namespace of the metric
     * @param non-empty-string $name the name of the metric
     * @param non-empty-string|null $description The description of the metric. Null if not provided.
     * @param non-empty-string|null $unit The unit of the metric. Null if not provided.
     */
    public function __construct(string $namespace, string $name, ?string $description = null, ?string $unit = null)
    {
        parent::__construct();

        $this->namespace = $namespace;
        $this->name = $name;
        $this->description = $description;
        $this->unit = $unit;
        $this->dataPoints = new ArrayCollection();
    }
}
