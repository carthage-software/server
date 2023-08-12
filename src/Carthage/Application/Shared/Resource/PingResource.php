<?php

declare(strict_types=1);

namespace Carthage\Application\Shared\Resource;

use DateTimeImmutable;
use DateTimeInterface;

final readonly class PingResource implements ResourceInterface
{
    private const TYPE = 'ping';

    /**
     * @param non-empty-string $quote
     */
    public function __construct(
        private string            $quote,
        private DateTimeImmutable $time,
    ) {
    }

    /**
     * @param non-empty-string $quote
     */
    public static function fromQuoteAndTime(string $quote, DateTimeImmutable $time): self
    {
        return new self($quote, $time);
    }

    public function getType(): string
    {
        return self::TYPE;
    }

    /**
     * @return array{
     *   "@type": non-empty-string,
     *   "quote": non-empty-string,
     *   "time": non-empty-string,
     * }
     */
    public function jsonSerialize(): array
    {
        return [
            '@type' => $this->getType(),
            'quote' => $this->quote,
            'time' => $this->time->format(DateTimeInterface::RFC3339_EXTENDED)
        ];
    }
}
