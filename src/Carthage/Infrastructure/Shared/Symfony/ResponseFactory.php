<?php

declare(strict_types=1);

namespace Carthage\Infrastructure\Shared\Symfony;

use Carthage\Application\Shared\Resource\ResourceInterface;
use Carthage\Presentation\Shared\Server\HttpStatus;
use Carthage\Presentation\Shared\Server\ResponseFactoryInterface;
use Psr\Http\Message\ResponseFactoryInterface as PsrResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Symfony\Component\DependencyInjection\Attribute\AsAlias;
use Symfony\Component\Serializer\Encoder\EncoderInterface;
use Symfony\Component\Serializer\SerializerInterface;

#[AsAlias(ResponseFactoryInterface::class)]
final readonly class ResponseFactory implements ResponseFactoryInterface
{
    private const JSON_CONTENT_TYPE = 'application/json';

    public function __construct(
        private SerializerInterface&EncoderInterface $serializer,
        private StreamFactoryInterface $streamFactory,
        private PsrResponseFactoryInterface $responseFactory,
    ) {
    }

    public function createResponse(int|HttpStatus $code = HttpStatus::Ok, string $reasonPhrase = ''): ResponseInterface
    {
        return $this->responseFactory->createResponse($this->getStatus($code), $reasonPhrase);
    }

    public function createEncodedResponse(mixed $data, int|HttpStatus $code = HttpStatus::Ok): ResponseInterface
    {
        $json = $this->serializer->encode($data, 'json');

        $stream = $this->streamFactory->createStream($json);

        return $this->responseFactory->createResponse($this->getStatus($code))
            ->withBody($stream)
            ->withHeader('Content-Type', self::JSON_CONTENT_TYPE)
        ;
    }

    public function createResourceResponse(ResourceInterface $resource, int|HttpStatus $code = HttpStatus::Ok): ResponseInterface
    {
        $json = $this->serializer->serialize($resource, 'json');

        $stream = $this->streamFactory->createStream($json);

        return $this->responseFactory->createResponse($this->getStatus($code))
            ->withBody($stream)
            ->withHeader('Content-Type', self::JSON_CONTENT_TYPE)
        ;
    }

    private function getStatus(int|HttpStatus $code): int
    {
        return $code instanceof HttpStatus ? $code->value : $code;
    }
}
