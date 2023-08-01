<?php

declare(strict_types=1);

namespace Carthage\Domain\MetricCollection\DataTransferObject\Summary;

use Carthage\Domain\MetricCollection\DataTransferObject\Metric\CollectMetricDataPoint;
use Carthage\Domain\MetricCollection\Entity\Summary\Summary;
use DateTimeImmutable;

final class CollectSummaryDataPoint extends CollectMetricDataPoint
{
    /**
     * @var int|float the value of the gauge data point
     */
    public int|float $value;

    /**
     * @param non-empty-string $source the source from which the data point originated
     * @param DateTimeImmutable $startAt the start time of the data point
     * @param DateTimeImmutable $endAt the end time of the data point
     * @param int|float $value the value of the data point
     * @param array<string, mixed> $attributes the additional attributes of the data point
     */
    public function __construct(string $source, DateTimeImmutable $startAt, DateTimeImmutable $endAt, int|float $value, array $attributes = [])
    {
        parent::__construct($source, $startAt, $endAt, $attributes);

        $this->value = $value;
    }

    public function toCreateSummaryDataPoint(Summary $summary): CreateSummaryDataPoint
    {
        return new CreateSummaryDataPoint(
            $summary->getIdentity(),
            $this->source,
            $this->startAt,
            $this->endAt,
            $this->value,
            $this->attributes
        );
    }
}
