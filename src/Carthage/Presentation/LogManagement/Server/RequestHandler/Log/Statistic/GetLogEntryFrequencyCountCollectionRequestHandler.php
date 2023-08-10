<?php

declare(strict_types=1);

namespace Carthage\Presentation\LogManagement\Server\RequestHandler\Log\Statistic;

use Carthage\Application\LogManagement\Query\Log\Statistic\GetLogEntryFrequencyCountCollectionQuery;
use Carthage\Application\Shared\QueryBusInterface;
use Carthage\Domain\LogManagement\Enum\Log\Statistics\Frequency;
use Carthage\Presentation\Shared\Server\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final readonly class GetLogEntryFrequencyCountCollectionRequestHandler implements RequestHandlerInterface
{
    public function __construct(
        private QueryBusInterface $queryBus,
        private ResponseFactoryInterface $responseFactory,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        /** @var Frequency $frequency */
        $frequency = $request->getAttribute('frequency');

        $logEntryFrequencyCountCollectionResource = $this->queryBus->ask(
            new GetLogEntryFrequencyCountCollectionQuery($frequency)
        );

        return $this->responseFactory->createResourceResponse($logEntryFrequencyCountCollectionResource);
    }
}
