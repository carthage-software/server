<?php

declare(strict_types=1);

namespace Carthage\Application\MetricCollection\Resource\Metric;

use Carthage\Application\Shared\Resource\ResourceInterface;

final readonly class MetricNamespaceResource implements ResourceInterface
{
    private const TYPE = 'metric_namespace';

    /**
     * @param non-empty-string $namespace
     */
    public function __construct(
        public string $namespace,
    ) {
    }

    /**
     * @param non-empty-string $namespace
     */
    public static function fromNamespace(string $namespace): self
    {
        return new self($namespace);
    }

    public function getType(): string
    {
        return self::TYPE;
    }
}
