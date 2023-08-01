<?php

declare(strict_types=1);

namespace Carthage\Application\MetricCollection\Command;

use Carthage\Application\Shared\Command\CommandInterface;
use Carthage\Domain\MetricCollection\DataTransferObject\Collect;

final readonly class CollectCommand implements CommandInterface
{
    public function __construct(
        public Collect $collect,
    ) {
    }
}
