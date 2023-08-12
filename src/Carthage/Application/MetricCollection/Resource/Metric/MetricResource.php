<?php

declare(strict_types=1);

namespace Carthage\Application\MetricCollection\Resource\Metric;

use Carthage\Application\MetricCollection\Resource\Gauge\GaugeResource;
use Carthage\Application\MetricCollection\Resource\Histogram\HistogramResource;
use Carthage\Application\MetricCollection\Resource\Summary\SummaryResource;
use Carthage\Application\Shared\Resource\ItemResourceInterface;
use Carthage\Domain\MetricCollection\Entity\Gauge\Gauge;
use Carthage\Domain\MetricCollection\Entity\Histogram\Histogram;
use Carthage\Domain\MetricCollection\Entity\Metric\Metric;
use Carthage\Domain\MetricCollection\Entity\Summary\Summary;
use Carthage\Domain\Shared\Entity\Identity;
use DateTimeImmutable;
use DateTimeInterface;
use Psl\Type;

/**
 * The MetricResource class represents a metric in the system, designed for serialization.
 */
abstract readonly class MetricResource implements ItemResourceInterface
{
    protected const TYPE = 'metric';

    /**
     * Constructs a MetricResource.
     *
     * @param non-empty-string $namespace - The namespace of the metric
     * @param non-empty-string $name - The name of the metric
     * @param non-empty-string|null $description - The description of the metric
     * @param non-empty-string|null $unit - The unit of the metric
     */
    public function __construct(
        public Identity $identity,
        public string $namespace,
        public string $name,
        public ?string $description,
        public ?string $unit,
        public DateTimeImmutable $createdAt,
        public DateTimeImmutable $updatedAt,
    ) {
    }

    public static function fromMetric(Metric $metric): self
    {
        if ($metric instanceof Gauge) {
            return GaugeResource::fromGauge($metric);
        }

        if ($metric instanceof Histogram) {
            return HistogramResource::fromHistogram($metric);
        }

        return SummaryResource::fromSummary(
            Type\instance_of(Summary::class)->assert($metric),
        );
    }

    /**
     * {@inheritDoc}
     */
    public function getIdentity(): Identity
    {
        return $this->identity;
    }

    /**
     * {@inheritDoc}
     */
    public function getType(): string
    {
        return static::TYPE;
    }

    /**
     * @return array{
     *      "type": non-empty-string,
     *      "identity": non-empty-string,
     *      "namespace": non-empty-string,
     *      "name": non-empty-string,
     *      "description": non-empty-string|null,
     *      "unit": non-empty-string|null,
     *      "created_at": non-empty-string,
     *      "updated_at": non-empty-string,
     *  }
     */
    final protected function jsonSerializeMetric(): array
    {
        return [
            'type' => $this->getType(),
            'identity' => $this->identity->value,
            'namespace' => $this->namespace,
            'name' => $this->name,
            'description' => $this->description,
            'unit' => $this->unit,
            'created_at' => $this->createdAt->format(DateTimeInterface::RFC3339),
            'updated_at' => $this->updatedAt->format(DateTimeInterface::RFC3339),
        ];
    }
}
