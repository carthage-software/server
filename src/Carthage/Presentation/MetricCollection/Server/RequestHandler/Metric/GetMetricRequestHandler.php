<?php

declare(strict_types=1);

namespace Carthage\Presentation\MetricCollection\Server\RequestHandler\Metric;

use Carthage\Application\MetricCollection\Query\Metric\GetMetricQuery;
use Carthage\Application\Shared\QueryBusInterface;
use Carthage\Domain\Shared\Entity\Identity;
use Carthage\Presentation\Shared\Server\HttpStatus;
use Carthage\Presentation\Shared\Server\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final readonly class GetMetricRequestHandler implements RequestHandlerInterface
{
    public function __construct(
        private QueryBusInterface $queryBus,
        private ResponseFactoryInterface $responseFactory,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        /** @var Identity $metricIdentity */
        $metricIdentity = $request->getAttribute('identity');

        $metricResource = $this->queryBus->ask(GetMetricQuery::withIdentity($metricIdentity));
        if (null === $metricResource) {
            return $this->responseFactory->createResponse(HttpStatus::NotFound);
        }

        return $this->responseFactory->createResourceResponse($metricResource);
    }
}
