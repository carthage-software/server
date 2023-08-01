<?php

declare(strict_types=1);

namespace Carthage\Application\MetricCollection\Query\Histogram;

use Carthage\Application\Shared\Query\QueryInterface;
use Carthage\Domain\MetricCollection\Resource\Histogram\HistogramDataPointResource;
use Carthage\Domain\Shared\Criteria;
use Symfony\Component\Uid\Ulid;

/**
 * @implements QueryInterface<null|HistogramDataPointResource>
 */
final class GetHistogramDataPointQuery implements QueryInterface
{
    private function __construct(
        public Criteria\Criteria $criteria,
    ) {
    }

    public static function with(Criteria\Criteria $criteria): self
    {
        return new self($criteria);
    }

    public static function withId(Ulid $histogramDataPointId): self
    {
        return self::with(Criteria\Criteria::create(
            Criteria\Expression\Comparison::equal('id', $histogramDataPointId),
        ));
    }

    public static function mostRecentForHistogramFromSource(Ulid $histogram, string $source): self
    {
        return self::with(Criteria\Criteria::create(
            Criteria\Expression\Comparison::equal('metric', $histogram),
            Criteria\Expression\Comparison::equal('source', $source),
        )->orderBy('createdAt', Criteria\Enum\OrderDirection::Descending));
    }
}
