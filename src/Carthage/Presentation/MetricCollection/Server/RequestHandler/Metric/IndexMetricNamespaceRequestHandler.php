<?php

declare(strict_types=1);

namespace Carthage\Presentation\MetricCollection\Server\RequestHandler\Metric;

use Carthage\Application\MetricCollection\Query\Metric\GetMetricNamespaceCollectionQuery;
use Carthage\Application\Shared\QueryBusInterface;
use Carthage\Presentation\Shared\Server\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final readonly class IndexMetricNamespaceRequestHandler implements RequestHandlerInterface
{
    public function __construct(
        private QueryBusInterface $queryBus,
        private ResponseFactoryInterface $responseFactory,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $metricNamespaceCollectionResource = $this->queryBus->ask(new GetMetricNamespaceCollectionQuery());

        return $this->responseFactory->createResourceResponse($metricNamespaceCollectionResource);
    }
}
