<?php

declare(strict_types=1);

namespace Carthage\Domain\Shared\Criteria\Expression\Enum;

enum CompositionOperator
{
    case And;
    case Or;
}
