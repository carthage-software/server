<?php

declare(strict_types=1);

namespace Carthage\Application\Shared\Resource;

use Carthage\Domain\Shared\Entity\Identity;

interface ItemResourceInterface extends ResourceInterface
{
    /**
     * Gets the ID of the RecordResource.
     */
    public function getIdentity(): Identity;
}
