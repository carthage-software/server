<?php

declare(strict_types=1);

namespace Carthage\Infrastructure\Shared\Symfony\Serializer\Normalizer;

use Carthage\Domain\Shared\Entity\Identity;
use Psl\Regex;
use Psl\Type;
use Symfony\Component\PropertyInfo\Type as SymfonyType;
use Symfony\Component\Serializer\Exception\NotNormalizableValueException;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final class IdentityNormalizer implements DenormalizerInterface, NormalizerInterface
{
    private const REGEX = '/[0-9a-f]{8}(?:-[0-9a-f]{4}){3}-[0-9a-f]{12}/i';
    private const MESSAGE = 'The data is not a valid identity string representation.';

    public function getSupportedTypes(?string $format): array
    {
        return [Identity::class => true];
    }

    public function supportsNormalization(mixed $data, ?string $format = null): bool
    {
        return $data instanceof Identity;
    }

    public function normalize(mixed $object, ?string $format = null, array $context = []): string
    {
        return Type\instance_of(Identity::class)->assert($object)->value;
    }

    public function supportsDenormalization(mixed $data, string $type, ?string $format = null): bool
    {
        return Identity::class === $type;
    }

    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): Identity
    {
        if (Type\non_empty_string()->matches($data) && Regex\matches($data, self::REGEX)) {
            return new Identity($data);
        }

        throw NotNormalizableValueException::createForUnexpectedDataType(self::MESSAGE, $data, [SymfonyType::BUILTIN_TYPE_STRING], $context['deserialization_path'] ?? null, true);
    }
}
