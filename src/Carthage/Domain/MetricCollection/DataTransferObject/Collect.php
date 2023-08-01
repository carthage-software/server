<?php

declare(strict_types=1);

namespace Carthage\Domain\MetricCollection\DataTransferObject;

use Carthage\Domain\MetricCollection\DataTransferObject\Gauge\CollectGauge;
use Carthage\Domain\MetricCollection\DataTransferObject\Histogram\CollectHistogram;
use Carthage\Domain\MetricCollection\DataTransferObject\Summary\CollectSummary;

use function count;

final class Collect
{
    public const MAX_COLLECTS = 10000;

    /**
     * @var list<CollectGauge>
     */
    public array $collectGauges = [];

    /**
     * @var list<CollectHistogram>
     */
    public array $collectHistograms = [];

    /**
     * @var list<CollectSummary>
     */
    public array $collectSummaries = [];

    /**
     * @param list<CollectGauge> $collectGauges
     * @param list<CollectHistogram> $collectHistograms
     * @param list<CollectSummary> $collectSummaries
     */
    public function __construct(array $collectGauges = [], array $collectHistograms = [], array $collectSummaries = [])
    {
        $this->collectGauges = $collectGauges;
        $this->collectHistograms = $collectHistograms;
        $this->collectSummaries = $collectSummaries;
    }

    public function isEmpty(): bool
    {
        return empty($this->collectGauges) && empty($this->collectHistograms) && empty($this->collectSummaries);
    }

    public function isTooLarge(): bool
    {
        return count($this->collectGauges) + count($this->collectHistograms) + count($this->collectSummaries) > self::MAX_COLLECTS;
    }
}
