<?php

declare(strict_types=1);

namespace Carthage\Domain\MetricCollection\Resource\Gauge;

use Carthage\Domain\MetricCollection\Entity\Gauge\Gauge;
use Carthage\Domain\MetricCollection\Resource\Metric\MetricResource;

/**
 * The GaugeResource class represents a gauge metric in the system, designed for serialization.
 */
final readonly class GaugeResource extends MetricResource
{
    protected const TYPE = 'gauge';

    public static function fromGauge(Gauge $gauge): self
    {
        return new self(
            $gauge->getIdentity(),
            $gauge->namespace,
            $gauge->name,
            $gauge->description,
            $gauge->unit,
            $gauge->createdAt,
            $gauge->updatedAt,
        );
    }

    /**
     * @return array{
     *      "@type": non-empty-string,
     *      "@id": string,
     *      "namespace": non-empty-string,
     *      "name": non-empty-string,
     *      "description": non-empty-string|null,
     *      "unit": non-empty-string|null,
     *      "created_at": non-empty-string,
     *      "updated_at": non-empty-string,
     *  }
     */
    public function jsonSerialize(): array
    {
        return $this->jsonSerializeMetric();
    }
}
