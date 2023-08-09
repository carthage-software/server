<?php

declare(strict_types=1);

namespace Carthage\Application\LogManagement\CommandHandler\Log;

use Carthage\Application\LogManagement\Command\Log\DeleteLogEntryCommand;
use Carthage\Application\Shared\CommandHandler\CommandHandlerInterface;
use Carthage\Domain\LogManagement\Event\Log\LogEntryDeletedEvent;
use Carthage\Domain\LogManagement\Exception\Log\NotFoundException;
use Carthage\Domain\LogManagement\Service\Log\LogEntryService;
use Psr\EventDispatcher\EventDispatcherInterface;

final readonly class DeleteLogEntryCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private LogEntryService $logEntryService,
        private EventDispatcherInterface $eventDispatcher,
    ) {
    }

    /**
     * @throws NotFoundException when the log entry does not exist
     */
    public function __invoke(DeleteLogEntryCommand $command): void
    {
        $this->logEntryService->deleteLogEntry($command->logEntryIdentity);

        $this->eventDispatcher->dispatch(
            new LogEntryDeletedEvent($command->logEntryIdentity),
        );
    }
}
