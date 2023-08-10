<?php

declare(strict_types=1);

namespace Carthage\Application\LogManagement\Resource\Log;

use Carthage\Application\Shared\Resource\ResourceInterface;

final readonly class LogEntryTagResource implements ResourceInterface
{
    private const TYPE = 'log_entry_tag';

    /**
     * @param non-empty-string $tag
     */
    public function __construct(
        private string $tag,
    ) {
    }

    /**
     * @param non-empty-string $tag
     */
    public static function fromTag(string $tag): self
    {
        return new self($tag);
    }

    public function getType(): string
    {
        return self::TYPE;
    }

    /**
     * @return array{
     *   "@type": non-empty-string,
     *   "tag": non-empty-string,
     * }
     */
    public function jsonSerialize(): array
    {
        return [
            '@type' => $this->getType(),
            'tag' => $this->tag,
        ];
    }
}
