<?php

declare(strict_types=1);

namespace Carthage\Domain\LogManagement\Resource\Log;

use Carthage\Domain\Shared\Resource\ResourceInterface;

final readonly class LogEntrySourceResource implements ResourceInterface
{
    private const TYPE = 'log_entry_source';

    /**
     * @param non-empty-string $source
     */
    public function __construct(
        private string $source,
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

    /**
     * @return array{
     *   "@type": non-empty-string,
     *   "source": non-empty-string,
     * }
     */
    public function jsonSerialize(): array
    {
        return [
            '@type' => $this->getType(),
            'source' => $this->source,
        ];
    }
}
