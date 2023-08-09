<?php

declare(strict_types=1);

namespace Carthage\Presentation\MetricCollection\Server\RequestHandler\Histogram;

use Carthage\Application\MetricCollection\Command\Histogram\DeleteHistogramDataPointCommand;
use Carthage\Application\Shared\CommandBusInterface;
use Carthage\Domain\Shared\Entity\Identity;
use Carthage\Presentation\Shared\Server\HttpStatus;
use Carthage\Presentation\Shared\Server\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final readonly class DeleteHistogramDataPointRequestHandler implements RequestHandlerInterface
{
    public function __construct(
        private CommandBusInterface $commandBus,
        private ResponseFactoryInterface $responseFactory,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        /** @var Identity $histogramDataPointIdentity */
        $histogramDataPointIdentity = $request->getAttribute('identity');

        $this->commandBus->dispatch(new DeleteHistogramDataPointCommand($histogramDataPointIdentity));

        return $this->responseFactory->createResponse(HttpStatus::NoContent);
    }
}
