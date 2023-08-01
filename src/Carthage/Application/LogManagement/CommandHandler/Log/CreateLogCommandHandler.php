<?php

declare(strict_types=1);

namespace Carthage\Application\LogManagement\CommandHandler\Log;

use Carthage\Application\LogManagement\Command\Log\CreateLogCommand;
use Carthage\Application\Shared\CommandHandler\CommandHandlerInterface;
use Carthage\Domain\LogManagement\Event\Log\LogCreatedEvent;
use Carthage\Domain\LogManagement\Exception\Log\ConflictException;
use Carthage\Domain\LogManagement\Service\Log\LogService;
use Psr\EventDispatcher\EventDispatcherInterface;

final readonly class CreateLogCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private LogService $logService,
        private EventDispatcherInterface $eventDispatcher,
    ) {
    }

    /**
     * @throws ConflictException when the log already exists
     */
    public function __invoke(CreateLogCommand $command): void
    {
        $log = $this->logService->createLog($command->createLog);

        $this->eventDispatcher->dispatch(
            new LogCreatedEvent($log->getIdentity()),
        );
    }
}
