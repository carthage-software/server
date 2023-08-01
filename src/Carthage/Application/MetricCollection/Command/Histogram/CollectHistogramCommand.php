<?php

declare(strict_types=1);

namespace Carthage\Application\MetricCollection\Command\Histogram;

use Carthage\Application\Shared\Command\CommandInterface;
use Carthage\Domain\MetricCollection\DataTransferObject\Histogram\CollectHistogram;

final readonly class CollectHistogramCommand implements CommandInterface
{
    public function __construct(
        public CollectHistogram $collectHistogram,
    ) {
    }
}
