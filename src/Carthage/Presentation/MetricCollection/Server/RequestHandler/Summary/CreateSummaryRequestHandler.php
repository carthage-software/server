<?php

declare(strict_types=1);

namespace Carthage\Presentation\MetricCollection\Server\RequestHandler\Summary;

use Carthage\Application\MetricCollection\Command\Summary\CreateSummaryCommand;
use Carthage\Application\MetricCollection\Query\Summary\GetSummaryQuery;
use Carthage\Application\MetricCollection\Resource\Summary\SummaryResource;
use Carthage\Application\Shared\CommandBusInterface;
use Carthage\Application\Shared\QueryBusInterface;
use Carthage\Domain\MetricCollection\DataTransferObject\Summary\CreateSummary;
use Carthage\Presentation\Shared\Server\HttpStatus;
use Carthage\Presentation\Shared\Server\RequestMapperInterface;
use Carthage\Presentation\Shared\Server\ResponseFactoryInterface;
use Psl\Type;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final readonly class CreateSummaryRequestHandler implements RequestHandlerInterface
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
        $createSummary = $this->requestMapper->mapRequestPayload($request, CreateSummary::class);
        if (null === $createSummary) {
            return $this->responseFactory->createResponse(HttpStatus::BadRequest);
        }

        $this->commandBus->dispatch(new CreateSummaryCommand($createSummary));

        $summaryResource = Type\instance_of(SummaryResource::class)->assert(
            $this->queryBus->ask(GetSummaryQuery::withResourceAndName(
                $createSummary->namespace,
                $createSummary->name,
            )),
        );

        return $this->responseFactory->createResourceResponse($summaryResource, HttpStatus::Created);
    }
}
