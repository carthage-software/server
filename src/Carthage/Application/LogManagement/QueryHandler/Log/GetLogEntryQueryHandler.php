<?php

declare(strict_types=1);

namespace Carthage\Application\LogManagement\QueryHandler\Log;

use Carthage\Application\LogManagement\Query\Log\GetLogEntryQuery;
use Carthage\Application\LogManagement\Resource\Log\LogEntryResource;
use Carthage\Application\Shared\QueryHandler\QueryHandlerInterface;
use Carthage\Domain\LogManagement\Repository\Log\LogEntryRepositoryInterface;

final readonly class GetLogEntryQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private LogEntryRepositoryInterface $logEntryRepository,
    ) {
    }

    public function __invoke(GetLogEntryQuery $query): null|LogEntryResource
    {
        $logEntry = $this->logEntryRepository->findOneMatching($query->criteria);
        if (null === $logEntry) {
            return null;
        }

        return LogEntryResource::fromLogEntry($logEntry);
    }
}
