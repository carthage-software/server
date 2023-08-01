<?php

declare(strict_types=1);

namespace Carthage\Application\LogManagement\CommandHandler;

use Carthage\Application\LogManagement\Command\CollectCommand;
use Carthage\Application\LogManagement\Service\Log\LogCollector;
use Carthage\Application\Shared\CommandHandler\CommandHandlerInterface;

final readonly class CollectCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private LogCollector $logCollector,
    ) {
    }

    public function __invoke(CollectCommand $command): void
    {
        foreach ($command->collect->collectLogs as $collectLog) {
            $this->logCollector->collectLog($collectLog);
        }
    }
}
