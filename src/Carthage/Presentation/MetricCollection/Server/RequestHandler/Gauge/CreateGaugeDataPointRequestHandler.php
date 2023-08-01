<?php

declare(strict_types=1);

namespace Carthage\Presentation\MetricCollection\Server\RequestHandler\Gauge;

use Carthage\Application\MetricCollection\Command\Gauge\CreateGaugeDataPointCommand;
use Carthage\Application\MetricCollection\Query\Gauge\GetGaugeDataPointQuery;
use Carthage\Application\Shared\CommandBusInterface;
use Carthage\Application\Shared\QueryBusInterface;
use Carthage\Domain\MetricCollection\DataTransferObject\Gauge\CreateGaugeDataPoint;
use Carthage\Domain\MetricCollection\Resource\Gauge\GaugeDataPointResource;
use Carthage\Presentation\Shared\Server\HttpStatus;
use Carthage\Presentation\Shared\Server\RequestMapperInterface;
use Carthage\Presentation\Shared\Server\ResponseFactoryInterface;
use Psl\Type;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final readonly class CreateGaugeDataPointRequestHandler implements RequestHandlerInterface
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
        $createGaugeDataPoint = $this->requestMapper->mapRequestPayload($request, CreateGaugeDataPoint::class);
        if (null === $createGaugeDataPoint) {
            return $this->responseFactory->createResponse(HttpStatus::BadRequest);
        }

        $this->commandBus->dispatch(new CreateGaugeDataPointCommand($createGaugeDataPoint));

        $gaugeDataPointResource = Type\instance_of(GaugeDataPointResource::class)->assert(
            $this->queryBus->ask(GetGaugeDataPointQuery::mostRecentForGaugeFromSource(
                $createGaugeDataPoint->metric,
                $createGaugeDataPoint->source,
            )),
        );

        return $this->responseFactory->createResourceResponse($gaugeDataPointResource, HttpStatus::Created);
    }
}
