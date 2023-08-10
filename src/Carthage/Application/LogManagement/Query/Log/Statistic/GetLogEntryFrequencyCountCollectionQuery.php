<?php

declare(strict_types=1);

namespace Carthage\Application\LogManagement\Query\Log\Statistic;

use Carthage\Application\LogManagement\Resource\Log\Statistic\LogEntryFrequencyCountResource;
use Carthage\Application\Shared\Query\QueryInterface;
use Carthage\Application\Shared\Resource\CollectionResourceInterface;
use Carthage\Domain\LogManagement\Enum\Log\Statistics\Frequency;

/**
 * @implements QueryInterface<CollectionResourceInterface<LogEntryFrequencyCountResource>>
 */
final readonly class GetLogEntryFrequencyCountCollectionQuery implements QueryInterface
{
    public function __construct(
        public Frequency $frequency,
    ) {
    }
}
