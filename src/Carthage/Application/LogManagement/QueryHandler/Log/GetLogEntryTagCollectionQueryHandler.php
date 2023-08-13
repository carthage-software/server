<?php

declare(strict_types=1);

namespace Carthage\Application\LogManagement\QueryHandler\Log;

use Carthage\Application\LogManagement\Query\Log\GetLogEntryTagCollectionQuery;
use Carthage\Application\LogManagement\Resource\Log\LogEntryTagResource;
use Carthage\Application\Shared\QueryHandler\QueryHandlerInterface;
use Carthage\Application\Shared\Resource\CollectionResource;
use Carthage\Domain\LogManagement\Repository\Log\LogEntryRepositoryInterface;

final readonly class GetLogEntryTagCollectionQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private LogEntryRepositoryInterface $logEntryRepository,
    ) {
    }

    /**
     * @return CollectionResource<LogEntryTagResource>
     */
    public function __invoke(GetLogEntryTagCollectionQuery $query): CollectionResource
    {
        $tags = $this->logEntryRepository->getUniqueTagsFromLogEntries();

        return CollectionResource::fromItems($tags, LogEntryTagResource::fromTag(...));
    }
}
