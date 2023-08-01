<?php

declare(strict_types=1);

namespace Carthage\Presentation\MetricCollection\Server\RequestHandler;

use Carthage\Application\MetricCollection\Command\CollectCommand;
use Carthage\Application\Shared\CommandBusInterface;
use Carthage\Domain\MetricCollection\DataTransferObject\Collect;
use Carthage\Presentation\Shared\Server\HttpStatus;
use Carthage\Presentation\Shared\Server\RequestMapperInterface;
use Carthage\Presentation\Shared\Server\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final readonly class CollectRequestHandler implements RequestHandlerInterface
{
    public function __construct(
        private RequestMapperInterface $requestMapper,
        private CommandBusInterface $commandBus,
        private ResponseFactoryInterface $responseFactory,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $collect = $this->requestMapper->mapRequestPayload($request, Collect::class);
        if (null === $collect) {
            return $this->responseFactory->createResponse(HttpStatus::BadRequest);
        }

        if ($collect->isEmpty()) {
            return $this->responseFactory->createResponse(HttpStatus::UnprocessableEntity);
        }

        if ($collect->isTooLarge()) {
            return $this->responseFactory->createResponse(HttpStatus::PayloadTooLarge);
        }

        $this->commandBus->dispatch(new CollectCommand($collect));

        return $this->responseFactory->createResponse(HttpStatus::Accepted);
    }
}
