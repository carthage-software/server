<?php

declare(strict_types=1);

namespace Carthage\Application\MetricCollection\CommandHandler\Summary;

use Carthage\Application\MetricCollection\Command\Summary\CollectSummaryCommand;
use Carthage\Application\MetricCollection\Service\Summary\SummaryCollector;
use Carthage\Application\Shared\CommandHandler\CommandHandlerInterface;

final readonly class CollectSummaryCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private SummaryCollector $summaryCollector,
    ) {
    }

    public function __invoke(CollectSummaryCommand $command): void
    {
        $this->summaryCollector->collectSummary($command->collectSummary);
    }
}
