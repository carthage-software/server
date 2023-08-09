<?php

declare(strict_types=1);

namespace Carthage\Presentation\MetricCollection\Server\RequestHandler\Summary;

use Carthage\Application\MetricCollection\Command\Summary\DeleteSummaryDataPointCommand;
use Carthage\Application\Shared\CommandBusInterface;
use Carthage\Domain\Shared\Entity\Identity;
use Carthage\Presentation\Shared\Server\HttpStatus;
use Carthage\Presentation\Shared\Server\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final readonly class DeleteSummaryDataPointRequestHandler implements RequestHandlerInterface
{
    public function __construct(
        private CommandBusInterface $commandBus,
        private ResponseFactoryInterface $responseFactory,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        /** @var Identity $summaryDataPointIdentity */
        $summaryDataPointIdentity = $request->getAttribute('identity');

        $this->commandBus->dispatch(new DeleteSummaryDataPointCommand($summaryDataPointIdentity));

        return $this->responseFactory->createResponse(HttpStatus::NoContent);
    }
}
