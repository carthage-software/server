<?php

declare(strict_types=1);

namespace Carthage\Tests\Unit\Domain\Shared\Criteria\Expression;

use Carthage\Domain\Shared\Criteria\Expression\Composition;
use Carthage\Domain\Shared\Criteria\Expression\Enum\CompositionOperator;
use Carthage\Domain\Shared\Criteria\Expression\ExpressionInterface;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

final class CompositionTest extends TestCase
{
    public function testEmpty(): void
    {
        $composition = Composition::empty();

        self::assertSame(CompositionOperator::And, $composition->operator);
        self::assertSame([], $composition->expressions);
    }

    /**
     * @throws Exception
     */
    public function testAnd(): void
    {
        $expression1 = $this->createStub(ExpressionInterface::class);
        $expression2 = $this->createStub(ExpressionInterface::class);

        $composition = Composition::and($expression1, $expression2);

        self::assertSame(CompositionOperator::And, $composition->operator);
        self::assertSame([$expression1, $expression2], $composition->expressions);
    }

    /**
     * @throws Exception
     */
    public function testOr(): void
    {
        $expression1 = $this->createStub(ExpressionInterface::class);
        $expression2 = $this->createStub(ExpressionInterface::class);

        $composition = Composition::or($expression1, $expression2);

        self::assertSame(CompositionOperator::Or, $composition->operator);
        self::assertSame([$expression1, $expression2], $composition->expressions);
    }
}
