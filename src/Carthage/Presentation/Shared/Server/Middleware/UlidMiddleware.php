<?php

declare(strict_types=1);

namespace Carthage\Presentation\Shared\Server\Middleware;

use Carthage\Presentation\Shared\Server\HttpStatus;
use Carthage\Presentation\Shared\Server\ResponseFactoryInterface;
use Psl\Type;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Symfony\Component\Uid\Ulid;

final readonly class UlidMiddleware implements MiddlewareInterface
{
    public function __construct(
        private ResponseFactoryInterface $responseFactory,
    ) {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $ulid = $request->getAttribute('ulid');
        if (null !== $ulid) {
            if (!Type\non_empty_string()->matches($ulid)) {
                return $this->responseFactory->createResponse(HttpStatus::BadRequest);
            }

            $ulid = Ulid::fromString($ulid);

            $request = $request->withAttribute('ulid', $ulid);
        }

        return $handler->handle($request);
    }
}
