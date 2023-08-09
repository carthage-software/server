<?php

declare(strict_types=1);

namespace Carthage\Application\MetricCollection\Command\Summary;

use Carthage\Application\Shared\Command\CommandInterface;
use Carthage\Domain\Shared\Entity\Identity;

final readonly class DeleteSummaryDataPointCommand implements CommandInterface
{
    public function __construct(
        public Identity $summaryDataPointIdentity,
    ) {
    }
}
