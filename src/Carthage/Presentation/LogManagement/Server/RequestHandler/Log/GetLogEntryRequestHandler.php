<?php

declare(strict_types=1);

namespace Carthage\Presentation\LogManagement\Server\RequestHandler\Log;

use Carthage\Application\LogManagement\Query\Log\GetLogEntryQuery;
use Carthage\Application\Shared\QueryBusInterface;
use Carthage\Domain\Shared\Entity\Identity;
use Carthage\Presentation\Shared\Server\HttpStatus;
use Carthage\Presentation\Shared\Server\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final readonly class GetLogEntryRequestHandler implements RequestHandlerInterface
{
    public function __construct(
        private QueryBusInterface $queryBus,
        private ResponseFactoryInterface $responseFactory,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        /** @var Identity $logEntryIdentity */
        $logEntryIdentity = $request->getAttribute('identity');

        $logEntryResource = $this->queryBus->ask(GetLogEntryQuery::withIdentity($logEntryIdentity));
        if (null === $logEntryResource) {
            return $this->responseFactory->createResponse(HttpStatus::NotFound);
        }

        return $this->responseFactory->createResourceResponse($logEntryResource);
    }
}
