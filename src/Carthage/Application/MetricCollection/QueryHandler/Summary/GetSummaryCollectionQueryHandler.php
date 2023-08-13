<?php

declare(strict_types=1);

namespace Carthage\Application\MetricCollection\QueryHandler\Summary;

use Carthage\Application\MetricCollection\Query\Summary\GetSummaryCollectionQuery;
use Carthage\Application\MetricCollection\Resource\Summary\SummaryResource;
use Carthage\Application\Shared\QueryHandler\QueryHandlerInterface;
use Carthage\Application\Shared\Resource\PaginatedCollectionResource;
use Carthage\Domain\MetricCollection\Repository\Summary\SummaryRepositoryInterface;

final readonly class GetSummaryCollectionQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private SummaryRepositoryInterface $summaryRepository,
    ) {
    }

    /**
     * @return PaginatedCollectionResource<SummaryResource>
     */
    public function __invoke(GetSummaryCollectionQuery $query): PaginatedCollectionResource
    {
        $summaryPage = $this->summaryRepository->paginate($query->summaryFilter);

        return PaginatedCollectionResource::fromPage($summaryPage, SummaryResource::fromSummary(...));
    }
}
