<?php

declare(strict_types=1);

namespace Carthage\Presentation\MetricCollection\Server\RequestHandler\Histogram;

use Carthage\Application\MetricCollection\Query\Histogram\GetHistogramQuery;
use Carthage\Application\Shared\QueryBusInterface;
use Carthage\Domain\Shared\Entity\Identity;
use Carthage\Presentation\Shared\Server\HttpStatus;
use Carthage\Presentation\Shared\Server\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final readonly class ShowHistogramRequestHandler implements RequestHandlerInterface
{
    public function __construct(
        private QueryBusInterface $queryBus,
        private ResponseFactoryInterface $responseFactory,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        /** @var Identity $histogramIdentity */
        $histogramIdentity = $request->getAttribute('identity');

        $histogramResource = $this->queryBus->ask(GetHistogramQuery::withIdentity($histogramIdentity));
        if (null === $histogramResource) {
            return $this->responseFactory->createResponse(HttpStatus::NotFound);
        }

        return $this->responseFactory->createResourceResponse($histogramResource);
    }
}
