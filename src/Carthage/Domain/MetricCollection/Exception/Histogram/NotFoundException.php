<?php

declare(strict_types=1);

namespace Carthage\Domain\MetricCollection\Exception\Histogram;

use Carthage\Domain\Shared\Entity\Identity;
use Carthage\Domain\Shared\Exception\ExceptionInterface;
use DomainException;
use Psl\Str;

final class NotFoundException extends DomainException implements ExceptionInterface
{
    private const CREATING_DATA_POINT_FOR_NON_EXISTING_HISTOGRAM = 'Unable to create a data point for non-existing histogram "%s".';
    private const DELETE_NON_EXISTING_HISTOGRAM = 'Unable to delete non-existing histogram "%s".';
    private const DELETE_NON_EXISTING_HISTOGRAM_DATA_POINT = 'Unable to delete non-existing histogram data point "%s".';

    private function __construct(string $message)
    {
        parent::__construct($message);
    }

    /**
     * Creates a new NotFoundException for the case when attempting to create a data point for a non-existing histogram.
     */
    public static function whenCreatingHistogramDataPointForNonExistingHistogram(Identity $histogramIdentity): self
    {
        return new self(Str\format(self::CREATING_DATA_POINT_FOR_NON_EXISTING_HISTOGRAM, $histogramIdentity->value));
    }

    /**
     * Creates a new NotFoundException for the case when attempting to delete a non-existing histogram.
     */
    public static function whenDeletingNonExistingHistogram(Identity $histogramIdentity): self
    {
        return new self(Str\format(self::DELETE_NON_EXISTING_HISTOGRAM, $histogramIdentity->value));
    }

    /**
     * Creates a new NotFoundException for the case when attempting to delete a non-existing histogram data point.
     */
    public static function whenDeletingNonExistingHistogramDataPoint(Identity $histogramDataPointIdentity): self
    {
        return new self(Str\format(self::DELETE_NON_EXISTING_HISTOGRAM_DATA_POINT, $histogramDataPointIdentity->value));
    }
}
