<?php

declare(strict_types=1);

namespace Carthage\Domain\Shared\Filter;

use Psl\Math;

abstract class PaginationFilter implements FilterInterface
{
    public const DEFAULT_PAGE = 1;
    public const MIN_PAGE = 1;

    public const DEFAULT_ITEMS_PER_PAGE = 20;
    public const MIN_ITEMS_PER_PAGE = 1;
    public const MAX_ITEMS_PER_PAGE = 2000;

    public int $page = self::DEFAULT_PAGE;

    public int $itemsPerPage = self::DEFAULT_ITEMS_PER_PAGE;

    final public function getItemsPerPage(): int
    {
        return Math\clamp($this->itemsPerPage, self::MIN_ITEMS_PER_PAGE, self::MAX_ITEMS_PER_PAGE);
    }

    final public function getPage(): int
    {
        return Math\maxva($this->page, self::MIN_PAGE);
    }
}
