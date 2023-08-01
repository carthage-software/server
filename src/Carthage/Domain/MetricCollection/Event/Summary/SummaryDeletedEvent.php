<?php

declare(strict_types=1);

namespace Carthage\Domain\MetricCollection\Event\Summary;

use Symfony\Component\Uid\Ulid;

final class SummaryDeletedEvent
{
    public function __construct(
        public Ulid $summaryId,
    ) {
    }
}
