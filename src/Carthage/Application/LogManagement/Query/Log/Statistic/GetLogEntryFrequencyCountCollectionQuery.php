<?php

declare(strict_types=1);

namespace Carthage\Application\LogManagement\Query\Log\Statistic;

use Carthage\Application\Shared\Query\QueryInterface;
use Carthage\Domain\LogManagement\Enum\Log\Statistics\Frequency;
use Carthage\Domain\LogManagement\Resource\Log\Statistic\LogEntryFrequencyCountResource;
use Carthage\Domain\Shared\Resource\CollectionResourceInterface;

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
