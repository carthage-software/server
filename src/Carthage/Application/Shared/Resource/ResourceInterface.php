<?php

declare(strict_types=1);

namespace Carthage\Application\Shared\Resource;

use JsonSerializable;

interface ResourceInterface extends JsonSerializable
{
    /**
     * Gets the type of the resource.
     *
     * @return non-empty-string
     */
    public function getType(): string;
}
