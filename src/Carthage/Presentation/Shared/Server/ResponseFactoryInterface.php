<?php

declare(strict_types=1);

namespace Carthage\Presentation\Shared\Server;

use Carthage\Application\Shared\Resource\ResourceInterface;
use Psr\Http\Message\ResponseFactoryInterface as PsrResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;

interface ResponseFactoryInterface extends PsrResponseFactoryInterface
{
    public function createResponse(int|HttpStatus $code = HttpStatus::Ok, string $reasonPhrase = ''): ResponseInterface;

    public function createEncodedResponse(mixed $data, int|HttpStatus $code = HttpStatus::Ok): ResponseInterface;

    public function createResourceResponse(ResourceInterface $resource, int|HttpStatus $code = HttpStatus::Ok): ResponseInterface;
}
