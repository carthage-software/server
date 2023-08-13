<?php

declare(strict_types=1);

namespace Carthage\Application\LogManagement\QueryHandler\Log;

use Carthage\Application\LogManagement\Query\Log\GetLogEntrySourceCollectionQuery;
use Carthage\Application\LogManagement\Resource\Log\LogEntrySourceResource;
use Carthage\Application\Shared\QueryHandler\QueryHandlerInterface;
use Carthage\Application\Shared\Resource\CollectionResource;
use Carthage\Domain\LogManagement\Repository\Log\LogEntryRepositoryInterface;

final readonly class GetLogEntrySourceCollectionQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private LogEntryRepositoryInterface $logEntryRepository,
    ) {
    }

    /**
     * @return CollectionResource<LogEntrySourceResource>
     */
    public function __invoke(GetLogEntrySourceCollectionQuery $query): CollectionResource
    {
        $sources = $this->logEntryRepository->getUniqueSourcesFromLogEntries();

        return CollectionResource::fromItems($sources, LogEntrySourceResource::fromSource(...));
    }
}
