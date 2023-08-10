<?php

declare(strict_types=1);

namespace Carthage\Presentation\LogManagement\Server\Middleware\Log\Statistic;

use Carthage\Domain\LogManagement\Enum\Log\Statistics\Frequency;
use Psl\Str;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class FrequencyMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $frequency = $request->getAttribute('frequency');
        if (null !== $frequency) {
            $frequency = Frequency::tryFrom(
                Str\lowercase($frequency),
            );
        }

        return $handler->handle(
            $request->withAttribute('frequency', $frequency),
        );
    }
}
