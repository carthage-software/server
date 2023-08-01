<?php

declare(strict_types=1);

namespace Carthage\Domain\LogManagement\Enum\Log;

/**
 * The SortingField enum represents the different fields that can be used for sorting logs.
 *
 * Each case corresponds to a different attribute of a log.
 */
enum SortingField: string
{
    /**
     * Represents the 'createdAt' field, which corresponds to the timestamp when the log was created.
     */
    case CreatedAt = 'createdAt';

    /**
     * Represents the 'updatedAt' field, which corresponds to the timestamp when the log was last updated.
     */
    case UpdatedAt = 'updatedAt';

    /**
     * Represents the 'firstEntryOccurredAt' field, which corresponds to the timestamp when the first log entry associated with the log occurred.
     */
    case firstEntryOccurredAt = 'firstEntryOccurredAt';

    /**
     * Represents the 'lastEntryOccurredAt' field, which corresponds to the timestamp when the last log entry associated with the log occurred.
     */
    case lastEntryOccurredAt = 'lastEntryOccurredAt';

    /**
     * Represents the 'level' field, which corresponds to the severity level of the message.
     */
    case Level = 'level';
}
