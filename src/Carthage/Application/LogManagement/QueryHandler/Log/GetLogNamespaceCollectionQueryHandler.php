<?php

declare(strict_types=1);

namespace Carthage\Application\LogManagement\QueryHandler\Log;

use Carthage\Application\LogManagement\Query\Log\GetLogNamespaceCollectionQuery;
use Carthage\Application\Shared\QueryHandler\QueryHandlerInterface;
use Carthage\Domain\LogManagement\Repository\Log\LogRepositoryInterface;
use Carthage\Domain\LogManagement\Resource\Log\LogNamespaceResource;
use Carthage\Domain\Shared\Resource\CollectionResourceInterface;
use Carthage\Domain\Shared\Resource\SimpleCollectionResource;

final readonly class GetLogNamespaceCollectionQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private LogRepositoryInterface $logRepository,
    ) {
    }

    /**
     * @return CollectionResourceInterface<LogNamespaceResource>
     */
    public function __invoke(GetLogNamespaceCollectionQuery $query): CollectionResourceInterface
    {
        $namespaces = $this->logRepository->findAllNamespaces();

        return SimpleCollectionResource::fromItems($namespaces, LogNamespaceResource::fromNamespace(...));
    }
}
