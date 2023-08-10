<?php

declare(strict_types=1);

namespace Carthage\Application\MetricCollection\Query\Summary;

use Carthage\Application\MetricCollection\Resource\Summary\SummaryDataPointResource;
use Carthage\Application\Shared\Query\QueryInterface;
use Carthage\Domain\Shared\Criteria;
use Carthage\Domain\Shared\Entity\Identity;

/**
 * @implements QueryInterface<null|SummaryDataPointResource>
 */
final class GetSummaryDataPointQuery implements QueryInterface
{
    private function __construct(
        public Criteria\Criteria $criteria,
    ) {
    }

    public static function with(Criteria\Criteria $criteria): self
    {
        return new self($criteria);
    }

    public static function withIdentity(Identity $summaryDataPointIdentity): self
    {
        return self::with(Criteria\Criteria::create(
            Criteria\Expression\Comparison::equal('id', $summaryDataPointIdentity),
        ));
    }

    public static function mostRecentForSummaryFromSource(Identity $summaryIdentity, string $source): self
    {
        return self::with(Criteria\Criteria::create(
            Criteria\Expression\Comparison::equal('metric', $summaryIdentity),
            Criteria\Expression\Comparison::equal('source', $source),
        )->orderBy('createdAt', Criteria\Enum\OrderDirection::Descending));
    }
}
