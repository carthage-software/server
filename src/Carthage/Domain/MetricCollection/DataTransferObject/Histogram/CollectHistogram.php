<?php

declare(strict_types=1);

namespace Carthage\Domain\MetricCollection\DataTransferObject\Histogram;

final class CollectHistogram
{
    public CreateHistogram $histogram;

    /**
     * @var list<CollectHistogramDataPoint>
     */
    public array $dataPoints;

    /**
     * @param CreateHistogram $histogram the histogram to collect
     * @param list<CollectHistogramDataPoint> $dataPoints the data points to collect
     */
    public function __construct(CreateHistogram $histogram, array $dataPoints)
    {
        $this->histogram = $histogram;
        $this->dataPoints = $dataPoints;
    }
}
