<?php

declare(strict_types=1);

namespace Carthage\Domain\MetricCollection\Entity\Histogram;

use Carthage\Domain\MetricCollection\Entity\Metric\MetricDataPoint;
use DateTimeImmutable;

/**
 * The HistogramDataPoint class represents a data point in a histogram.
 */
class HistogramDataPoint extends MetricDataPoint
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
     * @param Histogram $histogram the histogram of the data point
     * @param non-empty-string $source the source from which this data point was generated
     * @param DateTimeImmutable $startAt the start timestamp of the data point
     * @param DateTimeImmutable $endAt the end timestamp of the data point
     * @param int|float $lowerBound the lower bound of the data point
     * @param int|float $upperBound the upper bound of the data point
     * @param int $count the count of the data point
     * @param int|float $summation the summation of the data point
     * @param int|float $minimum the minimum value of the data point
     * @param int|float $maximum the maximum value of the data point
     * @param list<int> $bucketCounts the bucket counts of the histogram data point
     * @param list<int|float> $bucketBoundaries the bucket boundaries of the histogram data point
     * @param array<string, mixed> $attributes the additional attributes of the data point
     */
    public function __construct(Histogram $histogram, string $source, DateTimeImmutable $startAt, DateTimeImmutable $endAt, int|float $lowerBound, int|float $upperBound, int $count, int|float $summation, int|float $minimum, int|float $maximum, array $bucketCounts, array $bucketBoundaries, array $attributes = [])
    {
        parent::__construct($histogram, $source, $startAt, $endAt, $attributes);

        $this->lowerBound = $lowerBound;
        $this->upperBound = $upperBound;
        $this->count = $count;
        $this->summation = $summation;
        $this->minimum = $minimum;
        $this->maximum = $maximum;
        $this->bucketCounts = $bucketCounts;
        $this->bucketBoundaries = $bucketBoundaries;
    }
}
