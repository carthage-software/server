<?php

declare(strict_types=1);

namespace Carthage\Domain\MetricCollection\Entity\Metric;

use Carthage\Domain\Shared\Entity\Entity;
use DateTimeImmutable;

abstract class MetricDataPoint extends Entity
{
    /**
     * @var Metric<MetricDataPoint> the metric to which this data point belongs
     */
    public Metric $metric;

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
     * @param Metric<MetricDataPoint> $metric the metric to which this data point belongs
     * @param non-empty-string $source the source from which this data point was generated
     * @param DateTimeImmutable $startAt the start timestamp of the data point
     * @param DateTimeImmutable $endAt the end timestamp of the data point
     * @param array<string, mixed> $attributes the additional attributes of the data point
     */
    public function __construct(Metric $metric, string $source, DateTimeImmutable $startAt, DateTimeImmutable $endAt, array $attributes = [])
    {
        parent::__construct();

        $this->metric = $metric;
        $this->source = $source;
        $this->startAt = $startAt;
        $this->endAt = $endAt;
        $this->attributes = $attributes;
    }
}
