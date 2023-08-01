<?php

declare(strict_types=1);

namespace Carthage\Application\LogManagement\QueryHandler\Log;

use Carthage\Application\LogManagement\Query\Log\GetLogQuery;
use Carthage\Application\Shared\QueryHandler\QueryHandlerInterface;
use Carthage\Domain\LogManagement\Repository\Log\LogRepositoryInterface;
use Carthage\Domain\LogManagement\Resource\Log\LogResource;

final readonly class GetLogQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private LogRepositoryInterface $logRepository,
    ) {
    }

    public function __invoke(GetLogQuery $query): null|LogResource
    {
        $log = $this->logRepository->findOneMatching($query->criteria);
        if (null === $log) {
            return null;
        }

        return LogResource::fromLog($log);
    }
}
