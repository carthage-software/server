<?php

declare(strict_types=1);

namespace Carthage\Domain\MetricCollection\Resource\Metric;

use Carthage\Domain\Shared\Entity\Identity;
use Carthage\Domain\Shared\Resource\ItemResourceInterface;
use DateTimeImmutable;
use DateTimeInterface;

/**
 * The MetricDataPointResource class represents a metric data point in the system, designed for serialization.
 */
abstract readonly class MetricDataPointResource implements ItemResourceInterface
{
    protected const TYPE = 'metric_data_point';

    /**
     * Constructs a MetricDataPointResource.
     *
     * @param non-empty-string $source - The source of the metric data point
     * @param array<string, mixed> $attributes - The attributes of the metric data point
     */
    public function __construct(
        public Identity $identity,
        public Identity $metricIdentityIdentity,
        public string $source,
        public DateTimeImmutable $startAt,
        public DateTimeImmutable $endAt,
        public array $attributes,
        public DateTimeImmutable $createdAt,
        public DateTimeImmutable $updatedAt,
    ) {
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
     *     "@type": non-empty-string,
     *     "@identity": non-empty-string,
     *     "metric_identity": non-empty-string,
     *     "source": non-empty-string,
     *     "start_at": non-empty-string,
     *     "end_at": non-empty-string,
     *     "attributes": array<string, mixed>,
     *     "created_at": non-empty-string,
     *     "updated_at": non-empty-string,
     *  }
     */
    final protected function jsonSerializeMetricDataPoint(): array
    {
        return [
            '@type' => $this->getType(),
            '@identity' => $this->getIdentity()->value,
            'metric_identity' => $this->metricIdentityIdentity->value,
            'source' => $this->source,
            'start_at' => $this->startAt->format(DateTimeInterface::RFC3339_EXTENDED),
            'end_at' => $this->endAt->format(DateTimeInterface::RFC3339_EXTENDED),
            'attributes' => $this->attributes,
            'created_at' => $this->createdAt->format(DateTimeInterface::RFC3339_EXTENDED),
            'updated_at' => $this->updatedAt->format(DateTimeInterface::RFC3339_EXTENDED),
        ];
    }
}
