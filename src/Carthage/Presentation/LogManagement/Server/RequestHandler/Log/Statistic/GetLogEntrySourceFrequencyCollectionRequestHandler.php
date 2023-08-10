<?php

declare(strict_types=1);

namespace Carthage\Presentation\LogManagement\Server\RequestHandler\Log\Statistic;

use Carthage\Application\LogManagement\Query\Log\Statistic\GetLogEntrySourceFrequencyCollectionQuery;
use Carthage\Application\Shared\QueryBusInterface;
use Carthage\Presentation\Shared\Server\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final readonly class GetLogEntrySourceFrequencyCollectionRequestHandler implements RequestHandlerInterface
{
    public function __construct(
        private QueryBusInterface $queryBus,
        private ResponseFactoryInterface $responseFactory,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $logEntrySourceFrequencyCollectionResource = $this->queryBus->ask(
            new GetLogEntrySourceFrequencyCollectionQuery()
        );

        return $this->responseFactory->createResourceResponse($logEntrySourceFrequencyCollectionResource);
    }
}
