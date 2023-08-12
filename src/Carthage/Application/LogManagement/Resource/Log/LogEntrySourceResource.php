<?php

declare(strict_types=1);

namespace Carthage\Application\LogManagement\Resource\Log;

use Carthage\Application\Shared\Resource\ResourceInterface;

final readonly class LogEntrySourceResource implements ResourceInterface
{
    private const TYPE = 'log_entry_source';

    /**
     * @param non-empty-string $source
     */
    public function __construct(
        public string $source,
    ) {
    }

    /**
     * @param non-empty-string $source
     */
    public static function fromSource(string $source): self
    {
        return new self($source);
    }

    public function getType(): string
    {
        return self::TYPE;
    }
}
