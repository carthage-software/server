<?php

declare(strict_types=1);

namespace Carthage\Domain\MetricCollection\Entity\Gauge;

use Carthage\Domain\MetricCollection\Entity\Metric\MetricDataPoint;
use DateTimeImmutable;

/**
 * The GaugeDataPoint class represents a data point in a gauge metric.
 */
class GaugeDataPoint extends MetricDataPoint
{
    /**
     * @var int|float the value of the gauge at this data point
     */
    public int|float $value;

    /**
     * @param Gauge $gauge the gauge of the data point
     * @param non-empty-string $source the source from which this data point was generated
     * @param DateTimeImmutable $startAt the start timestamp of the data point
     * @param DateTimeImmutable $endAt the end timestamp of the data point
     * @param int|float $value the value of the gauge at this data point
     * @param array<string, mixed> $attributes the additional attributes of the data point
     */
    public function __construct(Gauge $gauge, string $source, DateTimeImmutable $startAt, DateTimeImmutable $endAt, int|float $value, array $attributes = [])
    {
        parent::__construct($gauge, $source, $startAt, $endAt, $attributes);

        $this->value = $value;
    }
}
