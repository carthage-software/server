<?php

declare(strict_types=1);

namespace Carthage\Presentation\LogManagement\Server\Middleware\Log\Statistic;

use DateTimeImmutable;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class FromMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $from = $request->getAttribute('from');
        if (null !== $from) {
            $from = DateTimeImmutable::createFromFormat('Y-m-d', $from);
        }

        return $handler->handle(
            $request->withAttribute('from', $from),
        );
    }
}
