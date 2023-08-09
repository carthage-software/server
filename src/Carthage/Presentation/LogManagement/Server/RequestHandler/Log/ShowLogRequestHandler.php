<?php

declare(strict_types=1);

namespace Carthage\Presentation\LogManagement\Server\RequestHandler\Log;

use Carthage\Application\LogManagement\Query\Log\GetLogQuery;
use Carthage\Application\Shared\QueryBusInterface;
use Carthage\Domain\Shared\Entity\Identity;
use Carthage\Presentation\Shared\Server\HttpStatus;
use Carthage\Presentation\Shared\Server\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final readonly class ShowLogRequestHandler implements RequestHandlerInterface
{
    public function __construct(
        private QueryBusInterface $queryBus,
        private ResponseFactoryInterface $responseFactory,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        /** @var Identity $logIdentity */
        $logIdentity = $request->getAttribute('identity');

        $logResource = $this->queryBus->ask(GetLogQuery::withIdentity($logIdentity));
        if (null === $logResource) {
            return $this->responseFactory->createResponse(HttpStatus::NotFound);
        }

        return $this->responseFactory->createResourceResponse($logResource);
    }
}
