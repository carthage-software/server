<?php

declare(strict_types=1);

namespace Carthage\Domain\LogManagement\DataTransferObject\Log;

use Carthage\Domain\LogManagement\Enum\Log\Level;

final class CreateLog
{
    /**
     * The namespace associated with the log.
     *
     * @var non-empty-string
     */
    public string $namespace;

    /**
     * The severity level of the log.
     */
    public Level $level;

    /**
     * The template used for formatting the log message.
     *
     * @var non-empty-string
     */
    public string $template;

    /**
     * @param non-empty-string $namespace the namespace associated with the log
     * @param Level $level the severity level of the log
     * @param non-empty-string $template the template used for formatting the log message
     */
    public function __construct(string $namespace, Level $level, string $template)
    {
        $this->namespace = $namespace;
        $this->level = $level;
        $this->template = $template;
    }
}
