<?php

declare(strict_types=1);

namespace Carthage\Infrastructure\Shared\Symfony\Messenger;

use Carthage\Application\Shared\Query\QueryInterface;
use Carthage\Application\Shared\QueryBusInterface;
use Symfony\Component\DependencyInjection\Attribute\AsAlias;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsAlias(QueryBusInterface::class)]
final class QueryBus implements QueryBusInterface
{
    use HandleTrait {
        handle as handleQuery;
    }

    public function __construct(MessageBusInterface $queryBus)
    {
        $this->messageBus = $queryBus;
    }

    /**
     * @template T
     *
     * @param QueryInterface<T> $query
     *
     * @return T
     */
    public function ask(QueryInterface $query): mixed
    {
        try {
            /* @var T */
            return $this->handleQuery($query);
        } catch (HandlerFailedException $exception) {
            throw $exception->getNestedExceptions()[0];
        }
    }
}
