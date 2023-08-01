<?php

declare(strict_types=1);

namespace Carthage\Application\MetricCollection\QueryHandler\Summary;

use Carthage\Application\MetricCollection\Query\Summary\GetSummaryCollectionQuery;
use Carthage\Application\Shared\QueryHandler\QueryHandlerInterface;
use Carthage\Domain\MetricCollection\Repository\Summary\SummaryRepositoryInterface;
use Carthage\Domain\MetricCollection\Resource\Summary\SummaryResource;
use Carthage\Domain\Shared\Resource\CollectionResourceInterface;
use Carthage\Domain\Shared\Resource\PaginatedCollectionResource;

final readonly class GetSummaryCollectionQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private SummaryRepositoryInterface $summaryRepository,
    ) {
    }

    /**
     * @return CollectionResourceInterface<SummaryResource>
     */
    public function __invoke(GetSummaryCollectionQuery $query): CollectionResourceInterface
    {
        $summaryPage = $this->summaryRepository->paginate($query->summaryFilter);

        return PaginatedCollectionResource::fromPage($summaryPage, SummaryResource::fromSummary(...));
    }
}
