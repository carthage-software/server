<?php

declare(strict_types=1);

namespace Carthage\Application\MetricCollection\QueryHandler\Histogram;

use Carthage\Application\MetricCollection\Query\Histogram\GetHistogramQuery;
use Carthage\Application\Shared\QueryHandler\QueryHandlerInterface;
use Carthage\Domain\MetricCollection\Repository\Histogram\HistogramRepositoryInterface;
use Carthage\Domain\MetricCollection\Resource\Histogram\HistogramResource;

final readonly class GetHistogramQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private HistogramRepositoryInterface $histogramRepository,
    ) {
    }

    public function __invoke(GetHistogramQuery $query): ?HistogramResource
    {
        $histogram = $this->histogramRepository->findOneMatching($query->criteria);
        if (null === $histogram) {
            return null;
        }

        return HistogramResource::fromHistogram($histogram);
    }
}
