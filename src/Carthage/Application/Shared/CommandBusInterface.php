<?php

declare(strict_types=1);

namespace Carthage\Application\Shared;

use Carthage\Application\Shared\Command\CommandInterface;

interface CommandBusInterface
{
    public function dispatch(CommandInterface $command): void;
}
