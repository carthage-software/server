<?php

declare(strict_types=1);

namespace Carthage\Application\LogManagement\QueryHandler\Log;

use Carthage\Application\LogManagement\Query\Log\GetLogEntryTagCollectionQuery;
use Carthage\Application\LogManagement\Resource\Log\LogEntryTagResource;
use Carthage\Application\Shared\QueryHandler\QueryHandlerInterface;
use Carthage\Application\Shared\Resource\CollectionResourceInterface;
use Carthage\Application\Shared\Resource\SimpleCollectionResource;
use Carthage\Domain\LogManagement\Repository\Log\LogEntryRepositoryInterface;

final readonly class GetLogEntryTagCollectionQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private LogEntryRepositoryInterface $logEntryRepository,
    ) {
    }

    /**
     * @return CollectionResourceInterface<LogEntryTagResource>
     */
    public function __invoke(GetLogEntryTagCollectionQuery $query): CollectionResourceInterface
    {
        $tags = $this->logEntryRepository->getUniqueTagsFromLogEntries();

        return SimpleCollectionResource::fromItems($tags, LogEntryTagResource::fromTag(...));
    }
}
