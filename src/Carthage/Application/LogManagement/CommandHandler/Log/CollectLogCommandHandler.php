<?php

declare(strict_types=1);

namespace Carthage\Application\LogManagement\CommandHandler\Log;

use Carthage\Application\LogManagement\Command\Log\CollectLogCommand;
use Carthage\Application\LogManagement\Service\Log\LogCollector;
use Carthage\Application\Shared\CommandHandler\CommandHandlerInterface;

final readonly class CollectLogCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private LogCollector $logCollector,
    ) {
    }

    public function __invoke(CollectLogCommand $command): void
    {
        $this->logCollector->collectLog($command->collectLog);
    }
}
