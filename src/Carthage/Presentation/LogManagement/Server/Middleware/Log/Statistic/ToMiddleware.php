<?php

declare(strict_types=1);

namespace Carthage\Presentation\LogManagement\Server\Middleware\Log\Statistic;

use DateTimeImmutable;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class ToMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $to = $request->getAttribute('to');
        if (null !== $to) {
            $to = DateTimeImmutable::createFromFormat('Y-m-d', $to);
        }

        return $handler->handle(
            $request->withAttribute('to', $to),
        );
    }
}
