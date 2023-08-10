<?php

declare(strict_types=1);

namespace Carthage\Application\MetricCollection\QueryHandler\Gauge;

use Carthage\Application\MetricCollection\Query\Gauge\GetGaugeCollectionQuery;
use Carthage\Application\MetricCollection\Resource\Gauge\GaugeResource;
use Carthage\Application\Shared\QueryHandler\QueryHandlerInterface;
use Carthage\Application\Shared\Resource\CollectionResourceInterface;
use Carthage\Application\Shared\Resource\PaginatedCollectionResource;
use Carthage\Domain\MetricCollection\Repository\Gauge\GaugeRepositoryInterface;

final readonly class GetGaugeCollectionQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private GaugeRepositoryInterface $gaugeRepository,
    ) {
    }

    /**
     * @return CollectionResourceInterface<GaugeResource>
     */
    public function __invoke(GetGaugeCollectionQuery $query): CollectionResourceInterface
    {
        $gaugePage = $this->gaugeRepository->paginate($query->gaugeFilter);

        return PaginatedCollectionResource::fromPage($gaugePage, GaugeResource::fromGauge(...));
    }
}
