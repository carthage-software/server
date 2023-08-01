<?php

declare(strict_types=1);

namespace Carthage\Domain\Shared\Criteria\Expression\Enum;

enum ComparisonOperator
{
    case Equal;
    case NotEqual;
    case LessThan;
    case LessThanOrEqual;
    case GreaterThan;
    case GreaterThanOrEqual;
    case In;
    case NotIn;
    case Contains;
    case MemberOf;
    case StartsWith;
    case EndsWith;
}
