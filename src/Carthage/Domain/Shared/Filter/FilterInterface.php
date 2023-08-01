<?php

declare(strict_types=1);

namespace Carthage\Domain\Shared\Filter;

use Carthage\Domain\Shared\Criteria\Criteria;

interface FilterInterface
{
    public function getCriteria(): Criteria;

    public function getPage(): int;

    public function getItemsPerPage(): int;
}
