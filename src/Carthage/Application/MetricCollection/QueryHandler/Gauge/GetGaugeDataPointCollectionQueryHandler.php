<?php

declare(strict_types=1);

namespace Carthage\Application\MetricCollection\QueryHandler\Gauge;

use Carthage\Application\MetricCollection\Query\Gauge\GetGaugeDataPointCollectionQuery;
use Carthage\Application\MetricCollection\Resource\Gauge\GaugeDataPointResource;
use Carthage\Application\Shared\QueryHandler\QueryHandlerInterface;
use Carthage\Application\Shared\Resource\PaginatedCollectionResource;
use Carthage\Domain\MetricCollection\Repository\Gauge\GaugeDataPointRepositoryInterface;

final readonly class GetGaugeDataPointCollectionQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private GaugeDataPointRepositoryInterface $gaugeDataPointRepository,
    ) {
    }

    /**
     * @return PaginatedCollectionResource<GaugeDataPointResource>
     */
    public function __invoke(GetGaugeDataPointCollectionQuery $query): PaginatedCollectionResource
    {
        $gaugeDataPointPage = $this->gaugeDataPointRepository->paginate($query->gaugeDataPointFilter);

        return PaginatedCollectionResource::fromPage($gaugeDataPointPage, GaugeDataPointResource::fromGaugeDataPoint(...));
    }
}
