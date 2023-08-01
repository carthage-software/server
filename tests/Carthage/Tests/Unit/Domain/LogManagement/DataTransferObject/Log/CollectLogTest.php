<?php

declare(strict_types=1);

namespace Carthage\Tests\Unit\Domain\LogManagement\DataTransferObject\Log;

use Carthage\Domain\LogManagement\DataTransferObject\Log\CollectLog;
use Carthage\Domain\LogManagement\DataTransferObject\Log\CollectLogEntry;
use Carthage\Domain\LogManagement\DataTransferObject\Log\CreateLog;
use Carthage\Domain\LogManagement\Enum\Log\Level;
use DateTimeImmutable;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class CollectLogTest extends TestCase
{
    /**
     * @param non-empty-string $source
     * @param array<string, mixed> $context
     * @param array<string, mixed> $extra
     * @param list<non-empty-string> $tags
     */
    #[DataProvider('provideData')]
    public function testConstruct(CreateLog $createLog, string $source, array $context, array $extra, array $tags, DateTimeImmutable $occurredAt): void
    {
        $dto = new CollectLog($createLog, [
            new CollectLogEntry($source, $context, $extra, $tags, $occurredAt),
        ]);

        self::assertSame($createLog, $dto->log);
        self::assertCount(1, $dto->entries);
        self::assertSame($source, $dto->entries[0]->source);
        self::assertSame($context, $dto->entries[0]->context);
        self::assertSame($extra, $dto->entries[0]->attributes);
        self::assertSame($tags, $dto->entries[0]->tags);
        self::assertSame($occurredAt, $dto->entries[0]->occurredAt);
    }

    /**
     * @return iterable<array{CreateLog, non-empty-string, array<string, mixed>, array<string, mixed>, list<string>, DateTimeImmutable}>
     */
    public static function provideData(): iterable
    {
        $createLog = new CreateLog('event', Level::Info, 'hello world!');

        yield [$createLog, 'localhost', [], [], [], new DateTimeImmutable()];
        yield [$createLog, 'localhost', ['foo' => 'bar'], ['bar' => 'baz'], ['foo', 'bar'], new DateTimeImmutable()];
    }
}
