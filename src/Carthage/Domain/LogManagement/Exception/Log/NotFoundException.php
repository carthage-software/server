<?php

declare(strict_types=1);

namespace Carthage\Domain\LogManagement\Exception\Log;

use Carthage\Domain\Shared\Exception\ExceptionInterface;
use DomainException;
use Psl\Str;
use Symfony\Component\Uid\Ulid;

final class NotFoundException extends DomainException implements ExceptionInterface
{
    private const DELETE_LOG_NOT_FOUND_MESSAGE = 'Unable to delete non-existent log "%s".';
    private const CREATE_LOG_ENTRY_FOR_LOG_NOT_FOUND_MESSAGE = 'Unable to create an entry for non-existent log "%s".';
    private const DELETE_LOG_ENTRY_NOT_FOUND_MESSAGE = 'Unable to delete non-existent log entry "%s".';

    private function __construct(string $message)
    {
        parent::__construct($message);
    }

    /**
     * Creates a new NotFoundException for the case when attempting to delete a non-existent log.
     *
     * @param Ulid $logId the identifier of the log
     */
    public static function whenDeletingNonExistentLog(Ulid $logId): self
    {
        return new self(Str\format(self::DELETE_LOG_NOT_FOUND_MESSAGE, $logId->toBase32()));
    }

    /**
     * Creates a new NotFoundException for the case when attempting to create an entry for a non-existent log.
     *
     * @param Ulid $logId the identifier of the log
     */
    public static function whenCreatingEntryForNonExistentLog(Ulid $logId): self
    {
        return new self(Str\format(self::CREATE_LOG_ENTRY_FOR_LOG_NOT_FOUND_MESSAGE, $logId->toBase32()));
    }

    /**
     * Creates a new NotFoundException for the case when attempting to delete a non-existent log entry.
     *
     * @param Ulid $logEntryId the identifier of the log entry
     */
    public static function whenDeletingNonExistentLogEntry(Ulid $logEntryId): self
    {
        return new self(Str\format(self::DELETE_LOG_ENTRY_NOT_FOUND_MESSAGE, $logEntryId->toBase32()));
    }
}
