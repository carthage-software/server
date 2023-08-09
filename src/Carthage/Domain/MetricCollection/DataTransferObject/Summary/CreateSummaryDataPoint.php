<?php

declare(strict_types=1);

namespace Carthage\Domain\MetricCollection\DataTransferObject\Summary;

use Carthage\Domain\MetricCollection\DataTransferObject\Metric\CreateMetricDataPoint;
use Carthage\Domain\Shared\Entity\Identity;
use DateTimeImmutable;

final class CreateSummaryDataPoint extends CreateMetricDataPoint
{
    /**
     * @var int|float the value of the data point
     */
    public int|float $value;

    /**
     * @param non-empty-string $source the source from which the data point originated
     * @param DateTimeImmutable $startAt the start time of the data point
     * @param DateTimeImmutable $endAt the end time of the data point
     * @param int|float $value the value of the data point
     * @param array<string, mixed> $attributes the additional attributes of the data point
     */
    public function __construct(Identity $summaryIdentity, string $source, DateTimeImmutable $startAt, DateTimeImmutable $endAt, int|float $value, array $attributes = [])
    {
        parent::__construct($summaryIdentity, $source, $startAt, $endAt, $attributes);

        $this->value = $value;
    }
}
