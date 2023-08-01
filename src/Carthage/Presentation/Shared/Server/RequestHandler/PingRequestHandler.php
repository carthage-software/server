<?php

declare(strict_types=1);

namespace Carthage\Presentation\Shared\Server\RequestHandler;

use Carthage\Presentation\Shared\Server\ResponseFactoryInterface;
use DateTimeInterface;
use Psr\Clock\ClockInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final readonly class PingRequestHandler implements RequestHandlerInterface
{
    public function __construct(
        private ClockInterface $clock,
        private ResponseFactoryInterface $responseFactory,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return $this->responseFactory->createEncodedResponse([
            'ping' => 'pong!',
            'time' => $this->clock->now()->format(DateTimeInterface::RFC3339_EXTENDED),
        ]);
    }
}
