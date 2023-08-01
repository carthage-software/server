<?php

declare(strict_types=1);

namespace Carthage\Domain\LogManagement\Exception\Log;

use Carthage\Domain\LogManagement\Enum\Log\Level;
use Carthage\Domain\Shared\Exception\ExceptionInterface;
use DomainException;
use Psl\Str;
use Symfony\Component\Uid\Ulid;

final class ConflictException extends DomainException implements ExceptionInterface
{
    private const CREATE_LOG_ALREADY_EXISTS_MESSAGE = 'Unable to create log of namespace "%s", level "%s", and template "%s" because it already exists ( "%s" ).';

    private function __construct(string $message)
    {
        parent::__construct($message);
    }

    /**
     * Creates a new ConflictException for the case when attempting to create a log that already exists.
     *
     * @param Ulid $logId the identifier of the log
     * @param non-empty-string $namespace the namespace of the log
     * @param Level $level the level of the log
     * @param non-empty-string $template the template of the log
     */
    public static function whenCreatingMessageThatAlreadyExists(Ulid $logId, string $namespace, Level $level, string $template): self
    {
        return new self(Str\format(self::CREATE_LOG_ALREADY_EXISTS_MESSAGE, $namespace, $level->value, $template, $logId->toBase32()));
    }
}
