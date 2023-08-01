<?php

declare(strict_types=1);

namespace Carthage\Application\LogManagement\QueryHandler\Log;

use Carthage\Application\LogManagement\Query\Log\GetLogEntryCollectionQuery;
use Carthage\Application\Shared\QueryHandler\QueryHandlerInterface;
use Carthage\Domain\LogManagement\Repository\Log\LogEntryRepositoryInterface;
use Carthage\Domain\LogManagement\Resource\Log\LogEntryResource;
use Carthage\Domain\Shared\Resource\PaginatedCollectionResource;

final readonly class GetLogEntryCollectionQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private LogEntryRepositoryInterface $logEntryRepository,
    ) {
    }

    /**
     * @return PaginatedCollectionResource<LogEntryResource>
     */
    public function __invoke(GetLogEntryCollectionQuery $query): PaginatedCollectionResource
    {
        $logEntryPage = $this->logEntryRepository->paginate($query->logEntryFilter);

        return PaginatedCollectionResource::fromPage($logEntryPage, LogEntryResource::fromLogEntry(...));
    }
}
