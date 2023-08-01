<?php

declare(strict_types=1);

namespace Carthage\Domain\Shared\Resource;

use Symfony\Component\Uid\Ulid;

interface ItemResourceInterface extends ResourceInterface
{
    /**
     * Gets the ID of the RecordResource.
     */
    public function getIdentity(): Ulid;
}
