<?php

declare(strict_types=1);

namespace Carthage\Application\LogManagement\Resource\Log;

use Carthage\Application\Shared\Resource\ResourceInterface;

final readonly class LogNamespaceResource implements ResourceInterface
{
    private const TYPE = 'log_namespace';

    /**
     * @param non-empty-string $namespace
     */
    public function __construct(
        private string $namespace,
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

    /**
     * @return array{
     *   "type": non-empty-string,
     *   "namespace": non-empty-string,
     * }
     */
    public function jsonSerialize(): array
    {
        return [
            'type' => $this->getType(),
            'namespace' => $this->namespace,
        ];
    }
}
