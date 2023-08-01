<?php

declare(strict_types=1);

namespace Carthage\Presentation\MetricCollection\Server\RequestHandler\Summary;

use Carthage\Application\MetricCollection\Query\Summary\GetSummaryDataPointCollectionQuery;
use Carthage\Application\Shared\QueryBusInterface;
use Carthage\Domain\MetricCollection\Filter\Summary\SummaryDataPointFilter;
use Carthage\Presentation\Shared\Server\RequestMapperInterface;
use Carthage\Presentation\Shared\Server\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final readonly class IndexSummaryDataPointRequestHandler implements RequestHandlerInterface
{
    public function __construct(
        private RequestMapperInterface $requestMapper,
        private QueryBusInterface $queryBus,
        private ResponseFactoryInterface $responseFactory,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $filter = $this->requestMapper->mapQueryString($request, SummaryDataPointFilter::class) ?? new SummaryDataPointFilter();

        $summaryDataPointResources = $this->queryBus->ask(new GetSummaryDataPointCollectionQuery($filter));

        return $this->responseFactory->createResourceResponse($summaryDataPointResources);
    }
}
