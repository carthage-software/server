<?php

declare(strict_types=1);

namespace Carthage\Domain\MetricCollection\Exception\Gauge;

use Carthage\Domain\Shared\Exception\ExceptionInterface;
use DomainException;
use Psl\Str;
use Symfony\Component\Uid\Ulid;

final class NotFoundException extends DomainException implements ExceptionInterface
{
    private const CREATING_DATA_POINT_FOR_NON_EXISTING_GAUGE = 'Unable to create a data point for non-existing gauge "%s".';
    private const DELETE_NON_EXISTING_GAUGE = 'Unable to delete non-existing gauge "%s".';
    private const DELETE_NON_EXISTING_GAUGE_DATA_POINT = 'Unable to delete non-existing gauge data point "%s".';

    private function __construct(string $message)
    {
        parent::__construct($message);
    }

    /**
     * Creates a new NotFoundException for the case when attempting to create a data point for a non-existing gauge.
     */
    public static function whenCreatingGaugeDataPointForNonExistingGauge(Ulid $gaugeId): self
    {
        return new self(Str\format(self::CREATING_DATA_POINT_FOR_NON_EXISTING_GAUGE, $gaugeId->toBase32()));
    }

    /**
     * Creates a new NotFoundException for the case when attempting to delete a non-existing gauge.
     */
    public static function whenDeletingNonExistingGauge(Ulid $gaugeId): self
    {
        return new self(Str\format(self::DELETE_NON_EXISTING_GAUGE, $gaugeId->toBase32()));
    }

    /**
     * Creates a new NotFoundException for the case when attempting to delete a non-existing gauge data point.
     */
    public static function whenDeletingNonExistingGaugeDataPoint(Ulid $gaugeDataPointId): self
    {
        return new self(Str\format(self::DELETE_NON_EXISTING_GAUGE_DATA_POINT, $gaugeDataPointId->toBase32()));
    }
}
