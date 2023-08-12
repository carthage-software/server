<?php

declare(strict_types=1);

namespace Carthage\Presentation\Shared\Server\RequestHandler;

use Carthage\Application\Shared\Query\PingQuery;
use Carthage\Application\Shared\QueryBusInterface;
use Carthage\Presentation\Shared\Server\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final readonly class PingRequestHandler implements RequestHandlerInterface
{
    public function __construct(
        private QueryBusInterface $queryBus,
        private ResponseFactoryInterface $responseFactory,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $pingResource = $this->queryBus->ask(new PingQuery());

        return $this->responseFactory->createResourceResponse($pingResource);
    }
}
