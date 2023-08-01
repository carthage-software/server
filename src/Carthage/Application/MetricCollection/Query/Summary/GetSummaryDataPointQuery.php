<?php

declare(strict_types=1);

namespace Carthage\Application\MetricCollection\Query\Summary;

use Carthage\Application\Shared\Query\QueryInterface;
use Carthage\Domain\MetricCollection\Resource\Summary\SummaryDataPointResource;
use Carthage\Domain\Shared\Criteria;
use Symfony\Component\Uid\Ulid;

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

    public static function withId(Ulid $summaryDataPointId): self
    {
        return self::with(Criteria\Criteria::create(
            Criteria\Expression\Comparison::equal('id', $summaryDataPointId),
        ));
    }

    public static function mostRecentForSummaryFromSource(Ulid $summary, string $source): self
    {
        return self::with(Criteria\Criteria::create(
            Criteria\Expression\Comparison::equal('metric', $summary),
            Criteria\Expression\Comparison::equal('source', $source),
        )->orderBy('createdAt', Criteria\Enum\OrderDirection::Descending));
    }
}
