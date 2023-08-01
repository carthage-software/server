<?php

declare(strict_types=1);

namespace Carthage\Presentation\MetricCollection\Server\RequestHandler\Metric;

use Carthage\Application\MetricCollection\Query\Metric\GetMetricCollectionQuery;
use Carthage\Application\Shared\QueryBusInterface;
use Carthage\Domain\MetricCollection\Filter\Metric\MetricFilter;
use Carthage\Presentation\Shared\Server\RequestMapperInterface;
use Carthage\Presentation\Shared\Server\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final readonly class IndexMetricRequestHandler implements RequestHandlerInterface
{
    public function __construct(
        private RequestMapperInterface $requestMapper,
        private QueryBusInterface $queryBus,
        private ResponseFactoryInterface $responseFactory,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $metricFilter = $this->requestMapper->mapQueryString($request, MetricFilter::class) ?? new MetricFilter();

        $metricResources = $this->queryBus->ask(new GetMetricCollectionQuery($metricFilter));

        return $this->responseFactory->createResourceResponse($metricResources);
    }
}
