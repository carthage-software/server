<?php

declare(strict_types=1);

namespace Carthage\Application\MetricCollection\Query\Gauge;

use Carthage\Application\Shared\Query\QueryInterface;
use Carthage\Domain\MetricCollection\Resource\Gauge\GaugeDataPointResource;
use Carthage\Domain\Shared\Criteria;
use Symfony\Component\Uid\Ulid;

/**
 * @implements QueryInterface<null|GaugeDataPointResource>
 */
final class GetGaugeDataPointQuery implements QueryInterface
{
    private function __construct(
        public Criteria\Criteria $criteria,
    ) {
    }

    public static function with(Criteria\Criteria $criteria): self
    {
        return new self($criteria);
    }

    public static function withId(Ulid $gaugeDataPointId): self
    {
        return self::with(Criteria\Criteria::create(
            Criteria\Expression\Comparison::equal('id', $gaugeDataPointId),
        ));
    }

    public static function mostRecentForGaugeFromSource(Ulid $gauge, string $source): self
    {
        return self::with(Criteria\Criteria::create(
            Criteria\Expression\Comparison::equal('metric', $gauge),
            Criteria\Expression\Comparison::equal('source', $source),
        )->orderBy('createdAt', Criteria\Enum\OrderDirection::Descending));
    }
}
