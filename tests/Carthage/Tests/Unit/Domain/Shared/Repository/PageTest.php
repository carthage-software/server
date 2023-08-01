<?php

declare(strict_types=1);

namespace Carthage\Tests\Unit\Domain\Shared\Repository;

use Carthage\Domain\Shared\Repository\Page;
use PHPUnit\Framework\TestCase;
use stdClass;

final class PageTest extends TestCase
{
    public function testHasPrevious(): void
    {
        $object = new stdClass();

        $page = new Page(items: [$object], count: 1, page: 1, totalItems: 1, itemsPerPage: 1);

        self::assertFalse($page->hasPrevious());

        $page = new Page(items: [$object], count: 1, page: 2, totalItems: 2, itemsPerPage: 1);

        self::assertTrue($page->hasPrevious());
    }

    public function testGetPrevious(): void
    {
        $object = new stdClass();

        $page = new Page(items: [$object], count: 1, page: 1, totalItems: 1, itemsPerPage: 1);

        self::assertNull($page->getPrevious());

        $page = new Page(items: [$object], count: 1, page: 2, totalItems: 2, itemsPerPage: 1);

        self::assertSame(1, $page->getPrevious());
    }

    public function testHasNext(): void
    {
        $object = new stdClass();

        $page = new Page(items: [$object], count: 1, page: 1, totalItems: 1, itemsPerPage: 1);

        self::assertFalse($page->hasNext());

        $page = new Page(items: [$object], count: 1, page: 1, totalItems: 2, itemsPerPage: 1);

        self::assertTrue($page->hasNext());
    }

    public function testGetNext(): void
    {
        $object = new stdClass();

        $page = new Page(items: [$object], count: 1, page: 1, totalItems: 1, itemsPerPage: 1);

        self::assertNull($page->getNext());

        $page = new Page(items: [$object], count: 1, page: 1, totalItems: 2, itemsPerPage: 1);

        self::assertSame(2, $page->getNext());
    }

    public function testGetFirstPage(): void
    {
        $object = new stdClass();

        $page = new Page(items: [$object], count: 1, page: 1, totalItems: 1, itemsPerPage: 1);

        self::assertSame(1, $page->getFirst());

        $page = new Page(items: [$object], count: 1, page: 2, totalItems: 2, itemsPerPage: 1);

        self::assertSame(1, $page->getFirst());
    }

    public function testGetLastPage(): void
    {
        $object = new stdClass();

        $page = new Page(items: [$object], count: 1, page: 1, totalItems: 1, itemsPerPage: 1);

        self::assertSame(1, $page->getLast());

        $page = new Page(items: [$object], count: 1, page: 1, totalItems: 2, itemsPerPage: 1);

        self::assertSame(2, $page->getLast());
    }

    public function testGetIterator(): void
    {
        $object = new stdClass();

        $page = new Page(items: [$object], count: 1, page: 1, totalItems: 1, itemsPerPage: 1);

        self::assertSame([$object], iterator_to_array($page->getIterator()));
    }

    public function testCount(): void
    {
        $object = new stdClass();

        $page = new Page(items: [$object], count: 1, page: 1, totalItems: 1, itemsPerPage: 1);

        self::assertSame(1, $page->count());
    }
}
