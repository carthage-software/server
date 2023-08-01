<?php

declare(strict_types=1);

namespace Carthage\Application\MetricCollection\Command\Summary;

use Carthage\Application\Shared\Command\CommandInterface;
use Carthage\Domain\MetricCollection\DataTransferObject\Summary\CollectSummary;

final readonly class CollectSummaryCommand implements CommandInterface
{
    public function __construct(
        public CollectSummary $collectSummary,
    ) {
    }
}
