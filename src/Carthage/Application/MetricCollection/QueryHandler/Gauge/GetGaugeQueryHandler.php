<?php

declare(strict_types=1);

namespace Carthage\Application\MetricCollection\QueryHandler\Gauge;

use Carthage\Application\MetricCollection\Query\Gauge\GetGaugeQuery;
use Carthage\Application\MetricCollection\Resource\Gauge\GaugeResource;
use Carthage\Application\Shared\QueryHandler\QueryHandlerInterface;
use Carthage\Domain\MetricCollection\Repository\Gauge\GaugeRepositoryInterface;

final readonly class GetGaugeQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private GaugeRepositoryInterface $gaugeRepository,
    ) {
    }

    public function __invoke(GetGaugeQuery $query): ?GaugeResource
    {
        $gauge = $this->gaugeRepository->findOneMatching($query->criteria);
        if (null === $gauge) {
            return null;
        }

        return GaugeResource::fromGauge($gauge);
    }
}
