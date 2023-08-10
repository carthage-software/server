<?php

declare(strict_types=1);

namespace Carthage\Presentation\LogManagement\Server\RequestHandler\Log;

use Carthage\Application\LogManagement\Command\Log\CreateLogCommand;
use Carthage\Application\LogManagement\Query\Log\GetLogQuery;
use Carthage\Application\LogManagement\Resource\Log\LogResource;
use Carthage\Application\Shared\CommandBusInterface;
use Carthage\Application\Shared\QueryBusInterface;
use Carthage\Domain\LogManagement\DataTransferObject\Log\CreateLog;
use Carthage\Presentation\Shared\Server\HttpStatus;
use Carthage\Presentation\Shared\Server\RequestMapperInterface;
use Carthage\Presentation\Shared\Server\ResponseFactoryInterface;
use Psl\Type;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final readonly class CreateLogRequestHandler implements RequestHandlerInterface
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
        $createLog = $this->requestMapper->mapRequestPayload($request, CreateLog::class);
        if (null === $createLog) {
            return $this->responseFactory->createResponse(HttpStatus::BadRequest);
        }

        $this->commandBus->dispatch(new CreateLogCommand($createLog));

        $logResource = Type\instance_of(LogResource::class)->assert(
            $this->queryBus->ask(GetLogQuery::withLevelAndTemplateInNamespace(
                $createLog->level,
                $createLog->template,
                $createLog->namespace,
            )),
        );

        return $this->responseFactory->createResourceResponse($logResource, HttpStatus::Created);
    }
}
