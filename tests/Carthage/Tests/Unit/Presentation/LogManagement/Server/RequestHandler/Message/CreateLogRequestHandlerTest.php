<?php

declare(strict_types=1);

namespace Carthage\Tests\Unit\Presentation\LogManagement\Server\RequestHandler\Message;

use Carthage\Application\LogManagement\Command\Log\CreateLogCommand;
use Carthage\Application\LogManagement\Query\Log\GetLogQuery;
use Carthage\Application\LogManagement\Resource\Log\LogResource;
use Carthage\Application\Shared\CommandBusInterface;
use Carthage\Application\Shared\QueryBusInterface;
use Carthage\Domain\LogManagement\DataTransferObject\Log\CreateLog;
use Carthage\Domain\LogManagement\Enum\Log\Level;
use Carthage\Domain\Shared\Criteria\Expression\Comparison;
use Carthage\Domain\Shared\Criteria\Expression\Composition;
use Carthage\Domain\Shared\Criteria\Expression\Enum\ComparisonOperator;
use Carthage\Domain\Shared\Criteria\Expression\Enum\CompositionOperator;
use Carthage\Domain\Shared\Entity\Identity;
use Carthage\Presentation\LogManagement\Server\RequestHandler\Log\CreateLogRequestHandler;
use Carthage\Presentation\Shared\Server\HttpStatus;
use Carthage\Presentation\Shared\Server\RequestMapperInterface;
use Carthage\Presentation\Shared\Server\ResponseFactoryInterface;
use DateTimeImmutable;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\MockObject\Stub;
use PHPUnit\Framework\TestCase;
use Psl\Type;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class CreateLogRequestHandlerTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testSuccess(): void
    {
        $mapper = $this->createMock(RequestMapperInterface::class);
        $commandBus = $this->createMock(CommandBusInterface::class);
        $queryBus = $this->createMock(QueryBusInterface::class);
        $responseFactory = $this->createMock(ResponseFactoryInterface::class);

        $request = $this->createStub(ServerRequestInterface::class);

        $createLog = new CreateLog('event', Level::Debug, 'event {event} has been dispatched.');
        $mapper->expects(self::once())
            ->method('mapRequestPayload')
            ->with($request, CreateLog::class)
            ->willReturn($createLog);

        $commandBus->expects(self::once())
            ->method('dispatch')
            ->with(self::isInstanceOf(CreateLogCommand::class))
            ->willReturnCallback(
                static fn (CreateLogCommand $command) => self::assertSame($createLog, $command->createLog)
            );

        $logResource = new LogResource(new Identity('a'), $createLog->namespace, $createLog->level, $createLog->template, null, null, new DateTimeImmutable(), new DateTimeImmutable());
        $queryBus->expects(self::once())
            ->method('ask')
            ->with(self::isInstanceOf(GetLogQuery::class))
            ->willReturnCallback(
                static function (GetLogQuery $query) use ($createLog, $logResource): LogResource {
                    $criteria = $query->criteria;
                    $expression = $criteria->expression;

                    self::assertNotNull($expression);
                    self::assertInstanceOf(Composition::class, $expression);
                    self::assertSame(CompositionOperator::And, $expression->operator);
                    self::assertCount(3, $expression->expressions);

                    /** @psalm-suppress TypeDoesNotContainType */
                    $expressions = Type\shape([
                        0 => Type\instance_of(Comparison::class),
                        1 => Type\instance_of(Comparison::class),
                        2 => Type\instance_of(Comparison::class),
                    ])->assert($expression->expressions);

                    $comparison = $expressions[0];
                    self::assertSame('namespace', $comparison->field);
                    self::assertSame(ComparisonOperator::Equal, $comparison->operator);
                    self::assertSame($createLog->namespace, $comparison->value);

                    $comparison = $expressions[1];
                    self::assertSame('level', $comparison->field);
                    self::assertSame(ComparisonOperator::Equal, $comparison->operator);
                    self::assertSame($createLog->level, $comparison->value);

                    $comparison = $expressions[2];
                    self::assertSame('template', $comparison->field);
                    self::assertSame(ComparisonOperator::Equal, $comparison->operator);
                    self::assertSame($createLog->template, $comparison->value);

                    self::assertEmpty($criteria->order);

                    return $logResource;
                },
            );

        $response = $this->createStub(ResponseInterface::class);
        $responseFactory->expects(self::once())->method('createResourceResponse')
            ->willReturnCallback(
                static function (LogResource $resource, HttpStatus $status) use ($logResource, $response): Stub&ResponseInterface {
                    self::assertSame($logResource, $resource);
                    self::assertSame(HttpStatus::Created, $status);

                    return $response;
                },
            );

        $handler = new CreateLogRequestHandler($mapper, $commandBus, $queryBus, $responseFactory);
        $actual = $handler->handle($request);

        self::assertSame($response, $actual);
    }
}
