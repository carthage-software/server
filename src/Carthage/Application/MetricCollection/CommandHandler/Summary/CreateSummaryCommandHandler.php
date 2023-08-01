<?php

declare(strict_types=1);

namespace Carthage\Application\MetricCollection\CommandHandler\Summary;

use Carthage\Application\MetricCollection\Command\Summary\CreateSummaryCommand;
use Carthage\Application\Shared\CommandHandler\CommandHandlerInterface;
use Carthage\Domain\MetricCollection\Event\Summary\SummaryCreatedEvent;
use Carthage\Domain\MetricCollection\Service\Summary\SummaryService;
use Psr\EventDispatcher\EventDispatcherInterface;

final readonly class CreateSummaryCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private SummaryService $summaryService,
        private EventDispatcherInterface $eventDispatcher,
    ) {
    }

    public function __invoke(CreateSummaryCommand $command): void
    {
        $summary = $this->summaryService->createSummary($command->createSummary);

        $this->eventDispatcher->dispatch(new SummaryCreatedEvent($summary->getIdentity()));
    }
}
