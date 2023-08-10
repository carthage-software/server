<?php

declare(strict_types=1);

namespace Carthage\Domain\LogManagement\Enum\Log;

use JsonSerializable;

/**
 * The Level enum represents the various log levels in line with the RFC-5424 specifications.
 *
 * It also implements the JsonSerializable interface, which enables instances of this class
 * to be converted to a format suitable for JSON encoding.
 */
enum Level: int implements JsonSerializable
{
    /**
     * Detailed debug information.
     */
    case Debug = 100;

    /**
     * Interesting events.
     *
     * Example: User logs in, SQL logs.
     */
    case Info = 200;

    /**
     * Normal but significant events.
     */
    case Notice = 250;

    /**
     * Exceptional occurrences that are not errors.
     *
     * Example: Use of deprecated APIs, poor use of an API, undesirable things
     * that are not necessarily wrong.
     */
    case Warning = 300;

    /**
     * Runtime errors that do not require immediate action but should typically
     * be logged and monitored.
     */
    case Error = 400;

    /**
     * Critical conditions.
     *
     * Example: Application component unavailable, unexpected exception..
     */
    case Critical = 500;

    /**
     * Action must be taken immediately.
     *
     * Example: Entire website down, database unavailable, etc.
     *
     * This should trigger the SMS alerts and wake you up.
     */
    case Alert = 550;

    /**
     * The system is unusable.
     */
    case Emergency = 600;

    /**
     * Provides a JSON-serializable version of the Level instance.
     *
     * It returns an associative array that includes the name of the enum case and its associated value.
     *
     * @return array{
     *      "name": non-empty-string,
     *      "value": positive-int
     *  }
     */
    public function jsonSerialize(): array
    {
        return [
            'name' => $this->name,
            'value' => $this->value,
        ];
    }
}
