<?php

declare(strict_types=1);

namespace Carthage\Tests\Unit\Presentation\Shared\Server\RequestHandler;

use Carthage\Application\Shared\Query\PingQuery;
use Carthage\Application\Shared\QueryBusInterface;
use Carthage\Application\Shared\Resource\PingResource;
use Carthage\Presentation\Shared\Server\RequestHandler\PingRequestHandler;
use Carthage\Presentation\Shared\Server\ResponseFactoryInterface;
use DateTimeImmutable;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\MockObject\Stub;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class PingRequestHandlerTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testHandle(): void
    {
        $request = $this->createStub(ServerRequestInterface::class);

        $responseFactory = $this->createMock(ResponseFactoryInterface::class);

        $response = $this->createStub(ResponseInterface::class);
        $responseFactory->expects(self::once())->method('createResourceResponse')->willReturnCallback(
            static function (PingResource $resource) use ($response): Stub&ResponseInterface {
                self::assertSame('pong!', $resource->quote);
                self::assertSame('2021-01-01 00:00:00', $resource->time->format('Y-m-d H:i:s'));

                return $response;
            },
        );

        $queryBus = $this->createMock(QueryBusInterface::class);
        $queryBus->expects(self::once())->method('ask')->willReturnCallback(static function (PingQuery $_query): PingResource {
            return new PingResource('pong!', new DateTimeImmutable('2021-01-01 00:00:00'));
        });

        $handler = new PingRequestHandler($queryBus, $responseFactory);

        $actual = $handler->handle($request);

        self::assertSame($response, $actual);
    }
}
