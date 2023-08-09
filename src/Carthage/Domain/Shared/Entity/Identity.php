<?php

declare(strict_types=1);

namespace Carthage\Domain\Shared\Entity;

final readonly class Identity
{
    /**
     * @param non-empty-string $value
     */
    public function __construct(
        public string $value,
    ) {
    }

    /**
     * @return non-empty-string
     */
    public function __toString(): string
    {
        return $this->value;
    }
}
