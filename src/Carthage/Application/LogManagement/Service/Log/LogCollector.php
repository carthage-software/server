<?php

declare(strict_types=1);

namespace Carthage\Application\LogManagement\Service\Log;

use Carthage\Application\LogManagement\Command\Log\CreateLogEntryCommand;
use Carthage\Application\Shared\CommandBusInterface;
use Carthage\Domain\LogManagement\DataTransferObject\Log\CollectLog;
use Carthage\Domain\LogManagement\Event\Log\LogCreatedEvent;
use Carthage\Domain\LogManagement\Repository\Log\LogRepositoryInterface;
use Carthage\Domain\LogManagement\Service\Log\LogService;
use Psr\EventDispatcher\EventDispatcherInterface;

final readonly class LogCollector
{
    public function __construct(
        private LogService $logService,
        private LogRepositoryInterface $logRepository,
        private EventDispatcherInterface $eventDispatcher,
        private CommandBusInterface $commandBus,
    ) {
    }

    public function collectLog(CollectLog $collectLog): void
    {
        $log = $this->logRepository->findByLevelAndTemplateInNamespace(
            $collectLog->log->level,
            $collectLog->log->template,
            $collectLog->log->namespace,
        );

        if (null === $log) {
            $log = $this->logService->createLog($collectLog->log);

            $this->eventDispatcher->dispatch(new LogCreatedEvent($log->getIdentity()));
        }

        foreach ($collectLog->entries as $entry) {
            $this->commandBus->dispatch(
                new CreateLogEntryCommand($entry->toCreateLogEntry($log)),
            );
        }
    }
}
