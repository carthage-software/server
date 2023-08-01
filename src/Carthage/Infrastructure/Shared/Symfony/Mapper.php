<?php

declare(strict_types=1);

namespace Carthage\Infrastructure\Shared\Symfony;

use Carthage\Presentation\Shared\Server\RequestMapperInterface;
use Closure;
use Psl\Str;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Exception\PartialDenormalizationException;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

final readonly class Mapper implements RequestMapperInterface
{
    private const INVALID_ENUM_CODE = 'ae32d13f-a3d4-423b-909a-827b961eb741';
    private const INVALID_TYPE_TEMPLATE = 'This value should be of type {{ type }}.';

    private const CONTEXT_DENORMALIZE = [
        'disable_type_enforcement' => true,
        'collect_denormalization_errors' => true,
    ];

    /**
     * @see DenormalizerInterface::COLLECT_DENORMALIZATION_ERRORS
     */
    private const CONTEXT_DESERIALIZE = [
        'collect_denormalization_errors' => true,
    ];

    public function __construct(
        private SerializerInterface&DenormalizerInterface $serializer,
        private ValidatorInterface $validator,
        private TranslatorInterface $translator,
    ) {
    }

    /**
     * @template T
     *
     * @param class-string<T> $class
     *
     * @return T|null
     */
    public function mapQueryString(ServerRequestInterface $request, string $class): ?object
    {
        if (!$data = $request->getQueryParams()) {
            return null;
        }

        return $this->validating(
            /**
             * @throws ExceptionInterface
             *
             * @return T
             */
            function () use ($data, $class): object {
                /* @var T */
                return $this->serializer->denormalize($data, $class, null, self::CONTEXT_DENORMALIZE);
            },
        );
    }

    /**
     * @template T
     *
     * @param class-string<T> $class
     *
     * @return T|null
     */
    public function mapRequestPayload(ServerRequestInterface $request, string $class): ?object
    {
        return $this->validating(
            /**
             * @throws ExceptionInterface
             *
             * @return T|null
             */
            function () use ($request, $class): ?object {
                // if the request format is not json, throw
                if ('application/json' !== $request->getHeaderLine('Content-Type')) {
                    throw new BadRequestHttpException('Invalid Content-Type header. Expected "application/json".');
                }

                $data = $request->getParsedBody();
                if (null !== $data) {
                    /* @var T */
                    return $this->serializer->denormalize($data, $class, null, self::CONTEXT_DENORMALIZE);
                }

                $data = $request->getBody()->getContents();
                if ('' === $data) {
                    return null;
                }

                /* @var T */
                return $this->serializer->deserialize($data, $class, 'json', self::CONTEXT_DESERIALIZE);
            },
        );
    }

    /**
     * @template T
     *
     * @param (Closure(): ?T) $payloadMapper
     *
     * @return T|null
     */
    private function validating(Closure $payloadMapper): ?object
    {
        $violations = new ConstraintViolationList();
        $payload = null;
        try {
            $payload = $payloadMapper();
        } catch (PartialDenormalizationException $e) {
            foreach ($e->getErrors() as $error) {
                $parameters = ['{{ type }}' => implode('|', $error->getExpectedTypes() ?? [])];
                if ($error->canUseMessageForUser()) {
                    $parameters['hint'] = $error->getMessage();
                }

                $message = $this->translator->trans(self::INVALID_TYPE_TEMPLATE, $parameters, 'validators');
                $violations->add(new ConstraintViolation($message, self::INVALID_TYPE_TEMPLATE, $parameters, null, $error->getPath(), null));
            }

            $payload = $e->getData();
        } catch (InvalidArgumentException $e) {
            if (Str\contains($e->getMessage(), 'data must belong to a backed enumeration')) {
                $violations->add(new ConstraintViolation('', '', [], null, null, null, code: self::INVALID_ENUM_CODE));
            } else {
                throw new BadRequestHttpException('Invalid request payload.', new ValidationFailedException($payload, $violations));
            }
        }

        if (null !== $payload) {
            $violations->addAll($this->validator->validate($payload));
        }

        if ($violations->count() > 0) {
            throw new BadRequestHttpException('Invalid request payload.', new ValidationFailedException($payload, $violations));
        }

        return $payload;
    }
}
