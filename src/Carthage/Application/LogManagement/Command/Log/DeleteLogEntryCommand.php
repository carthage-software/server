<?php

declare(strict_types=1);

namespace Carthage\Application\LogManagement\Command\Log;

use Carthage\Application\Shared\Command\CommandInterface;
use Symfony\Component\Uid\Ulid;

final readonly class DeleteLogEntryCommand implements CommandInterface
{
    public function __construct(
        public Ulid $logEntryId,
    ) {
    }
}
