<?php

declare(strict_types=1);

namespace Carthage\Presentation\LogManagement\Server\RequestHandler\Log;

use Carthage\Application\LogManagement\Command\Log\CreateLogEntryCommand;
use Carthage\Application\LogManagement\Query\Log\GetLogEntryQuery;
use Carthage\Application\Shared\CommandBusInterface;
use Carthage\Application\Shared\QueryBusInterface;
use Carthage\Domain\LogManagement\DataTransferObject\Log\CreateLogEntry;
use Carthage\Domain\LogManagement\Resource\Log\LogEntryResource;
use Carthage\Presentation\Shared\Server\HttpStatus;
use Carthage\Presentation\Shared\Server\RequestMapperInterface;
use Carthage\Presentation\Shared\Server\ResponseFactoryInterface;
use Psl\Type;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final readonly class CreateLogEntryRequestHandler implements RequestHandlerInterface
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
        $createLogEntry = $this->requestMapper->mapRequestPayload($request, CreateLogEntry::class);
        if (null === $createLogEntry) {
            return $this->responseFactory->createResponse(HttpStatus::BadRequest);
        }

        $this->commandBus->dispatch(new CreateLogEntryCommand($createLogEntry));

        $logEntryResource = Type\instance_of(LogEntryResource::class)->assert(
            $this->queryBus->ask(GetLogEntryQuery::mostRecentForLogFromSource(
                $createLogEntry->log,
                $createLogEntry->source,
            )),
        );

        return $this->responseFactory->createResourceResponse($logEntryResource, HttpStatus::Created);
    }
}
