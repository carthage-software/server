<?php

declare(strict_types=1);

namespace Carthage\Application\MetricCollection\CommandHandler;

use Carthage\Application\MetricCollection\Command\CollectCommand;
use Carthage\Application\MetricCollection\Service\Gauge\GaugeCollector;
use Carthage\Application\MetricCollection\Service\Histogram\HistogramCollector;
use Carthage\Application\MetricCollection\Service\Summary\SummaryCollector;
use Carthage\Application\Shared\CommandHandler\CommandHandlerInterface;

final readonly class CollectCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private GaugeCollector $gaugeCollector,
        private HistogramCollector $histogramCollector,
        private SummaryCollector $summaryCollector,
    ) {
    }

    public function __invoke(CollectCommand $command): void
    {
        foreach ($command->collect->collectGauges as $collectGauge) {
            $this->gaugeCollector->collectGauge($collectGauge);
        }

        foreach ($command->collect->collectHistograms as $collectHistogram) {
            $this->histogramCollector->collectHistogram($collectHistogram);
        }

        foreach ($command->collect->collectSummaries as $collectSummary) {
            $this->summaryCollector->collectSummary($collectSummary);
        }
    }
}
