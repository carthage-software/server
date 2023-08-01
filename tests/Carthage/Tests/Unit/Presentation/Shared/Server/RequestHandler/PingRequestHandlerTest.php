<?php

declare(strict_types=1);

namespace Carthage\Tests\Unit\Presentation\Shared\Server\RequestHandler;

use Carthage\Presentation\Shared\Server\RequestHandler\PingRequestHandler;
use Carthage\Presentation\Shared\Server\ResponseFactoryInterface;
use DateTimeImmutable;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\MockObject\Stub;
use PHPUnit\Framework\TestCase;
use Psr\Clock\ClockInterface;
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

        $clock = $this->createMock(ClockInterface::class);
        $responseFactory = $this->createMock(ResponseFactoryInterface::class);

        $datetime = new DateTimeImmutable('2021-01-01 00:00:00');
        $clock->expects(self::once())->method('now')->willReturn($datetime);

        $response = $this->createStub(ResponseInterface::class);
        $responseFactory->expects(self::once())->method('createEncodedResponse')->willReturnCallback(
            static function (array $data) use ($response): Stub&ResponseInterface {
                self::assertSame([
                    'ping' => 'pong!',
                    'time' => '2021-01-01T00:00:00.000+00:00',
                ], $data);

                return $response;
            },
        );

        $handler = new PingRequestHandler($clock, $responseFactory);

        $actual = $handler->handle($request);

        self::assertSame($response, $actual);
    }
}
