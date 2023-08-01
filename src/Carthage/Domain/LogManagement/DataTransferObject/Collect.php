<?php

declare(strict_types=1);

namespace Carthage\Domain\LogManagement\DataTransferObject;

use Carthage\Domain\LogManagement\DataTransferObject\Log\CollectLog;

final class Collect
{
    /**
     * @var list<CollectLog>
     */
    public array $collectLogs;

    /**
     * @param list<CollectLog> $collectLogs
     */
    public function __construct(array $collectLogs)
    {
        $this->collectLogs = $collectLogs;
    }
}
