<?php

declare(strict_types=1);

namespace Carthage\Domain\LogManagement\Service\Log;

use Carthage\Domain\LogManagement\DataTransferObject\Log\CreateLogEntry;
use Carthage\Domain\LogManagement\Entity\Log\LogEntry;
use Carthage\Domain\LogManagement\Exception\Log\NotFoundException;
use Carthage\Domain\LogManagement\Repository\Log\LogEntryRepositoryInterface;
use Carthage\Domain\LogManagement\Repository\Log\LogRepositoryInterface;
use Symfony\Component\Uid\Ulid;

/**
 * Service for log entry operations.
 */
final readonly class LogEntryService
{
    public function __construct(
        private LogRepositoryInterface $logRepository,
        private LogEntryRepositoryInterface $logEntryRepository
    ) {
    }

    /**
     * @throws NotFoundException when either the log does not exist
     */
    public function createLogEntry(CreateLogEntry $createRecord): LogEntry
    {
        $log = $this->logRepository->findOne($createRecord->log);
        if (null === $log) {
            throw NotFoundException::whenCreatingEntryForNonExistentLog($createRecord->log);
        }

        $logEntry = $log->addLogEntry($createRecord->source, $createRecord->context, $createRecord->attributes, $createRecord->tags, $createRecord->occurredAt);

        $this->logEntryRepository->persist($logEntry);

        return $logEntry;
    }

    /**
     * @throws NotFoundException when the log entry does not exist
     */
    public function deleteLogEntry(Ulid $logEntryId): void
    {
        $logEntry = $this->logEntryRepository->findOne($logEntryId);
        if (null === $logEntry) {
            throw NotFoundException::whenDeletingNonExistentLogEntry($logEntryId);
        }

        $this->logEntryRepository->remove($logEntry);
    }
}
