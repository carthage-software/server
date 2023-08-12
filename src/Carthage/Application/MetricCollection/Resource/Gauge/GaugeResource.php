<?php

declare(strict_types=1);

namespace Carthage\Application\MetricCollection\Resource\Gauge;

use Carthage\Application\MetricCollection\Resource\Metric\MetricResource;
use Carthage\Domain\MetricCollection\Entity\Gauge\Gauge;

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
}
