<?php

declare(strict_types=1);

namespace Carthage\Domain\MetricCollection\Resource\Gauge;

use Carthage\Domain\MetricCollection\Entity\Gauge\GaugeDataPoint;
use Carthage\Domain\MetricCollection\Resource\Metric\MetricDataPointResource;
use DateTimeImmutable;
use Symfony\Component\Uid\Ulid;

/**
 * The GaugeDataPointResource class represents a gauge metric data point in the system, designed for serialization.
 */
final readonly class GaugeDataPointResource extends MetricDataPointResource
{
    protected const TYPE = 'gauge_data_point';

    public int|float $value;

    /**
     * Constructs a GaugeDataPointResource.
     *
     * @param non-empty-string $source - The source of the gauge data point
     * @param array<string, mixed> $attributes - The attributes of the gauge data point
     */
    public function __construct(Ulid $id, Ulid $metric, string $source, DateTimeImmutable $startAt, DateTimeImmutable $endAt, int|float $value, array $attributes, DateTimeImmutable $createdAt, DateTimeImmutable $updatedAt)
    {
        parent::__construct($id, $metric, $source, $startAt, $endAt, $attributes, $createdAt, $updatedAt);

        $this->value = $value;
    }

    public static function fromGaugeDataPoint(GaugeDataPoint $gaugeDataPoint): self
    {
        return new self(
            $gaugeDataPoint->getIdentity(),
            $gaugeDataPoint->metric->getIdentity(),
            $gaugeDataPoint->source,
            $gaugeDataPoint->startAt,
            $gaugeDataPoint->endAt,
            $gaugeDataPoint->value,
            $gaugeDataPoint->attributes,
            $gaugeDataPoint->createdAt,
            $gaugeDataPoint->updatedAt,
        );
    }

    /**
     * @return array{
     *     "@type": non-empty-string,
     *     "@id": string,
     *     "metric": string,
     *     "source": non-empty-string,
     *     "start_at": non-empty-string,
     *     "end_at": non-empty-string,
     *     "attributes": array<string, mixed>,
     *     "created_at": non-empty-string,
     *     "updated_at": non-empty-string,
     *     "value": int|float,
     *  }
     */
    public function jsonSerialize(): array
    {
        $result = $this->jsonSerializeMetricDataPoint();
        $result['value'] = $this->value;

        return $result;
    }
}
