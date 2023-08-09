<?php

declare(strict_types=1);

namespace Carthage\Application\LogManagement\CommandHandler\Log;

use Carthage\Application\LogManagement\Command\Log\DeleteLogCommand;
use Carthage\Application\Shared\CommandHandler\CommandHandlerInterface;
use Carthage\Domain\LogManagement\Event\Log\LogDeletedEvent;
use Carthage\Domain\LogManagement\Exception\Log\NotFoundException;
use Carthage\Domain\LogManagement\Service\Log\LogService;
use Psr\EventDispatcher\EventDispatcherInterface;

final readonly class DeleteLogCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private LogService $logService,
        private EventDispatcherInterface $eventDispatcher,
    ) {
    }

    /**
     * @throws NotFoundException when the log does not exist
     */
    public function __invoke(DeleteLogCommand $command): void
    {
        $this->logService->deleteLog($command->logIdentity);

        $this->eventDispatcher->dispatch(
            new LogDeletedEvent($command->logIdentity),
        );
    }
}
