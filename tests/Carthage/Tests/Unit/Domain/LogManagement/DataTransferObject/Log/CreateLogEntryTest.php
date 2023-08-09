<?php

declare(strict_types=1);

namespace Carthage\Tests\Unit\Domain\LogManagement\DataTransferObject\Log;

use Carthage\Domain\LogManagement\DataTransferObject\Log\CreateLogEntry;
use Carthage\Domain\Shared\Entity\Identity;
use DateTimeImmutable;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class CreateLogEntryTest extends TestCase
{
    /**
     * @param non-empty-string $source
     * @param array<string, mixed> $context
     * @param array<string, mixed> $extra
     * @param list<non-empty-string> $tags
     */
    #[DataProvider('provideData')]
    public function testConstruct(Identity $logIdentity, string $source, array $context, array $extra, array $tags, DateTimeImmutable $occurredAt): void
    {
        $dto = new CreateLogEntry($logIdentity, $source, $context, $extra, $tags, $occurredAt);

        self::assertSame($logIdentity, $dto->logIdentity);
        self::assertSame($source, $dto->source);
        self::assertSame($context, $dto->context);
        self::assertSame($extra, $dto->attributes);
        self::assertSame($tags, $dto->tags);
        self::assertSame($occurredAt, $dto->occurredAt);
    }

    /**
     * @return iterable<array{Identity, non-empty-string, array<string, mixed>, array<string, mixed>, list<non-empty-string>, DateTimeImmutable}>
     */
    public static function provideData(): iterable
    {
        yield [new Identity('a'), 'localhost', [], [], [], new DateTimeImmutable()];
        yield [new Identity('b'), 'www1.aws', ['foo' => 'bar'], ['bar' => 'baz'], ['foo', 'bar'], new DateTimeImmutable()];
        yield [new Identity('c'), 'staging.www2.aws', ['foo' => 'bar'], ['bar' => 'baz'], ['foo', 'bar'], new DateTimeImmutable()];
    }
}
