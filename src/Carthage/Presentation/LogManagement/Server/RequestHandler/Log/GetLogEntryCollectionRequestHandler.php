<?php

declare(strict_types=1);

namespace Carthage\Presentation\LogManagement\Server\RequestHandler\Log;

use Carthage\Application\LogManagement\Query\Log\GetLogEntryCollectionQuery;
use Carthage\Application\Shared\QueryBusInterface;
use Carthage\Domain\LogManagement\Filter\Log\LogEntryFilter;
use Carthage\Presentation\Shared\Server\RequestMapperInterface;
use Carthage\Presentation\Shared\Server\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final readonly class GetLogEntryCollectionRequestHandler implements RequestHandlerInterface
{
    public function __construct(
        private RequestMapperInterface $requestMapper,
        private QueryBusInterface $queryBus,
        private ResponseFactoryInterface $responseFactory,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $logEntryFilter = $this->requestMapper->mapQueryString($request, LogEntryFilter::class)
            ?? new LogEntryFilter()
        ;

        $logEntryResourceCollection = $this->queryBus->ask(new GetLogEntryCollectionQuery($logEntryFilter));

        return $this->responseFactory->createResourceResponse($logEntryResourceCollection);
    }
}
