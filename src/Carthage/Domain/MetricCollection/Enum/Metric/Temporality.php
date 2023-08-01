<?php

declare(strict_types=1);

namespace Carthage\Domain\MetricCollection\Enum\Metric;

use JsonSerializable;

enum Temporality: string implements JsonSerializable
{
    case Delta = 'DELTA';
    case Cumulative = 'CUMULATIVE';

    /**
     * @return array{
     *     "name": non-empty-string,
     *     "value": non-empty-string
     * }
     */
    public function jsonSerialize(): array
    {
        return [
            'name' => $this->name,
            'value' => $this->value,
        ];
    }
}
