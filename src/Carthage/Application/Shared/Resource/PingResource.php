<?php

declare(strict_types=1);

namespace Carthage\Application\Shared\Resource;

use DateTimeImmutable;

final readonly class PingResource implements ResourceInterface
{
    private const TYPE = 'ping';

    /**
     * @param non-empty-string $quote
     */
    public function __construct(
        public string $quote,
        public DateTimeImmutable $time,
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
}
