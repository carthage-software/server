<?php

declare(strict_types=1);

namespace Carthage\Infrastructure\Shared\Symfony\Messenger;

use Carthage\Application\Shared\Command\CommandInterface;
use Carthage\Application\Shared\CommandBusInterface;
use Symfony\Component\DependencyInjection\Attribute\AsAlias;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\DispatchAfterCurrentBusStamp;
use Throwable;

#[AsAlias(CommandBusInterface::class)]
final readonly class CommandBus implements CommandBusInterface
{
    public function __construct(
        private MessageBusInterface $commandBus,
    ) {
    }

    /**
     * @throws Throwable
     */
    public function dispatch(CommandInterface $command): void
    {
        try {
            $this->commandBus->dispatch($command, [
                new DispatchAfterCurrentBusStamp(),
            ]);
        } catch (HandlerFailedException $exception) {
            throw $exception->getNestedExceptions()[0];
        }
    }
}
