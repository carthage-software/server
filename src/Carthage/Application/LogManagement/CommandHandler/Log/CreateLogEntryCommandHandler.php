<?php

declare(strict_types=1);

namespace Carthage\Application\LogManagement\CommandHandler\Log;

use Carthage\Application\LogManagement\Command\Log\CreateLogEntryCommand;
use Carthage\Application\Shared\CommandHandler\CommandHandlerInterface;
use Carthage\Domain\LogManagement\Event\Log\LogEntryCreatedEvent;
use Carthage\Domain\LogManagement\Exception\Log\NotFoundException;
use Carthage\Domain\LogManagement\Service\Log\LogEntryService;
use Psr\EventDispatcher\EventDispatcherInterface;

final readonly class CreateLogEntryCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private LogEntryService $logEntryService,
        private EventDispatcherInterface $eventDispatcher,
    ) {
    }

    /**
     * @throws NotFoundException when either the log does not exist
     */
    public function __invoke(CreateLogEntryCommand $command): void
    {
        $logEntry = $this->logEntryService->createLogEntry($command->createLogEntry);

        $this->eventDispatcher->dispatch(
            new LogEntryCreatedEvent($logEntry->getIdentity()),
        );
    }
}
