<?php

declare(strict_types=1);

namespace Carthage\Infrastructure\Shared\Doctrine\Criteria;

use Carthage\Domain\Shared\Criteria\Criteria;
use Carthage\Domain\Shared\Criteria\Enum\OrderDirection;
use Carthage\Domain\Shared\Criteria\Expression\Comparison;
use Carthage\Domain\Shared\Criteria\Expression\Composition;
use Carthage\Domain\Shared\Criteria\Expression\Enum\ComparisonOperator;
use Carthage\Domain\Shared\Criteria\Expression\Enum\CompositionOperator;
use Carthage\Domain\Shared\Criteria\Expression\ExpressionInterface;
use Carthage\Domain\Shared\Entity\Identity;
use Doctrine\Common\Collections\Criteria as DoctrineCriteria;
use Doctrine\Common\Collections\Expr\Comparison as DoctrineComparison;
use Doctrine\Common\Collections\Expr\CompositeExpression as DoctrineComposition;
use InvalidArgumentException;
use Psl\Dict;
use Psl\Vec;

final readonly class DoctrineCriteriaTransformer
{
    public static function transform(Criteria $criteria): DoctrineCriteria
    {
        $doctrine_criteria = DoctrineCriteria::create();
        if ($criteria->expression instanceof ExpressionInterface) {
            $doctrine_criteria->where(
                self::transformExpression($criteria->expression),
            );
        }

        $doctrine_criteria->orderBy(Dict\map(
            $criteria->order,
            static fn (OrderDirection $direction) => $direction->value,
        ));

        return $doctrine_criteria;
    }

    private static function transformExpression(ExpressionInterface $expression): DoctrineComparison|DoctrineComposition
    {
        if ($expression instanceof Comparison) {
            return self::transformComparison($expression);
        }

        if ($expression instanceof Composition) {
            return self::transformComposition($expression);
        }

        throw new InvalidArgumentException('Unknown expression');
    }

    private static function transformComparison(Comparison $comparison): DoctrineComparison
    {
        return match ($comparison->operator) {
            ComparisonOperator::Equal => DoctrineCriteria::expr()->eq($comparison->field, self::transformValue($comparison->value)),
            ComparisonOperator::NotEqual => DoctrineCriteria::expr()->neq($comparison->field, self::transformValue($comparison->value)),
            ComparisonOperator::LessThan => DoctrineCriteria::expr()->lt($comparison->field, self::transformValue($comparison->value)),
            ComparisonOperator::LessThanOrEqual => DoctrineCriteria::expr()->lte($comparison->field, self::transformValue($comparison->value)),
            ComparisonOperator::GreaterThan => DoctrineCriteria::expr()->gt($comparison->field, self::transformValue($comparison->value)),
            ComparisonOperator::GreaterThanOrEqual => DoctrineCriteria::expr()->gte($comparison->field, self::transformValue($comparison->value)),
            ComparisonOperator::In => DoctrineCriteria::expr()->in($comparison->field, self::transformValue($comparison->value)),
            ComparisonOperator::NotIn => DoctrineCriteria::expr()->notIn($comparison->field, self::transformValue($comparison->value)),
            ComparisonOperator::Contains => DoctrineCriteria::expr()->contains($comparison->field, self::transformValue($comparison->value)),
            ComparisonOperator::MemberOf => DoctrineCriteria::expr()->memberOf($comparison->field, self::transformValue($comparison->value)),
            ComparisonOperator::StartsWith => DoctrineCriteria::expr()->startsWith($comparison->field, self::transformValue($comparison->value)),
            ComparisonOperator::EndsWith => DoctrineCriteria::expr()->endsWith($comparison->field, self::transformValue($comparison->value)),
        };
    }

    private static function transformComposition(Composition $composite): DoctrineComposition
    {
        return match ($composite->operator) {
            CompositionOperator::And => DoctrineCriteria::expr()->andX(...Vec\map(
                $composite->expressions,
                self::transformExpression(...),
            )),
            CompositionOperator::Or => DoctrineCriteria::expr()->orX(...Vec\map(
                $composite->expressions,
                self::transformExpression(...),
            )),
        };
    }

    private static function transformValue(mixed $value): mixed
    {
        if ($value instanceof Identity) {
            return $value->value;
        }

        return $value;
    }
}
