<?php

declare(strict_types=1);

namespace Carthage\Domain\LogManagement\Event\Log;

use Carthage\Domain\Shared\Entity\Identity;

final readonly class LogDeletedEvent
{
    public function __construct(
        public Identity $logIdentity,
    ) {
    }
}
