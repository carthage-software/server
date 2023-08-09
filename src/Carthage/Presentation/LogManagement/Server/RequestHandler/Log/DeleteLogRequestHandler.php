<?php

declare(strict_types=1);

namespace Carthage\Presentation\LogManagement\Server\RequestHandler\Log;

use Carthage\Application\LogManagement\Command\Log\DeleteLogCommand;
use Carthage\Application\Shared\CommandBusInterface;
use Carthage\Domain\Shared\Entity\Identity;
use Carthage\Presentation\Shared\Server\HttpStatus;
use Carthage\Presentation\Shared\Server\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final readonly class DeleteLogRequestHandler implements RequestHandlerInterface
{
    public function __construct(
        private CommandBusInterface $commandBus,
        private ResponseFactoryInterface $responseFactory,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        /** @var Identity $logIdentity */
        $logIdentity = $request->getAttribute('identity');

        $this->commandBus->dispatch(new DeleteLogCommand($logIdentity));

        return $this->responseFactory->createResponse(HttpStatus::NoContent);
    }
}
