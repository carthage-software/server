<?php

declare(strict_types=1);

namespace Carthage\Presentation\LogManagement\Server\RequestHandler\Log;

use Carthage\Application\LogManagement\Query\Log\GetLogCollectionQuery;
use Carthage\Application\Shared\QueryBusInterface;
use Carthage\Domain\LogManagement\Filter\Log\LogFilter;
use Carthage\Presentation\Shared\Server\RequestMapperInterface;
use Carthage\Presentation\Shared\Server\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final readonly class GetLogCollectionRequestHandler implements RequestHandlerInterface
{
    public function __construct(
        private RequestMapperInterface $requestMapper,
        private QueryBusInterface $queryBus,
        private ResponseFactoryInterface $responseFactory,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $logFilter = $this->requestMapper->mapQueryString($request, LogFilter::class)
            ?? new LogFilter()
        ;

        $logResourceCollection = $this->queryBus->ask(new GetLogCollectionQuery($logFilter));

        return $this->responseFactory->createResourceResponse($logResourceCollection);
    }
}
