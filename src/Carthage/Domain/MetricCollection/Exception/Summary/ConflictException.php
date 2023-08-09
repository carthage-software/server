<?php

declare(strict_types=1);

namespace Carthage\Domain\MetricCollection\Exception\Summary;

use Carthage\Domain\Shared\Entity\Identity;
use Carthage\Domain\Shared\Exception\ExceptionInterface;
use DomainException;
use Psl\Str;

final class ConflictException extends DomainException implements ExceptionInterface
{
    private const CREATE_SUMMARY_ALREADY_EXISTS_MESSAGE = 'Unable to create summary named "%s" for namespace "%s" because it already exists ( "%s" ).';

    private function __construct(string $message)
    {
        parent::__construct($message);
    }

    /**
     * Creates a new ConflictException for the case when attempting to create a summary that already exists.
     *
     * @param non-empty-string $name the name of the summary
     * @param non-empty-string $namespace the namespace of the summary
     */
    public static function whenCreatingSummaryThatAlreadyExists(string $name, string $namespace, Identity $summaryIdentity): self
    {
        return new self(Str\format(self::CREATE_SUMMARY_ALREADY_EXISTS_MESSAGE, $name, $namespace, $summaryIdentity->value));
    }
}
