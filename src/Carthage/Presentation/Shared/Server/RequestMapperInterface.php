<?php

declare(strict_types=1);

namespace Carthage\Presentation\Shared\Server;

use Psr\Http\Message\ServerRequestInterface;

interface RequestMapperInterface
{
    /**
     * @template T
     *
     * @param class-string<T> $class
     *
     * @return T|null
     */
    public function mapQueryString(ServerRequestInterface $request, string $class): ?object;

    /**
     * @template T
     *
     * @param class-string<T> $class
     *
     * @return T|null
     */
    public function mapRequestPayload(ServerRequestInterface $request, string $class): ?object;
}
