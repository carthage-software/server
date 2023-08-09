<?php

declare(strict_types=1);

namespace Carthage\Presentation\MetricCollection\Server\RequestHandler\Summary;

use Carthage\Application\MetricCollection\Query\Summary\GetSummaryQuery;
use Carthage\Application\Shared\QueryBusInterface;
use Carthage\Domain\Shared\Entity\Identity;
use Carthage\Presentation\Shared\Server\HttpStatus;
use Carthage\Presentation\Shared\Server\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final readonly class ShowSummaryRequestHandler implements RequestHandlerInterface
{
    public function __construct(
        private QueryBusInterface $queryBus,
        private ResponseFactoryInterface $responseFactory,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        /** @var Identity $summaryIdentity */
        $summaryIdentity = $request->getAttribute('identity');

        $sumResource = $this->queryBus->ask(GetSummaryQuery::withIdentity($summaryIdentity));
        if (null === $sumResource) {
            return $this->responseFactory->createResponse(HttpStatus::NotFound);
        }

        return $this->responseFactory->createResourceResponse($sumResource);
    }
}
