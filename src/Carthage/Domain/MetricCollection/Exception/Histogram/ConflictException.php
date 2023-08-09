<?php

declare(strict_types=1);

namespace Carthage\Domain\MetricCollection\Exception\Histogram;

use Carthage\Domain\Shared\Entity\Identity;
use Carthage\Domain\Shared\Exception\ExceptionInterface;
use DomainException;
use Psl\Str;

final class ConflictException extends DomainException implements ExceptionInterface
{
    private const CREATE_HISTOGRAM_ALREADY_EXISTS_MESSAGE = 'Unable to create histogram named "%s" for namespace "%s" because it already exists ( "%s" ).';

    private function __construct(string $message)
    {
        parent::__construct($message);
    }

    /**
     * Creates a new ConflictException for the case when attempting to create a histogram that already exists.
     *
     * @param non-empty-string $name the name of the histogram
     * @param non-empty-string $namespace the namespace of the histogram
     */
    public static function whenCreatingHistogramThatAlreadyExists(string $name, string $namespace, Identity $histogramIdentity): self
    {
        return new self(Str\format(self::CREATE_HISTOGRAM_ALREADY_EXISTS_MESSAGE, $name, $namespace, $histogramIdentity->value));
    }
}
