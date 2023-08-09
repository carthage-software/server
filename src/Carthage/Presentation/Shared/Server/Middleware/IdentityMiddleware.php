<?php

declare(strict_types=1);

namespace Carthage\Presentation\Shared\Server\Middleware;

use Carthage\Domain\Shared\Entity\Identity;
use Carthage\Presentation\Shared\Server\HttpStatus;
use Carthage\Presentation\Shared\Server\ResponseFactoryInterface;
use Psl\Type;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final readonly class IdentityMiddleware implements MiddlewareInterface
{
    public function __construct(
        private ResponseFactoryInterface $responseFactory,
    ) {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $identityValue = $request->getAttribute('identity');
        if (null !== $identityValue) {
            if (!Type\non_empty_string()->matches($identityValue)) {
                return $this->responseFactory->createResponse(HttpStatus::BadRequest);
            }

            $identity = new Identity($identityValue);

            $request = $request->withAttribute('identity', $identity);
        }

        return $handler->handle($request);
    }
}
