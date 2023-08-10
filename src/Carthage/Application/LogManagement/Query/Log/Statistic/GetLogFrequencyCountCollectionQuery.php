<?php

declare(strict_types=1);

namespace Carthage\Application\LogManagement\Query\Log\Statistic;

use Carthage\Application\Shared\Query\QueryInterface;
use Carthage\Domain\LogManagement\Enum\Log\Statistics\Frequency;
use Carthage\Domain\LogManagement\Resource\Log\Statistic\LogFrequencyCountResource;
use Carthage\Domain\Shared\Resource\CollectionResourceInterface;

/**
 * @implements QueryInterface<CollectionResourceInterface<LogFrequencyCountResource>>
 */
final readonly class GetLogFrequencyCountCollectionQuery implements QueryInterface
{
    public function __construct(
        public Frequency $frequency,
    ) {
    }
}
