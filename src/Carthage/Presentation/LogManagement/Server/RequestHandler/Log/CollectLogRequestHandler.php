<?php

declare(strict_types=1);

namespace Carthage\Presentation\LogManagement\Server\RequestHandler\Log;

use Carthage\Application\LogManagement\Command\Log\CollectLogCommand;
use Carthage\Application\Shared\CommandBusInterface;
use Carthage\Domain\LogManagement\DataTransferObject\Log\CollectLog;
use Carthage\Presentation\Shared\Server\HttpStatus;
use Carthage\Presentation\Shared\Server\RequestMapperInterface;
use Carthage\Presentation\Shared\Server\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final readonly class CollectLogRequestHandler implements RequestHandlerInterface
{
    public function __construct(
        private RequestMapperInterface $requestMapper,
        private CommandBusInterface $commandBus,
        private ResponseFactoryInterface $responseFactory,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $collectLog = $this->requestMapper->mapRequestPayload($request, CollectLog::class);
        if (null === $collectLog) {
            return $this->responseFactory->createResponse(HttpStatus::BadRequest);
        }

        $this->commandBus->dispatch(new CollectLogCommand($collectLog));

        return $this->responseFactory->createResponse(HttpStatus::Accepted);
    }
}
