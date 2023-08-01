<?php

declare(strict_types=1);

namespace Carthage\Tests\Unit\Domain\LogManagement\DataTransferObject\Log;

use Carthage\Domain\LogManagement\DataTransferObject\Log\CreateLogEntry;
use DateTimeImmutable;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Ulid;

final class CreateLogEntryTest extends TestCase
{
    /**
     * @param non-empty-string $source
     * @param array<string, mixed> $context
     * @param array<string, mixed> $extra
     * @param list<non-empty-string> $tags
     */
    #[DataProvider('provideData')]
    public function testConstruct(Ulid $message, string $source, array $context, array $extra, array $tags, DateTimeImmutable $occurredAt): void
    {
        $dto = new CreateLogEntry($message, $source, $context, $extra, $tags, $occurredAt);

        self::assertSame($message, $dto->log);
        self::assertSame($source, $dto->source);
        self::assertSame($context, $dto->context);
        self::assertSame($extra, $dto->attributes);
        self::assertSame($tags, $dto->tags);
        self::assertSame($occurredAt, $dto->occurredAt);
    }

    /**
     * @return iterable<array{Ulid, non-empty-string, array<string, mixed>, array<string, mixed>, list<non-empty-string>, DateTimeImmutable}>
     */
    public static function provideData(): iterable
    {
        yield [new Ulid(), 'localhost', [], [], [], new DateTimeImmutable()];
        yield [new Ulid(), 'www1.aws', ['foo' => 'bar'], ['bar' => 'baz'], ['foo', 'bar'], new DateTimeImmutable()];
        yield [new Ulid(), 'staging.www2.aws', ['foo' => 'bar'], ['bar' => 'baz'], ['foo', 'bar'], new DateTimeImmutable()];
    }
}
