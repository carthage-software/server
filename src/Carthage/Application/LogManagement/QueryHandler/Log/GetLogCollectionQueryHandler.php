<?php

declare(strict_types=1);

namespace Carthage\Application\LogManagement\QueryHandler\Log;

use Carthage\Application\LogManagement\Query\Log\GetLogCollectionQuery;
use Carthage\Application\LogManagement\Resource\Log\LogResource;
use Carthage\Application\Shared\QueryHandler\QueryHandlerInterface;
use Carthage\Application\Shared\Resource\PaginatedCollectionResource;
use Carthage\Domain\LogManagement\Repository\Log\LogRepositoryInterface;

final readonly class GetLogCollectionQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private LogRepositoryInterface $logRepository,
    ) {
    }

    /**
     * @return PaginatedCollectionResource<LogResource>
     */
    public function __invoke(GetLogCollectionQuery $query): PaginatedCollectionResource
    {
        $logPage = $this->logRepository->paginate($query->filter);

        return PaginatedCollectionResource::fromPage($logPage, LogResource::fromLog(...));
    }
}
