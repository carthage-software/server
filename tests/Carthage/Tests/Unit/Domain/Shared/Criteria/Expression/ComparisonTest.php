<?php

declare(strict_types=1);

namespace Carthage\Tests\Unit\Domain\Shared\Criteria\Expression;

use Carthage\Domain\Shared\Criteria\Expression\Comparison;
use Carthage\Domain\Shared\Criteria\Expression\Enum\ComparisonOperator;
use PHPUnit\Framework\TestCase;

final class ComparisonTest extends TestCase
{
    public function testEqual(): void
    {
        $comparison = Comparison::equal('foo', 'bar');

        self::assertSame('foo', $comparison->field);
        self::assertSame(ComparisonOperator::Equal, $comparison->operator);
        self::assertSame('bar', $comparison->value);
    }

    public function testNotEqual(): void
    {
        $comparison = Comparison::notEqual('foo', 'bar');

        self::assertSame('foo', $comparison->field);
        self::assertSame(ComparisonOperator::NotEqual, $comparison->operator);
        self::assertSame('bar', $comparison->value);
    }

    public function testGreaterThan(): void
    {
        $comparison = Comparison::greaterThan('foo', 'bar');

        self::assertSame('foo', $comparison->field);
        self::assertSame(ComparisonOperator::GreaterThan, $comparison->operator);
        self::assertSame('bar', $comparison->value);
    }

    public function testGreaterThanOrEqual(): void
    {
        $comparison = Comparison::greaterThanOrEqual('foo', 'bar');

        self::assertSame('foo', $comparison->field);
        self::assertSame(ComparisonOperator::GreaterThanOrEqual, $comparison->operator);
        self::assertSame('bar', $comparison->value);
    }

    public function testLessThan(): void
    {
        $comparison = Comparison::lessThan('foo', 'bar');

        self::assertSame('foo', $comparison->field);
        self::assertSame(ComparisonOperator::LessThan, $comparison->operator);
        self::assertSame('bar', $comparison->value);
    }

    public function testLessThanOrEqual(): void
    {
        $comparison = Comparison::lessThanOrEqual('foo', 'bar');

        self::assertSame('foo', $comparison->field);
        self::assertSame(ComparisonOperator::LessThanOrEqual, $comparison->operator);
        self::assertSame('bar', $comparison->value);
    }

    public function testIn(): void
    {
        $comparison = Comparison::in('foo', ['bar', 'baz']);

        self::assertSame('foo', $comparison->field);
        self::assertSame(ComparisonOperator::In, $comparison->operator);
        self::assertSame(['bar', 'baz'], $comparison->value);
    }

    public function testNotIn(): void
    {
        $comparison = Comparison::notIn('foo', ['bar', 'baz']);

        self::assertSame('foo', $comparison->field);
        self::assertSame(ComparisonOperator::NotIn, $comparison->operator);
        self::assertSame(['bar', 'baz'], $comparison->value);
    }

    public function testContains(): void
    {
        $comparison = Comparison::contains('foo', 'bar');

        self::assertSame('foo', $comparison->field);
        self::assertSame(ComparisonOperator::Contains, $comparison->operator);
        self::assertSame('bar', $comparison->value);
    }

    public function testMemberOf(): void
    {
        $comparison = Comparison::memberOf('foo', 'bar');

        self::assertSame('foo', $comparison->field);
        self::assertSame(ComparisonOperator::MemberOf, $comparison->operator);
        self::assertSame('bar', $comparison->value);
    }

    public function testStartsWith(): void
    {
        $comparison = Comparison::startsWith('foo', 'bar');

        self::assertSame('foo', $comparison->field);
        self::assertSame(ComparisonOperator::StartsWith, $comparison->operator);
        self::assertSame('bar', $comparison->value);
    }

    public function testEndsWith(): void
    {
        $comparison = Comparison::endsWith('foo', 'bar');

        self::assertSame('foo', $comparison->field);
        self::assertSame(ComparisonOperator::EndsWith, $comparison->operator);
        self::assertSame('bar', $comparison->value);
    }
}
