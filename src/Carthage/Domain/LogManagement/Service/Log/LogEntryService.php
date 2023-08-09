<?php

declare(strict_types=1);

namespace Carthage\Domain\LogManagement\Service\Log;

use Carthage\Domain\LogManagement\DataTransferObject\Log\CreateLogEntry;
use Carthage\Domain\LogManagement\Entity\Log\LogEntry;
use Carthage\Domain\LogManagement\Exception\Log\NotFoundException;
use Carthage\Domain\LogManagement\Repository\Log\LogEntryRepositoryInterface;
use Carthage\Domain\LogManagement\Repository\Log\LogRepositoryInterface;
use Carthage\Domain\Shared\Entity\Identity;

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
        $log = $this->logRepository->findOne($createRecord->logIdentity);
        if (null === $log) {
            throw NotFoundException::whenCreatingEntryForNonExistentLog($createRecord->logIdentity);
        }

        $logEntry = $log->addLogEntry($createRecord->source, $createRecord->context, $createRecord->attributes, $createRecord->tags, $createRecord->occurredAt);

        $this->logEntryRepository->persist($logEntry);

        return $logEntry;
    }

    /**
     * @throws NotFoundException when the log entry does not exist
     */
    public function deleteLogEntry(Identity $logEntryIdentity): void
    {
        $logEntry = $this->logEntryRepository->findOne($logEntryIdentity);
        if (null === $logEntry) {
            throw NotFoundException::whenDeletingNonExistentLogEntry($logEntryIdentity);
        }

        $this->logEntryRepository->remove($logEntry);
    }
}
