<?php

declare(strict_types=1);

namespace Carthage\Application\LogManagement\Query\Log;

use Carthage\Application\Shared\Query\QueryInterface;
use Carthage\Domain\LogManagement\Resource\Log\LogEntryResource;
use Carthage\Domain\Shared\Criteria;
use Symfony\Component\Uid\Ulid;

/**
 * @implements QueryInterface<null|LogEntryResource>
 */
final class GetLogEntryQuery implements QueryInterface
{
    private function __construct(
        public Criteria\Criteria $criteria,
    ) {
    }

    public static function withId(Ulid $logEntryId): self
    {
        return self::with(Criteria\Criteria::create(
            Criteria\Expression\Comparison::equal('id', $logEntryId),
        ));
    }

    public static function with(Criteria\Criteria $criteria): self
    {
        return new self($criteria);
    }

    /**
     * @param non-empty-string $source
     */
    public static function mostRecentForLogFromSource(Ulid $logId, string $source): self
    {
        return self::with(Criteria\Criteria::create(
            Criteria\Expression\Composition::and(
                Criteria\Expression\Comparison::equal('log', $logId),
                Criteria\Expression\Comparison::equal('source', $source),
            ),
        )->orderBy('createdAt', Criteria\Enum\OrderDirection::Descending));
    }
}
