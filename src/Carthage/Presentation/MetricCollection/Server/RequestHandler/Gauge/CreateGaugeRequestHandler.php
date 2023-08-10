<?php

declare(strict_types=1);

namespace Carthage\Presentation\MetricCollection\Server\RequestHandler\Gauge;

use Carthage\Application\MetricCollection\Command\Gauge\CreateGaugeCommand;
use Carthage\Application\MetricCollection\Query\Gauge\GetGaugeQuery;
use Carthage\Application\MetricCollection\Resource\Gauge\GaugeResource;
use Carthage\Application\Shared\CommandBusInterface;
use Carthage\Application\Shared\QueryBusInterface;
use Carthage\Domain\MetricCollection\DataTransferObject\Gauge\CreateGauge;
use Carthage\Presentation\Shared\Server\HttpStatus;
use Carthage\Presentation\Shared\Server\RequestMapperInterface;
use Carthage\Presentation\Shared\Server\ResponseFactoryInterface;
use Psl\Type;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final readonly class CreateGaugeRequestHandler implements RequestHandlerInterface
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
        $createGauge = $this->requestMapper->mapRequestPayload($request, CreateGauge::class);
        if (null === $createGauge) {
            return $this->responseFactory->createResponse(HttpStatus::BadRequest);
        }

        $this->commandBus->dispatch(new CreateGaugeCommand($createGauge));

        $gaugeResource = Type\instance_of(GaugeResource::class)->assert(
            $this->queryBus->ask(GetGaugeQuery::withResourceAndName(
                $createGauge->namespace,
                $createGauge->name,
            )),
        );

        return $this->responseFactory->createResourceResponse($gaugeResource, HttpStatus::Created);
    }
}
