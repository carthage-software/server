<?php

declare(strict_types=1);

namespace Carthage\Application\MetricCollection\Resource\Metric;

use Carthage\Application\Shared\Resource\ResourceInterface;
use Carthage\Domain\Shared\Entity\Identity;
use DateTimeImmutable;

/**
 * The MetricDataPointResource class represents a metric data point in the system, designed for serialization.
 */
abstract readonly class MetricDataPointResource implements ResourceInterface
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
        public Identity $metricIdentity,
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
    public function getType(): string
    {
        return static::TYPE;
    }
}
