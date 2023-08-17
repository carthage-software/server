<?php

declare(strict_types=1);

namespace Carthage\Presentation\LogManagement\Server\RequestHandler\Log\Statistic;

use Carthage\Application\LogManagement\Query\Log\Statistic\GetLogEntryTagDistributionStatisticCollectionQuery;
use Carthage\Application\Shared\QueryBusInterface;
use Carthage\Presentation\Shared\Server\ResponseFactoryInterface;
use DateTimeImmutable;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final readonly class GetLogEntryTagDistributionStatisticCollectionRequestHandler implements RequestHandlerInterface
{
    public function __construct(
        private QueryBusInterface $queryBus,
        private ResponseFactoryInterface $responseFactory,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        /** @var DateTimeImmutable $from */
        $from = $request->getAttribute('from');
        /** @var DateTimeImmutable $to */
        $to = $request->getAttribute('to');

        $logEntryTagDistributionStatisticCollectionResource = $this->queryBus->ask(
            new GetLogEntryTagDistributionStatisticCollectionQuery($from, $to)
        );

        return $this->responseFactory->createResourceResponse($logEntryTagDistributionStatisticCollectionResource);
    }
}
