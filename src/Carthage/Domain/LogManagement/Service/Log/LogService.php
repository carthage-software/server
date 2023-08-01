<?php

declare(strict_types=1);

namespace Carthage\Domain\LogManagement\Service\Log;

use Carthage\Domain\LogManagement\DataTransferObject\Log\CreateLog;
use Carthage\Domain\LogManagement\Entity\Log\Log;
use Carthage\Domain\LogManagement\Exception\Log\ConflictException;
use Carthage\Domain\LogManagement\Exception\Log\NotFoundException;
use Carthage\Domain\LogManagement\Repository\Log\LogRepositoryInterface;
use Symfony\Component\Uid\Ulid;

/**
 * Service for log operations.
 */
final readonly class LogService
{
    public function __construct(
        private LogRepositoryInterface $logRepository,
    ) {
    }

    /**
     * @throws ConflictException when the log already exists
     */
    public function createLog(CreateLog $createLog): Log
    {
        $log = $this->logRepository->findByLevelAndTemplateInNamespace(
            $createLog->level,
            $createLog->template,
            $createLog->namespace,
        );

        if (null !== $log) {
            throw ConflictException::whenCreatingMessageThatAlreadyExists($log->getIdentity(), $createLog->namespace, $createLog->level, $createLog->template);
        }

        $log = new Log($createLog->namespace, $createLog->level, $createLog->template);

        $this->logRepository->persist($log);

        return $log;
    }

    /**
     * @throws NotFoundException when the log does not exist
     */
    public function deleteLog(Ulid $logId): void
    {
        $log = $this->logRepository->findOne($logId);
        if (null === $log) {
            throw NotFoundException::whenDeletingNonExistentLog($logId);
        }

        $this->logRepository->remove($log);
    }
}
