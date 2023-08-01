<?php

declare(strict_types=1);

namespace Carthage\Application\MetricCollection\Command\Histogram;

use Carthage\Application\Shared\Command\CommandInterface;
use Carthage\Domain\MetricCollection\DataTransferObject\Histogram\CreateHistogram;

final readonly class CreateHistogramCommand implements CommandInterface
{
    public function __construct(
        public CreateHistogram $createHistogram,
    ) {
    }
}
