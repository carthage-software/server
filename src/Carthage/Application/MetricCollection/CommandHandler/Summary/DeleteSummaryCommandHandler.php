<?php

declare(strict_types=1);

namespace Carthage\Application\MetricCollection\CommandHandler\Summary;

use Carthage\Application\MetricCollection\Command\Summary\DeleteSummaryCommand;
use Carthage\Application\Shared\CommandHandler\CommandHandlerInterface;
use Carthage\Domain\MetricCollection\Event\Summary\SummaryDeletedEvent;
use Carthage\Domain\MetricCollection\Service\Summary\SummaryService;
use Psr\EventDispatcher\EventDispatcherInterface;

final readonly class DeleteSummaryCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private SummaryService $summaryService,
        private EventDispatcherInterface $eventDispatcher,
    ) {
    }

    public function __invoke(DeleteSummaryCommand $command): void
    {
        $this->summaryService->deleteSummary($command->summaryId);

        $this->eventDispatcher->dispatch(new SummaryDeletedEvent($command->summaryId));
    }
}
