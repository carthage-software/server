<?php

declare(strict_types=1);

namespace Carthage\Presentation\MetricCollection\Server\RequestHandler\Histogram;

use Carthage\Application\MetricCollection\Command\Histogram\CreateHistogramDataPointCommand;
use Carthage\Application\MetricCollection\Query\Histogram\GetHistogramDataPointQuery;
use Carthage\Application\Shared\CommandBusInterface;
use Carthage\Application\Shared\QueryBusInterface;
use Carthage\Domain\MetricCollection\DataTransferObject\Histogram\CreateHistogramDataPoint;
use Carthage\Domain\MetricCollection\Resource\Histogram\HistogramDataPointResource;
use Carthage\Presentation\Shared\Server\HttpStatus;
use Carthage\Presentation\Shared\Server\RequestMapperInterface;
use Carthage\Presentation\Shared\Server\ResponseFactoryInterface;
use Psl\Type;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final readonly class CreateHistogramDataPointRequestHandler implements RequestHandlerInterface
{
    public function __construct(
        private RequestMapperInterface $requestMapper,
        private CommandBusInterface $commandBus,
        private QueryBusInterface $queryBus,
        private ResponseFactoryInterface $responseFactory,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $createHistogramDataPoint = $this->requestMapper->mapRequestPayload($request, CreateHistogramDataPoint::class);
        if (null === $createHistogramDataPoint) {
            return $this->responseFactory->createResponse(HttpStatus::BadRequest);
        }

        $this->commandBus->dispatch(new CreateHistogramDataPointCommand($createHistogramDataPoint));

        $histogramDataPointResource = Type\instance_of(HistogramDataPointResource::class)->assert(
            $this->queryBus->ask(GetHistogramDataPointQuery::mostRecentForHistogramFromSource(
                $createHistogramDataPoint->metricIdentity,
                $createHistogramDataPoint->source,
            )),
        );

        return $this->responseFactory->createResourceResponse($histogramDataPointResource, HttpStatus::Created);
    }
}
