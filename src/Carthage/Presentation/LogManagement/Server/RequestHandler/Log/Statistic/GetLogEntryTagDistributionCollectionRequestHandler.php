<?php

declare(strict_types=1);

namespace Carthage\Presentation\LogManagement\Server\RequestHandler\Log\Statistic;

use Carthage\Application\LogManagement\Query\Log\Statistic\GetLogEntryTagDistributionCollectionQuery;
use Carthage\Application\Shared\QueryBusInterface;
use Carthage\Presentation\Shared\Server\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final readonly class GetLogEntryTagDistributionCollectionRequestHandler implements RequestHandlerInterface
{
    public function __construct(
        private QueryBusInterface $queryBus,
        private ResponseFactoryInterface $responseFactory,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $logEntryTagDistributionCollectionResource = $this->queryBus->ask(
            new GetLogEntryTagDistributionCollectionQuery()
        );

        return $this->responseFactory->createResourceResponse($logEntryTagDistributionCollectionResource);
    }
}
