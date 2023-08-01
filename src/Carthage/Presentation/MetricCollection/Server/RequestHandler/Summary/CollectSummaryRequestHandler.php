<?php

declare(strict_types=1);

namespace Carthage\Presentation\MetricCollection\Server\RequestHandler\Summary;

use Carthage\Application\MetricCollection\Command\Summary\CollectSummaryCommand;
use Carthage\Application\Shared\CommandBusInterface;
use Carthage\Domain\MetricCollection\DataTransferObject\Summary\CollectSummary;
use Carthage\Presentation\Shared\Server\HttpStatus;
use Carthage\Presentation\Shared\Server\RequestMapperInterface;
use Carthage\Presentation\Shared\Server\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final readonly class CollectSummaryRequestHandler implements RequestHandlerInterface
{
    public function __construct(
        private RequestMapperInterface $requestMapper,
        private CommandBusInterface $commandBus,
        private ResponseFactoryInterface $responseFactory,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $collectSummary = $this->requestMapper->mapRequestPayload($request, CollectSummary::class);
        if (null === $collectSummary) {
            return $this->responseFactory->createResponse(HttpStatus::BadRequest);
        }

        $this->commandBus->dispatch(new CollectSummaryCommand($collectSummary));

        return $this->responseFactory->createResponse(HttpStatus::Accepted);
    }
}
