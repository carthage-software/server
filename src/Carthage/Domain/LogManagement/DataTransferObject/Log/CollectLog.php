<?php

declare(strict_types=1);

namespace Carthage\Domain\LogManagement\DataTransferObject\Log;

final class CollectLog
{
    public CreateLog $log;

    /**
     * The entries associated with the log.
     *
     * @var list<CollectLogEntry>
     */
    public array $entries = [];

    /**
     * @param CreateLog $log the log to collect
     * @param list<CollectLogEntry> $entries the entries to collect
     */
    public function __construct(CreateLog $log, array $entries = [])
    {
        $this->log = $log;
        $this->entries = $entries;
    }
}
