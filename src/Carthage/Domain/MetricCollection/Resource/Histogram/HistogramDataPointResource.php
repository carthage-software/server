<?php

declare(strict_types=1);

namespace Carthage\Domain\MetricCollection\Resource\Histogram;

use Carthage\Domain\MetricCollection\Entity\Histogram\HistogramDataPoint;
use Carthage\Domain\MetricCollection\Resource\Metric\MetricDataPointResource;
use Carthage\Domain\Shared\Entity\Identity;
use DateTimeImmutable;

/**
 * The HistogramDataPointResource class represents a histogram metric data point in the system, designed for serialization.
 */
final readonly class HistogramDataPointResource extends MetricDataPointResource
{
    protected const TYPE = 'histogram_data_point';

    public int|float $lowerBound;
    public int|float $upperBound;
    public int $count;
    public int|float $summation;
    public int|float $minimum;
    public int|float $maximum;
    public array $bucketCounts;
    public array $bucketBoundaries;

    /**
     * Constructs a HistogramDataPointResource.
     *
     * @param non-empty-string $source - The source of the histogram data point
     * @param array<string, mixed> $attributes - The attributes of the histogram data point
     * @param array<int, int> $bucketCounts - The bucket counts of the histogram data point
     * @param array<int, int|float> $bucketBoundaries - The bucket boundaries of the histogram data point
     */
    public function __construct(
        Identity $identity,
        Identity $metricIdentity,
        string $source,
        DateTimeImmutable $startAt,
        DateTimeImmutable $endAt,
        int|float $lowerBound,
        int|float $upperBound,
        int $count,
        int|float $summation,
        int|float $minimum,
        int|float $maximum,
        array $bucketCounts,
        array $bucketBoundaries,
        array $attributes,
        DateTimeImmutable $createdAt,
        DateTimeImmutable $updatedAt,
    ) {
        parent::__construct($identity, $metricIdentity, $source, $startAt, $endAt, $attributes, $createdAt, $updatedAt);

        $this->lowerBound = $lowerBound;
        $this->upperBound = $upperBound;
        $this->count = $count;
        $this->summation = $summation;
        $this->minimum = $minimum;
        $this->maximum = $maximum;
        $this->bucketCounts = $bucketCounts;
        $this->bucketBoundaries = $bucketBoundaries;
    }

    public static function fromHistogramDataPoint(HistogramDataPoint $histogramDataPoint): self
    {
        return new self(
            $histogramDataPoint->getIdentity(),
            $histogramDataPoint->metric->getIdentity(),
            $histogramDataPoint->source,
            $histogramDataPoint->startAt,
            $histogramDataPoint->endAt,
            $histogramDataPoint->lowerBound,
            $histogramDataPoint->upperBound,
            $histogramDataPoint->count,
            $histogramDataPoint->summation,
            $histogramDataPoint->minimum,
            $histogramDataPoint->maximum,
            $histogramDataPoint->bucketCounts,
            $histogramDataPoint->bucketBoundaries,
            $histogramDataPoint->attributes,
            $histogramDataPoint->createdAt,
            $histogramDataPoint->updatedAt,
        );
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
     *     "lower_bound": int|float,
     *     "upper_bound": int|float,
     *     "count": int,
     *     "summation": int|float,
     *     "minimum": int|float,
     *     "maximum": int|float,
     *     "bucket_counts": array<int, int>,
     *     "bucket_boundaries": array<int, int|float>,
     *  }
     */
    public function jsonSerialize(): array
    {
        $result = $this->jsonSerializeMetricDataPoint();
        $result['lower_bound'] = $this->lowerBound;
        $result['upper_bound'] = $this->upperBound;
        $result['count'] = $this->count;
        $result['summation'] = $this->summation;
        $result['minimum'] = $this->minimum;
        $result['maximum'] = $this->maximum;
        $result['bucket_counts'] = $this->bucketCounts;
        $result['bucket_boundaries'] = $this->bucketBoundaries;

        return $result;
    }
}
