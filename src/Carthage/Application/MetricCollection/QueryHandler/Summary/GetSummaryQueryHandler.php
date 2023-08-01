<?php

declare(strict_types=1);

namespace Carthage\Application\MetricCollection\QueryHandler\Summary;

use Carthage\Application\MetricCollection\Query\Summary\GetSummaryQuery;
use Carthage\Application\Shared\QueryHandler\QueryHandlerInterface;
use Carthage\Domain\MetricCollection\Repository\Summary\SummaryRepositoryInterface;
use Carthage\Domain\MetricCollection\Resource\Summary\SummaryResource;

final readonly class GetSummaryQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private SummaryRepositoryInterface $summaryRepository,
    ) {
    }

    public function __invoke(GetSummaryQuery $query): ?SummaryResource
    {
        $summary = $this->summaryRepository->findOneMatching($query->criteria);
        if (null === $summary) {
            return null;
        }

        return SummaryResource::fromSummary($summary);
    }
}
