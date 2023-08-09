<?php

declare(strict_types=1);

namespace Carthage\Application\MetricCollection\Query\Gauge;

use Carthage\Application\Shared\Query\QueryInterface;
use Carthage\Domain\MetricCollection\Resource\Gauge\GaugeResource;
use Carthage\Domain\Shared\Criteria;
use Carthage\Domain\Shared\Entity\Identity;

/**
 * @implements QueryInterface<null|GaugeResource>
 */
final class GetGaugeQuery implements QueryInterface
{
    private function __construct(
        public Criteria\Criteria $criteria,
    ) {
    }

    public static function with(Criteria\Criteria $criteria): self
    {
        return new self($criteria);
    }

    public static function withIdentity(Identity $gaugeIdentity): self
    {
        return self::with(Criteria\Criteria::create(
            Criteria\Expression\Comparison::equal('id', $gaugeIdentity),
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
