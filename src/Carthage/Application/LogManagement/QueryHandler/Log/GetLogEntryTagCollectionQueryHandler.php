<?php

declare(strict_types=1);

namespace Carthage\Application\LogManagement\QueryHandler\Log;

use Carthage\Application\LogManagement\Query\Log\GetLogEntryTagCollectionQuery;
use Carthage\Application\Shared\QueryHandler\QueryHandlerInterface;
use Carthage\Domain\LogManagement\Repository\Log\LogEntryRepositoryInterface;
use Carthage\Domain\LogManagement\Resource\Log\LogEntryTagResource;
use Carthage\Domain\Shared\Resource\CollectionResourceInterface;
use Carthage\Domain\Shared\Resource\SimpleCollectionResource;

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
