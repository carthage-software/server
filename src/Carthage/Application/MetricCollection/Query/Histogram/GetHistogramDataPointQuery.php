<?php

declare(strict_types=1);

namespace Carthage\Application\MetricCollection\Query\Histogram;

use Carthage\Application\MetricCollection\Resource\Histogram\HistogramDataPointResource;
use Carthage\Application\Shared\Query\QueryInterface;
use Carthage\Domain\Shared\Criteria;
use Carthage\Domain\Shared\Entity\Identity;

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

    public static function withIdentity(Identity $histogramDataPointIdentity): self
    {
        return self::with(Criteria\Criteria::create(
            Criteria\Expression\Comparison::equal('id', $histogramDataPointIdentity),
        ));
    }

    public static function mostRecentForHistogramFromSource(Identity $histogramIdentity, string $source): self
    {
        return self::with(Criteria\Criteria::create(
            Criteria\Expression\Comparison::equal('metric', $histogramIdentity),
            Criteria\Expression\Comparison::equal('source', $source),
        )->orderBy('createdAt', Criteria\Enum\OrderDirection::Descending));
    }
}
