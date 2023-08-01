<?php

declare(strict_types=1);

namespace Carthage\Domain\MetricCollection\DataTransferObject\Histogram;

use Carthage\Domain\MetricCollection\DataTransferObject\Metric\CollectMetricDataPoint;
use Carthage\Domain\MetricCollection\Entity\Histogram\Histogram;
use DateTimeImmutable;

final class CollectHistogramDataPoint extends CollectMetricDataPoint
{
    /**
     * @var int|float the lower bound of the data point
     */
    public int|float $lowerBound;

    /**
     * @var int|float the upper bound of the data point
     */
    public int|float $upperBound;

    /**
     * @var int the count of the data point
     */
    public int $count;

    /**
     * @var int|float the summation of the data point
     */
    public int|float $summation;

    /**
     * @var int|float the minimum value of the data point
     */
    public int|float $minimum;

    /**
     * @var int|float the maximum value of the data point
     */
    public int|float $maximum;

    /**
     * @var list<int> the bucket counts of the histogram data point
     */
    public array $bucketCounts;

    /**
     * @var list<int|float> the bucket boundaries of the histogram data point
     */
    public array $bucketBoundaries;

    /**
     * CreateHistogramDataPoint constructor.
     *
     * @param non-empty-string $source the source of the data point
     * @param DateTimeImmutable $startAt the starting time of the data point
     * @param DateTimeImmutable $endAt the ending time of the data point
     * @param int|float $lowerBound the lower bound of the data point
     * @param int|float $upperBound the upper bound of the data point
     * @param int $count the count of the data point
     * @param int|float $summation the summation of the data point
     * @param int|float $minimum the minimum value of the data point
     * @param int|float $maximum the maximum value of the data point
     * @param list<int> $bucketCounts the bucket counts of the histogram data point
     * @param list<int|float> $bucketBoundaries the bucket boundaries of the histogram data point
     * @param array<string, mixed> $attributes Additional attributes for the data point. Default is an empty array.
     */
    public function __construct(string $source, DateTimeImmutable $startAt, DateTimeImmutable $endAt, int|float $lowerBound, int|float $upperBound, int $count, int|float $summation, int|float $minimum, int|float $maximum, array $bucketCounts, array $bucketBoundaries, array $attributes = [])
    {
        parent::__construct($source, $startAt, $endAt, $attributes);

        $this->lowerBound = $lowerBound;
        $this->upperBound = $upperBound;
        $this->count = $count;
        $this->summation = $summation;
        $this->minimum = $minimum;
        $this->maximum = $maximum;
        $this->bucketCounts = $bucketCounts;
        $this->bucketBoundaries = $bucketBoundaries;
    }

    public function toCreateHistogramDataPoint(Histogram $histogram): CreateHistogramDataPoint
    {
        return new CreateHistogramDataPoint(
            $histogram->getIdentity(),
            $this->source,
            $this->startAt,
            $this->endAt,
            $this->lowerBound,
            $this->upperBound,
            $this->count,
            $this->summation,
            $this->minimum,
            $this->maximum,
            $this->bucketCounts,
            $this->bucketBoundaries,
            $this->attributes
        );
    }
}
