<?php

declare(strict_types=1);

namespace Carthage\Application\LogManagement\QueryHandler\Log;

use Carthage\Application\LogManagement\Query\Log\GetLogNamespaceCollectionQuery;
use Carthage\Application\LogManagement\Resource\Log\LogNamespaceResource;
use Carthage\Application\Shared\QueryHandler\QueryHandlerInterface;
use Carthage\Application\Shared\Resource\CollectionResource;
use Carthage\Domain\LogManagement\Repository\Log\LogRepositoryInterface;

final readonly class GetLogNamespaceCollectionQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private LogRepositoryInterface $logRepository,
    ) {
    }

    /**
     * @return CollectionResource<LogNamespaceResource>
     */
    public function __invoke(GetLogNamespaceCollectionQuery $query): CollectionResource
    {
        $namespaces = $this->logRepository->getUniqueNamespacesFromLogs();

        return CollectionResource::fromItems($namespaces, LogNamespaceResource::fromNamespace(...));
    }
}
