<?php

declare(strict_types=1);

namespace Carthage\Presentation\LogManagement\Server\Middleware\Log;

use Carthage\Domain\LogManagement\Exception\Log\NotFoundException;
use Carthage\Presentation\Shared\Server\HttpStatus;
use Carthage\Presentation\Shared\Server\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;

final readonly class LogNotFoundMiddleware implements MiddlewareInterface
{
    public function __construct(
        private LoggerInterface $logger,
        private ResponseFactoryInterface $responseFactory,
    ) {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            return $handler->handle($request);
        } catch (NotFoundException $exception) {
            $this->logger->info($exception->getMessage(), ['exception' => $exception]);

            return $this->responseFactory->createResponse(HttpStatus::NotFound);
        }
    }
}
