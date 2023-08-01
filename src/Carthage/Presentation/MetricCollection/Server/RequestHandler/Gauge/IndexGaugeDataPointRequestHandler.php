<?php

declare(strict_types=1);

namespace Carthage\Presentation\MetricCollection\Server\RequestHandler\Gauge;

use Carthage\Application\MetricCollection\Query\Gauge\GetGaugeDataPointCollectionQuery;
use Carthage\Application\Shared\QueryBusInterface;
use Carthage\Domain\MetricCollection\Filter\Gauge\GaugeDataPointFilter;
use Carthage\Presentation\Shared\Server\RequestMapperInterface;
use Carthage\Presentation\Shared\Server\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final readonly class IndexGaugeDataPointRequestHandler implements RequestHandlerInterface
{
    public function __construct(
        private RequestMapperInterface $requestMapper,
        private QueryBusInterface $queryBus,
        private ResponseFactoryInterface $responseFactory,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $filter = $this->requestMapper->mapQueryString($request, GaugeDataPointFilter::class) ?? new GaugeDataPointFilter();

        $gaugeDataPointResources = $this->queryBus->ask(new GetGaugeDataPointCollectionQuery($filter));

        return $this->responseFactory->createResourceResponse($gaugeDataPointResources);
    }
}
