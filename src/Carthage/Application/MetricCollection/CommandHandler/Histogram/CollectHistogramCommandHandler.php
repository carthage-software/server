<?php

declare(strict_types=1);

namespace Carthage\Application\MetricCollection\CommandHandler\Histogram;

use Carthage\Application\MetricCollection\Command\Histogram\CollectHistogramCommand;
use Carthage\Application\MetricCollection\Service\Histogram\HistogramCollector;
use Carthage\Application\Shared\CommandHandler\CommandHandlerInterface;

final readonly class CollectHistogramCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private HistogramCollector $histogramCollector,
    ) {
    }

    public function __invoke(CollectHistogramCommand $command): void
    {
        $this->histogramCollector->collectHistogram($command->collectHistogram);
    }
}
