<?php

declare(strict_types=1);

namespace Carthage\Application\MetricCollection\QueryHandler\Gauge;

use Carthage\Application\MetricCollection\Query\Gauge\GetGaugeDataPointCollectionQuery;
use Carthage\Application\Shared\QueryHandler\QueryHandlerInterface;
use Carthage\Domain\MetricCollection\Repository\Gauge\GaugeDataPointRepositoryInterface;
use Carthage\Domain\MetricCollection\Resource\Gauge\GaugeDataPointResource;
use Carthage\Domain\Shared\Resource\CollectionResourceInterface;
use Carthage\Domain\Shared\Resource\PaginatedCollectionResource;

final readonly class GetGaugeDataPointCollectionQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private GaugeDataPointRepositoryInterface $gaugeDataPointRepository,
    ) {
    }

    /**
     * @return CollectionResourceInterface<GaugeDataPointResource>
     */
    public function __invoke(GetGaugeDataPointCollectionQuery $query): CollectionResourceInterface
    {
        $gaugeDataPointPage = $this->gaugeDataPointRepository->paginate($query->gaugeDataPointFilter);

        return PaginatedCollectionResource::fromPage($gaugeDataPointPage, GaugeDataPointResource::fromGaugeDataPoint(...));
    }
}
