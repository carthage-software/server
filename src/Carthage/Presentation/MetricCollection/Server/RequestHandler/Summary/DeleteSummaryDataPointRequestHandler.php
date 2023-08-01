<?php

declare(strict_types=1);

namespace Carthage\Presentation\MetricCollection\Server\RequestHandler\Summary;

use Carthage\Application\MetricCollection\Command\Summary\DeleteSummaryDataPointCommand;
use Carthage\Application\Shared\CommandBusInterface;
use Carthage\Presentation\Shared\Server\HttpStatus;
use Carthage\Presentation\Shared\Server\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Symfony\Component\Uid\Ulid;

final readonly class DeleteSummaryDataPointRequestHandler implements RequestHandlerInterface
{
    public function __construct(
        private CommandBusInterface $commandBus,
        private ResponseFactoryInterface $responseFactory,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        /** @var Ulid $summaryDataPointId */
        $summaryDataPointId = $request->getAttribute('ulid');

        $this->commandBus->dispatch(new DeleteSummaryDataPointCommand($summaryDataPointId));

        return $this->responseFactory->createResponse(HttpStatus::NoContent);
    }
}