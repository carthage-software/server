<?php

declare(strict_types=1);

namespace Carthage\Domain\LogManagement\Event\Log;

use Symfony\Component\Uid\Ulid;

final readonly class LogDeletedEvent
{
    public function __construct(
        public Ulid $logId,
    ) {
    }
}
