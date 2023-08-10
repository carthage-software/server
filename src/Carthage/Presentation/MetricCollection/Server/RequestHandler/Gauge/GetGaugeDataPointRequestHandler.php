<?php

declare(strict_types=1);

namespace Carthage\Presentation\MetricCollection\Server\RequestHandler\Gauge;

use Carthage\Application\MetricCollection\Query\Gauge\GetGaugeDataPointQuery;
use Carthage\Application\Shared\QueryBusInterface;
use Carthage\Domain\Shared\Entity\Identity;
use Carthage\Presentation\Shared\Server\HttpStatus;
use Carthage\Presentation\Shared\Server\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final readonly class GetGaugeDataPointRequestHandler implements RequestHandlerInterface
{
    public function __construct(
        private QueryBusInterface $queryBus,
        private ResponseFactoryInterface $responseFactory,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        /** @var Identity $gaugeDataPointIdentity */
        $gaugeDataPointIdentity = $request->getAttribute('identity');

        $gaugeDataPointResource = $this->queryBus->ask(GetGaugeDataPointQuery::withIdentity($gaugeDataPointIdentity));
        if (null === $gaugeDataPointResource) {
            return $this->responseFactory->createResponse(HttpStatus::NotFound);
        }

        return $this->responseFactory->createResourceResponse($gaugeDataPointResource);
    }
}
