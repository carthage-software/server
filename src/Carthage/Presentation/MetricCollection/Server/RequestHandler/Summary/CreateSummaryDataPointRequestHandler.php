<?php

declare(strict_types=1);

namespace Carthage\Presentation\MetricCollection\Server\RequestHandler\Summary;

use Carthage\Application\MetricCollection\Command\Summary\CreateSummaryDataPointCommand;
use Carthage\Application\MetricCollection\Query\Summary\GetSummaryDataPointQuery;
use Carthage\Application\Shared\CommandBusInterface;
use Carthage\Application\Shared\QueryBusInterface;
use Carthage\Domain\MetricCollection\DataTransferObject\Summary\CreateSummaryDataPoint;
use Carthage\Domain\MetricCollection\Resource\Summary\SummaryDataPointResource;
use Carthage\Presentation\Shared\Server\HttpStatus;
use Carthage\Presentation\Shared\Server\RequestMapperInterface;
use Carthage\Presentation\Shared\Server\ResponseFactoryInterface;
use Psl\Type;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final readonly class CreateSummaryDataPointRequestHandler implements RequestHandlerInterface
{
    public function __construct(
        private RequestMapperInterface $requestMapper,
        private CommandBusInterface $commandBus,
        private QueryBusInterface $queryBus,
        private ResponseFactoryInterface $responseFactory,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $createSummaryDataPoint = $this->requestMapper->mapRequestPayload($request, CreateSummaryDataPoint::class);
        if (null === $createSummaryDataPoint) {
            return $this->responseFactory->createResponse(HttpStatus::BadRequest);
        }

        $this->commandBus->dispatch(new CreateSummaryDataPointCommand($createSummaryDataPoint));

        $summaryDataPointResource = Type\instance_of(SummaryDataPointResource::class)->assert(
            $this->queryBus->ask(GetSummaryDataPointQuery::mostRecentForSummaryFromSource(
                $createSummaryDataPoint->metric,
                $createSummaryDataPoint->source,
            )),
        );

        return $this->responseFactory->createResourceResponse($summaryDataPointResource, HttpStatus::Created);
    }
}
