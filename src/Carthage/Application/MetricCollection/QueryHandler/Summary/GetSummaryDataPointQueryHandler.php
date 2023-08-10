<?php

declare(strict_types=1);

namespace Carthage\Application\MetricCollection\QueryHandler\Summary;

use Carthage\Application\MetricCollection\Query\Summary\GetSummaryDataPointQuery;
use Carthage\Application\MetricCollection\Resource\Summary\SummaryDataPointResource;
use Carthage\Application\Shared\QueryHandler\QueryHandlerInterface;
use Carthage\Domain\MetricCollection\Repository\Summary\SummaryDataPointRepositoryInterface;

final readonly class GetSummaryDataPointQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private SummaryDataPointRepositoryInterface $summaryDataPointRepository,
    ) {
    }

    public function __invoke(GetSummaryDataPointQuery $query): ?SummaryDataPointResource
    {
        $summaryDataPoint = $this->summaryDataPointRepository->findOneMatching($query->criteria);
        if (null === $summaryDataPoint) {
            return null;
        }

        return SummaryDataPointResource::fromSummaryDataPoint($summaryDataPoint);
    }
}
