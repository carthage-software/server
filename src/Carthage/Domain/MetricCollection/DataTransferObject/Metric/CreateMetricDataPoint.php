<?php

declare(strict_types=1);

namespace Carthage\Domain\MetricCollection\DataTransferObject\Metric;

use Carthage\Domain\Shared\Entity\Identity;
use DateTimeImmutable;

abstract class CreateMetricDataPoint extends CollectMetricDataPoint
{
    /**
     * @var Identity the identity of the metric
     */
    public Identity $metricIdentity;

    /**
     * @param non-empty-string $source the source from which this data point was generated
     * @param DateTimeImmutable $startAt the start timestamp of the data point
     * @param DateTimeImmutable $endAt the end timestamp of the data point
     * @param array<string, mixed> $attributes the additional attributes of the data point
     */
    public function __construct(Identity $metricIdentity, string $source, DateTimeImmutable $startAt, DateTimeImmutable $endAt, array $attributes = [])
    {
        parent::__construct($source, $startAt, $endAt, $attributes);

        $this->metricIdentity = $metricIdentity;
    }
}
