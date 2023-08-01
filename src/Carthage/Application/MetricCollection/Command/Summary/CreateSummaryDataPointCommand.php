<?php

declare(strict_types=1);

namespace Carthage\Application\MetricCollection\Command\Summary;

use Carthage\Application\Shared\Command\CommandInterface;
use Carthage\Domain\MetricCollection\DataTransferObject\Summary\CreateSummaryDataPoint;

final readonly class CreateSummaryDataPointCommand implements CommandInterface
{
    public function __construct(
        public CreateSummaryDataPoint $createSumDataPoint,
    ) {
    }
}
