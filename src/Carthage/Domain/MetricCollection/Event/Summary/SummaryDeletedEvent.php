<?php

declare(strict_types=1);

namespace Carthage\Domain\MetricCollection\Event\Summary;

use Carthage\Domain\Shared\Entity\Identity;

final class SummaryDeletedEvent
{
    public function __construct(
        public Identity $summaryIdentity,
    ) {
    }
}
