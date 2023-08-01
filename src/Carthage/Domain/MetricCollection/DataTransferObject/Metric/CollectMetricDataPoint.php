<?php

declare(strict_types=1);

namespace Carthage\Domain\MetricCollection\DataTransferObject\Metric;

use DateTimeImmutable;

abstract class CollectMetricDataPoint
{
    /**
     * @var non-empty-string the source from which this data point was generated
     */
    public string $source;

    /**
     * @var DateTimeImmutable the start timestamp of the data point
     */
    public DateTimeImmutable $startAt;

    /**
     * @var DateTimeImmutable the end timestamp of the data point
     */
    public DateTimeImmutable $endAt;

    /**
     * @var array<string, mixed> the additional attributes of the data point
     */
    public array $attributes = [];

    /**
     * @param non-empty-string $source the source from which this data point was generated
     * @param DateTimeImmutable $startAt the start timestamp of the data point
     * @param DateTimeImmutable $endAt the end timestamp of the data point
     * @param array<string, mixed> $attributes the additional attributes of the data point
     */
    public function __construct(string $source, DateTimeImmutable $startAt, DateTimeImmutable $endAt, array $attributes = [])
    {
        $this->source = $source;
        $this->startAt = $startAt;
        $this->endAt = $endAt;
        $this->attributes = $attributes;
    }
}
