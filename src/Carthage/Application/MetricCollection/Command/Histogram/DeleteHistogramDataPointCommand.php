<?php

declare(strict_types=1);

namespace Carthage\Application\MetricCollection\Command\Histogram;

use Carthage\Application\Shared\Command\CommandInterface;
use Symfony\Component\Uid\Ulid;

final readonly class DeleteHistogramDataPointCommand implements CommandInterface
{
    public function __construct(
        public Ulid $histogramDataPointId,
    ) {
    }
}
