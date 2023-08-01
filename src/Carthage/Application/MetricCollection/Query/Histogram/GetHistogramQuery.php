<?php

declare(strict_types=1);

namespace Carthage\Application\MetricCollection\Query\Histogram;

use Carthage\Application\Shared\Query\QueryInterface;
use Carthage\Domain\MetricCollection\Resource\Histogram\HistogramResource;
use Carthage\Domain\Shared\Criteria;
use Symfony\Component\Uid\Ulid;

/**
 * @implements QueryInterface<null|HistogramResource>
 */
final class GetHistogramQuery implements QueryInterface
{
    private function __construct(
        public Criteria\Criteria $criteria,
    ) {
    }

    public static function with(Criteria\Criteria $criteria): self
    {
        return new self($criteria);
    }

    public static function withId(Ulid $histogramId): self
    {
        return self::with(Criteria\Criteria::create(
            Criteria\Expression\Comparison::equal('id', $histogramId),
        ));
    }

    public static function withResourceAndName(string $resource, string $name): self
    {
        return self::with(Criteria\Criteria::create(
            Criteria\Expression\Composition::and(
                Criteria\Expression\Comparison::equal('resource', $resource),
                Criteria\Expression\Comparison::equal('name', $name),
            ),
        ));
    }
}
