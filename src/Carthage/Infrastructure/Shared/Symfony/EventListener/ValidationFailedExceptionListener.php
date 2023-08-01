<?php

declare(strict_types=1);

namespace Carthage\Infrastructure\Shared\Symfony\EventListener;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Exception\ValidationFailedException;

#[AsEventListener(event: ExceptionEvent::class)]
final readonly class ValidationFailedExceptionListener
{
    public function __construct(
        private SerializerInterface $serializer,
        private bool $debug,
    ) {
    }

    public function __invoke(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        if (!$exception instanceof HttpException) {
            return;
        }

        $previous = $exception->getPrevious();
        if (!$previous instanceof ValidationFailedException) {
            return;
        }

        $result = [
            'errors' => [],
        ];

        foreach ($previous->getViolations() as $violation) {
            $code = $violation->getCode();
            if (null === $code) {
                continue;
            }

            $result['errors'][] = [
                'code' => $code,
                'field' => $violation->getPropertyPath() ?: null,
                'message' => $violation->getMessage() ?: null,
            ];
        }

        if ($this->debug) {
            $result['violations'] = $previous->getViolations();
        }

        $content = $this->serializer->serialize($result, 'json');
        $response = new JsonResponse($content, Response::HTTP_BAD_REQUEST, [], true);

        $event->setResponse($response);
        $event->stopPropagation();
    }
}
