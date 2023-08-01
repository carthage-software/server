<?php

declare(strict_types=1);

namespace Carthage\Application\LogManagement\Command\Log;

use Carthage\Application\Shared\Command\CommandInterface;
use Carthage\Domain\LogManagement\DataTransferObject\Log\CreateLogEntry;

final readonly class CreateLogEntryCommand implements CommandInterface
{
    public function __construct(
        public CreateLogEntry $createLogEntry
    ) {
    }
}
