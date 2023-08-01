<?php

declare(strict_types=1);

namespace Carthage\Tests\Unit\Domain\LogManagement\DataTransferObject\Log;

use Carthage\Domain\LogManagement\DataTransferObject\Log\CreateLog;
use Carthage\Domain\LogManagement\Enum\Log\Level;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class CreateLogTest extends TestCase
{
    /**
     * @param non-empty-string $namespace
     * @param non-empty-string $template
     */
    #[DataProvider('provideData')]
    public function testConstruct(string $namespace, Level $level, string $template): void
    {
        $dto = new CreateLog($namespace, $level, $template);

        self::assertSame($namespace, $dto->namespace);
        self::assertSame($level, $dto->level);
        self::assertSame($template, $dto->template);
    }

    /**
     * @return iterable<array{non-empty-string, Level, non-empty-string}>
     */
    public static function provideData(): iterable
    {
        yield ['namespace', Level::Debug, 'user {id} logged in'];
        yield ['namespace', Level::Info, 'user {id} logged in'];
        yield ['namespace', Level::Notice, 'user {id} logged in'];
        yield ['namespace', Level::Warning, 'user {id} logged in'];
        yield ['namespace', Level::Error, 'user {id} logged in'];
        yield ['namespace', Level::Critical, 'user {id} logged in'];
        yield ['namespace', Level::Alert, 'user {id} logged in'];
        yield ['namespace', Level::Emergency, 'user {id} logged in'];
    }
}
