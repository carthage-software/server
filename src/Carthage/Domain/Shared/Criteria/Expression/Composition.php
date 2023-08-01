<?php

declare(strict_types=1);

namespace Carthage\Domain\Shared\Criteria\Expression;

use Carthage\Domain\Shared\Criteria\Expression\Enum\CompositionOperator;
use Psl\Vec;

final readonly class Composition implements ExpressionInterface
{
    /**
     * @param list<ExpressionInterface> $expressions
     */
    public function __construct(
        public CompositionOperator $operator,
        public array $expressions,
    ) {
    }

    public static function empty(): self
    {
        return new self(CompositionOperator::And, []);
    }

    public static function and(ExpressionInterface ...$expressions): self
    {
        return new self(CompositionOperator::And, Vec\values($expressions));
    }

    public static function or(ExpressionInterface ...$expressions): self
    {
        return new self(CompositionOperator::Or, Vec\values($expressions));
    }
}
