<?php

declare(strict_types=1);

namespace Carthage\Presentation\MetricCollection\Server\RequestHandler\Histogram;

use Carthage\Application\MetricCollection\Query\Histogram\GetHistogramCollectionQuery;
use Carthage\Application\Shared\QueryBusInterface;
use Carthage\Domain\MetricCollection\Filter\Histogram\HistogramFilter;
use Carthage\Presentation\Shared\Server\RequestMapperInterface;
use Carthage\Presentation\Shared\Server\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final readonly class IndexHistogramRequestHandler implements RequestHandlerInterface
{
    public function __construct(
        private RequestMapperInterface $requestMapper,
        private QueryBusInterface $queryBus,
        private ResponseFactoryInterface $responseFactory,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $filter = $this->requestMapper->mapQueryString($request, HistogramFilter::class) ?? new HistogramFilter();

        $histogramResources = $this->queryBus->ask(new GetHistogramCollectionQuery($filter));

        return $this->responseFactory->createResourceResponse($histogramResources);
    }
}
