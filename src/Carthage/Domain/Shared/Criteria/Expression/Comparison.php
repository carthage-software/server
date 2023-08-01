<?php

declare(strict_types=1);

namespace Carthage\Domain\Shared\Criteria\Expression;

final readonly class Comparison implements ExpressionInterface
{
    public function __construct(
        public string $field,
        public Enum\ComparisonOperator $operator,
        public mixed $value
    ) {
    }

    public static function equal(string $field, mixed $value): self
    {
        return new self($field, Enum\ComparisonOperator::Equal, $value);
    }

    public static function notEqual(string $field, mixed $value): self
    {
        return new self($field, Enum\ComparisonOperator::NotEqual, $value);
    }

    public static function lessThan(string $field, mixed $value): self
    {
        return new self($field, Enum\ComparisonOperator::LessThan, $value);
    }

    public static function lessThanOrEqual(string $field, mixed $value): self
    {
        return new self($field, Enum\ComparisonOperator::LessThanOrEqual, $value);
    }

    public static function greaterThan(string $field, mixed $value): self
    {
        return new self($field, Enum\ComparisonOperator::GreaterThan, $value);
    }

    public static function greaterThanOrEqual(string $field, mixed $value): self
    {
        return new self($field, Enum\ComparisonOperator::GreaterThanOrEqual, $value);
    }

    public static function in(string $field, mixed $value): self
    {
        return new self($field, Enum\ComparisonOperator::In, $value);
    }

    public static function notIn(string $field, mixed $value): self
    {
        return new self($field, Enum\ComparisonOperator::NotIn, $value);
    }

    public static function contains(string $field, mixed $value): self
    {
        return new self($field, Enum\ComparisonOperator::Contains, $value);
    }

    public static function memberOf(string $field, mixed $value): self
    {
        return new self($field, Enum\ComparisonOperator::MemberOf, $value);
    }

    public static function startsWith(string $field, mixed $value): self
    {
        return new self($field, Enum\ComparisonOperator::StartsWith, $value);
    }

    public static function endsWith(string $field, mixed $value): self
    {
        return new self($field, Enum\ComparisonOperator::EndsWith, $value);
    }
}
