<?php

declare(strict_types=1);

namespace Carthage\Domain\Shared\Criteria\Enum;

enum OrderDirection: string
{
    case Ascending = 'ASC';
    case Descending = 'DESC';
}
