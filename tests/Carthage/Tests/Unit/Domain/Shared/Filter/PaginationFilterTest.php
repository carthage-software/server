<?php

declare(strict_types=1);

namespace Carthage\Tests\Unit\Domain\Shared\Filter;

use Carthage\Domain\Shared\Criteria\Criteria;
use Carthage\Domain\Shared\Filter\PaginationFilter;
use PHPUnit\Framework\TestCase;

final class PaginationFilterTest extends TestCase
{
    public function testGetItemsPerPage(): void
    {
        $filter = new class() extends PaginationFilter {
            public function getCriteria(): Criteria
            {
                return Criteria::empty();
            }
        };

        self::assertSame(PaginationFilter::DEFAULT_ITEMS_PER_PAGE, $filter->getItemsPerPage());

        $filter->itemsPerPage = 10;

        self::assertSame(10, $filter->getItemsPerPage());
    }

    public function testGetItemsPerPageOutOfBound(): void
    {
        $filter = new class() extends PaginationFilter {
            public function getCriteria(): Criteria
            {
                return Criteria::empty();
            }
        };

        $filter->itemsPerPage = PaginationFilter::MIN_ITEMS_PER_PAGE - 1;

        self::assertSame(PaginationFilter::MIN_ITEMS_PER_PAGE, $filter->getItemsPerPage());

        $filter->itemsPerPage = PaginationFilter::MAX_ITEMS_PER_PAGE + 1;

        self::assertSame(PaginationFilter::MAX_ITEMS_PER_PAGE, $filter->getItemsPerPage());
    }

    public function testGetPage(): void
    {
        $filter = new class() extends PaginationFilter {
            public function getCriteria(): Criteria
            {
                return Criteria::empty();
            }
        };

        self::assertSame(PaginationFilter::DEFAULT_PAGE, $filter->getPage());

        $filter->page = 10;

        self::assertSame(10, $filter->getPage());
    }

    public function testGetPageOutOfBound(): void
    {
        $filter = new class() extends PaginationFilter {
            public function getCriteria(): Criteria
            {
                return Criteria::empty();
            }
        };

        $filter->page = PaginationFilter::MIN_PAGE - 1;

        self::assertSame(PaginationFilter::MIN_PAGE, $filter->getPage());
    }
}
