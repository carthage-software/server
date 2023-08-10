<?php

declare(strict_types=1);

namespace Carthage\Application\MetricCollection\QueryHandler\Histogram;

use Carthage\Application\MetricCollection\Query\Histogram\GetHistogramDataPointQuery;
use Carthage\Application\MetricCollection\Resource\Histogram\HistogramDataPointResource;
use Carthage\Application\Shared\QueryHandler\QueryHandlerInterface;
use Carthage\Domain\MetricCollection\Repository\Histogram\HistogramDataPointRepositoryInterface;

final readonly class GetHistogramDataPointQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private HistogramDataPointRepositoryInterface $histogramDataPointRepository,
    ) {
    }

    public function __invoke(GetHistogramDataPointQuery $query): ?HistogramDataPointResource
    {
        $histogramDataPoint = $this->histogramDataPointRepository->findOneMatching($query->criteria);
        if (null === $histogramDataPoint) {
            return null;
        }

        return HistogramDataPointResource::fromHistogramDataPoint($histogramDataPoint);
    }
}
