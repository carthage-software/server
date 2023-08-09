<?php

declare(strict_types=1);

namespace Carthage\Domain\MetricCollection\Resource\Histogram;

use Carthage\Domain\MetricCollection\Entity\Histogram\Histogram;
use Carthage\Domain\MetricCollection\Enum\Metric\Temporality;
use Carthage\Domain\MetricCollection\Resource\Metric\MetricResource;
use Carthage\Domain\Shared\Entity\Identity;
use DateTimeImmutable;

/**
 * The HistogramResource class represents a histogram metric in the system, designed for serialization.
 */
final readonly class HistogramResource extends MetricResource
{
    protected const TYPE = 'histogram';

    public Temporality $temporality;

    /**
     * Constructs a HistogramResource.
     *
     * @param non-empty-string $namespace - The namespace of the histogram
     * @param non-empty-string $name - The name of the histogram
     * @param non-empty-string|null $description - The description of the histogram
     * @param non-empty-string|null $unit - The unit of the histogram
     */
    public function __construct(
        Identity $identity,
        string $namespace,
        string $name,
        ?string $description,
        ?string $unit,
        Temporality $temporality,
        DateTimeImmutable $createdAt,
        DateTimeImmutable $updatedAt,
    ) {
        parent::__construct($identity, $namespace, $name, $description, $unit, $createdAt, $updatedAt);

        $this->temporality = $temporality;
    }

    public static function fromHistogram(Histogram $histogram): self
    {
        return new self(
            $histogram->getIdentity(),
            $histogram->namespace,
            $histogram->name,
            $histogram->description,
            $histogram->unit,
            $histogram->temporality,
            $histogram->createdAt,
            $histogram->updatedAt,
        );
    }

    /**
     * @return array{
     *      "@type": non-empty-string,
     *      "@identity": non-empty-string,
     *      "namespace": non-empty-string,
     *      "name": non-empty-string,
     *      "description": non-empty-string|null,
     *      "unit": non-empty-string|null,
     *      "created_at": non-empty-string,
     *      "updated_at": non-empty-string,
     *      "temporality": array{
     *          "name": non-empty-string,
     *          "value": non-empty-string,
     *      },
     *  }
     */
    public function jsonSerialize(): array
    {
        $result = $this->jsonSerializeMetric();
        $result['temporality'] = $this->temporality->jsonSerialize();

        return $result;
    }
}
