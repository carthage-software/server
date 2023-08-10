<?php

declare(strict_types=1);

namespace Carthage\Application\LogManagement\Query\Log\Statistic;

use Carthage\Application\LogManagement\Resource\Log\Statistic\LogFrequencyCountResource;
use Carthage\Application\Shared\Query\QueryInterface;
use Carthage\Application\Shared\Resource\CollectionResourceInterface;
use Carthage\Domain\LogManagement\Enum\Log\Statistics\Frequency;

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
