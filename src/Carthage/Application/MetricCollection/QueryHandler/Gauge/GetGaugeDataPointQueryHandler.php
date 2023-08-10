<?php

declare(strict_types=1);

namespace Carthage\Application\MetricCollection\QueryHandler\Gauge;

use Carthage\Application\MetricCollection\Query\Gauge\GetGaugeDataPointQuery;
use Carthage\Application\MetricCollection\Resource\Gauge\GaugeDataPointResource;
use Carthage\Application\Shared\QueryHandler\QueryHandlerInterface;
use Carthage\Domain\MetricCollection\Repository\Gauge\GaugeDataPointRepositoryInterface;

final readonly class GetGaugeDataPointQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private GaugeDataPointRepositoryInterface $gaugeDataPointRepository,
    ) {
    }

    public function __invoke(GetGaugeDataPointQuery $query): ?GaugeDataPointResource
    {
        $gaugeDataPoint = $this->gaugeDataPointRepository->findOneMatching($query->criteria);
        if (null === $gaugeDataPoint) {
            return null;
        }

        return GaugeDataPointResource::fromGaugeDataPoint($gaugeDataPoint);
    }
}
