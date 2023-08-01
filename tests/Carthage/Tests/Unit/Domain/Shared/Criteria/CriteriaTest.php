<?php

declare(strict_types=1);

namespace Carthage\Tests\Unit\Domain\Shared\Criteria;

use Carthage\Domain\Shared\Criteria\Criteria;
use Carthage\Domain\Shared\Criteria\Enum\OrderDirection;
use Carthage\Domain\Shared\Criteria\Expression\Composition;
use Carthage\Domain\Shared\Criteria\Expression\Enum\CompositionOperator;
use Carthage\Domain\Shared\Criteria\Expression\ExpressionInterface;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

final class CriteriaTest extends TestCase
{
    public function testEmpty(): void
    {
        $criteria = Criteria::empty();

        self::assertNull($criteria->expression);
        self::assertSame([], $criteria->order);
    }

    /**
     * @throws Exception
     */
    public function testCreate(): void
    {
        $criteria = Criteria::create();

        self::assertNull($criteria->expression);
        self::assertSame([], $criteria->order);

        $criteria = Criteria::create(
            $expression = $this->createStub(ExpressionInterface::class)
        );

        self::assertSame($expression, $criteria->expression);
        self::assertSame([], $criteria->order);

        $criteria = Criteria::create(
            $expression1 = $this->createStub(ExpressionInterface::class),
            $expression2 = $this->createStub(ExpressionInterface::class),
        );

        $expression = $criteria->expression;

        self::assertInstanceOf(Composition::class, $expression);
        self::assertSame(CompositionOperator::And, $expression->operator);
        self::assertSame([$expression1, $expression2], $expression->expressions);
        self::assertSame([], $criteria->order);
    }

    public function testOrderBy(): void
    {
        $criteria = Criteria::create()
            ->orderBy('foo', OrderDirection::Ascending);

        self::assertNull($criteria->expression);
        self::assertSame(['foo' => OrderDirection::Ascending], $criteria->order);

        $criteria = Criteria::create()
            ->orderBy('foo', OrderDirection::Ascending)
            ->andOrderBy('bar', OrderDirection::Descending);

        self::assertNull($criteria->expression);
        self::assertSame(['foo' => OrderDirection::Ascending, 'bar' => OrderDirection::Descending], $criteria->order);
    }
}
