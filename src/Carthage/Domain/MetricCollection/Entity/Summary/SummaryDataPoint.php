<?php

declare(strict_types=1);

namespace Carthage\Domain\MetricCollection\Entity\Summary;

use Carthage\Domain\MetricCollection\Entity\Metric\MetricDataPoint;
use DateTimeImmutable;

/**
 * The SummaryDataPoint class represents a single data point in a summary metric.
 *
 * Each data point is a single measurement that contributes to the total summary.
 */
class SummaryDataPoint extends MetricDataPoint
{
    /**
     * @var int|float the value of the data point
     */
    public int|float $value;

    /**
     * @param Summary $summary the summary of the data point
     * @param non-empty-string $source the source of the data point
     * @param DateTimeImmutable $startAt the start timestamp of the data point
     * @param DateTimeImmutable $endAt the end timestamp of the data point
     * @param int|float $value the value of the data point
     * @param array<string, mixed> $attributes the additional attributes of the data point
     */
    public function __construct(Summary $summary, string $source, DateTimeImmutable $startAt, DateTimeImmutable $endAt, int|float $value, array $attributes = [])
    {
        parent::__construct($summary, $source, $startAt, $endAt, $attributes);

        $this->value = $value;
    }
}
