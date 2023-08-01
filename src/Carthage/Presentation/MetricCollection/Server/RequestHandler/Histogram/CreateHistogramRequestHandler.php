<?php

declare(strict_types=1);

namespace Carthage\Presentation\MetricCollection\Server\RequestHandler\Histogram;

use Carthage\Application\MetricCollection\Command\Histogram\CreateHistogramCommand;
use Carthage\Application\MetricCollection\Query\Histogram\GetHistogramQuery;
use Carthage\Application\Shared\CommandBusInterface;
use Carthage\Application\Shared\QueryBusInterface;
use Carthage\Domain\MetricCollection\DataTransferObject\Histogram\CreateHistogram;
use Carthage\Domain\MetricCollection\Resource\Histogram\HistogramResource;
use Carthage\Presentation\Shared\Server\HttpStatus;
use Carthage\Presentation\Shared\Server\RequestMapperInterface;
use Carthage\Presentation\Shared\Server\ResponseFactoryInterface;
use Psl\Type;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final readonly class CreateHistogramRequestHandler implements RequestHandlerInterface
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
        $createHistogram = $this->requestMapper->mapRequestPayload($request, CreateHistogram::class);
        if (null === $createHistogram) {
            return $this->responseFactory->createResponse(HttpStatus::BadRequest);
        }

        $this->commandBus->dispatch(new CreateHistogramCommand($createHistogram));

        $histogramResource = Type\instance_of(HistogramResource::class)->assert(
            $this->queryBus->ask(GetHistogramQuery::withResourceAndName(
                $createHistogram->namespace,
                $createHistogram->name,
            )),
        );

        return $this->responseFactory->createResourceResponse($histogramResource, HttpStatus::Created);
    }
}
