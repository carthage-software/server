<?php

declare(strict_types=1);

namespace Carthage\Domain\MetricCollection\Exception\Summary;

use Carthage\Domain\Shared\Exception\ExceptionInterface;
use DomainException;
use Psl\Str;
use Symfony\Component\Uid\Ulid;

final class NotFoundException extends DomainException implements ExceptionInterface
{
    private const CREATING_SUMMARY_DATA_POINT_FOR_NON_EXISTING_SUMMARY = 'Unable to create a summary data point for non-existing summary "%s".';
    private const DELETE_NON_EXISTING_SUMMARY = 'Unable to delete non-existing summary "%s".';
    private const DELETE_NON_EXISTING_SUMMARY_DATA_POINT = 'Unable to delete non-existing summary data point "%s".';

    private function __construct(string $message)
    {
        parent::__construct($message);
    }

    /**
     * Creates a new NotFoundException for the case when attempting to create a summary data point for a non-existing summary.
     */
    public static function whenCreatingSummaryDataPointForNonExistingSummary(Ulid $summaryId): self
    {
        return new self(Str\format(self::CREATING_SUMMARY_DATA_POINT_FOR_NON_EXISTING_SUMMARY, $summaryId->toBase32()));
    }

    /**
     * Creates a new NotFoundException for the case when attempting to delete a non-existing summary.
     */
    public static function whenDeletingNonExistingSummary(Ulid $summaryId): self
    {
        return new self(Str\format(self::DELETE_NON_EXISTING_SUMMARY, $summaryId->toBase32()));
    }

    /**
     * Creates a new NotFoundException for the case when attempting to delete a non-existing summary data point.
     */
    public static function whenDeletingNonExistingSummaryDataPoint(Ulid $summaryDataPointId): self
    {
        return new self(Str\format(self::DELETE_NON_EXISTING_SUMMARY_DATA_POINT, $summaryDataPointId->toBase32()));
    }
}
