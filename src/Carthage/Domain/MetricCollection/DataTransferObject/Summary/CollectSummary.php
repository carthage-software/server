<?php

declare(strict_types=1);

namespace Carthage\Domain\MetricCollection\DataTransferObject\Summary;

final class CollectSummary
{
    public CreateSummary $summary;

    /**
     * @var list<CollectSummaryDataPoint>
     */
    public array $dataPoints;

    /**
     * @param CreateSummary $summary the summary to collect
     * @param list<CollectSummaryDataPoint> $dataPoints the data points to collect
     */
    public function __construct(CreateSummary $summary, array $dataPoints)
    {
        $this->summary = $summary;
        $this->dataPoints = $dataPoints;
    }
}
