<?php

declare(strict_types=1);

namespace Carthage\Domain\MetricCollection\DataTransferObject\Gauge;

final class CollectGauge
{
    public CreateGauge $gauge;

    /**
     * @var list<CollectGaugeDataPoint>
     */
    public array $dataPoints;

    /**
     * @param CreateGauge $gauge the gauge to collect
     * @param list<CollectGaugeDataPoint> $dataPoints the data points to collect
     */
    public function __construct(CreateGauge $gauge, array $dataPoints)
    {
        $this->gauge = $gauge;
        $this->dataPoints = $dataPoints;
    }
}
