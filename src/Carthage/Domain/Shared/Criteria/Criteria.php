<?php

declare(strict_types=1);

namespace Carthage\Domain\Shared\Criteria;

use Carthage\Domain\Shared\Criteria\Enum\OrderDirection;
use Carthage\Domain\Shared\Criteria\Expression\Composition;
use Carthage\Domain\Shared\Criteria\Expression\ExpressionInterface;
use Psl\Iter;

final readonly class Criteria
{
    /**
     * @param array<string, OrderDirection> $order
     */
    private function __construct(
        public ?ExpressionInterface $expression = null,
        public array $order = [],
    ) {
    }

    public static function empty(): self
    {
        return new self(null);
    }

    public static function create(ExpressionInterface ...$expressions): self
    {
        return new self(match (Iter\count($expressions)) {
            0 => null,
            1 => $expressions[0],
            default => Composition::and(...$expressions),
        });
    }

    public function orderBy(string $field, OrderDirection $direction): self
    {
        return new self($this->expression, [$field => $direction]);
    }

    public function andOrderBy(string $field, OrderDirection $direction): self
    {
        return new self($this->expression, [...$this->order, $field => $direction]);
    }

    public function merge(self $criteria): self
    {
        if (null === $this->expression) {
            $expression = $criteria->expression;
        } elseif (null === $criteria->expression) {
            $expression = $this->expression;
        } else {
            $expression = Composition::and($this->expression, $criteria->expression);
        }

        return new self($expression, [...$this->order, ...$criteria->order]);
    }
}
