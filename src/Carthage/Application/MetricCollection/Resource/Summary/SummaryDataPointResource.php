<?php

declare(strict_types=1);

namespace Carthage\Application\MetricCollection\Resource\Summary;

use Carthage\Application\MetricCollection\Resource\Metric\MetricDataPointResource;
use Carthage\Domain\MetricCollection\Entity\Summary\SummaryDataPoint;
use Carthage\Domain\Shared\Entity\Identity;
use DateTimeImmutable;

/**
 * The SummaryDataPointResource class represents a summary metric data point in the system, designed for serialization.
 */
final readonly class SummaryDataPointResource extends MetricDataPointResource
{
    protected const TYPE = 'summary_data_point';

    public int|float $value;

    /**
     * Constructs a SummaryDataPointResource.
     *
     * @param non-empty-string $source - The source of the summary data point
     * @param array<string, mixed> $attributes - The attributes of the summary data point
     */
    public function __construct(Identity $identity, Identity $metricIdentity, string $source, DateTimeImmutable $startAt, DateTimeImmutable $endAt, int|float $value, array $attributes, DateTimeImmutable $createdAt, DateTimeImmutable $updatedAt)
    {
        parent::__construct($identity, $metricIdentity, $source, $startAt, $endAt, $attributes, $createdAt, $updatedAt);

        $this->value = $value;
    }

    public static function fromSummaryDataPoint(SummaryDataPoint $sumDataPoint): self
    {
        return new self(
            $sumDataPoint->getIdentity(),
            $sumDataPoint->metric->getIdentity(),
            $sumDataPoint->source,
            $sumDataPoint->startAt,
            $sumDataPoint->endAt,
            $sumDataPoint->value,
            $sumDataPoint->attributes,
            $sumDataPoint->createdAt,
            $sumDataPoint->updatedAt,
        );
    }

    /**
     * @return array{
     *     "type": non-empty-string,
     *     "identity": non-empty-string,
     *     "metric_identity": non-empty-string,
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
