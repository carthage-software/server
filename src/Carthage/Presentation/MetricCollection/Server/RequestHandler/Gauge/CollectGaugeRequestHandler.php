<?php

declare(strict_types=1);

namespace Carthage\Presentation\MetricCollection\Server\RequestHandler\Gauge;

use Carthage\Application\MetricCollection\Command\Gauge\CollectGaugeCommand;
use Carthage\Application\Shared\CommandBusInterface;
use Carthage\Domain\MetricCollection\DataTransferObject\Gauge\CollectGauge;
use Carthage\Presentation\Shared\Server\HttpStatus;
use Carthage\Presentation\Shared\Server\RequestMapperInterface;
use Carthage\Presentation\Shared\Server\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final readonly class CollectGaugeRequestHandler implements RequestHandlerInterface
{
    public function __construct(
        private RequestMapperInterface $requestMapper,
        private CommandBusInterface $commandBus,
        private ResponseFactoryInterface $responseFactory,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $collectGauge = $this->requestMapper->mapRequestPayload($request, CollectGauge::class);
        if (null === $collectGauge) {
            return $this->responseFactory->createResponse(HttpStatus::BadRequest);
        }

        $this->commandBus->dispatch(new CollectGaugeCommand($collectGauge));

        return $this->responseFactory->createResponse(HttpStatus::Accepted);
    }
}
