<?php

declare(strict_types=1);

namespace Carthage\Presentation\MetricCollection\Server\Middleware\Summary;

use Carthage\Domain\MetricCollection\Exception\Summary\ConflictException;
use Carthage\Presentation\Shared\Server\HttpStatus;
use Carthage\Presentation\Shared\Server\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;

final readonly class SummaryConflictMiddleware implements MiddlewareInterface
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
        } catch (ConflictException $exception) {
            $this->logger->info($exception->getMessage(), ['exception' => $exception]);

            return $this->responseFactory->createResponse(HttpStatus::Conflict);
        }
    }
}
