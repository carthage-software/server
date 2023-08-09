<?php

declare(strict_types=1);

namespace Carthage\Infrastructure\Shared\Doctrine\Types;

use Carthage\Domain\Shared\Entity\Identity;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;

use function is_string;

final class IdentityType extends Type
{
    private const NAME = 'identity';

    /**
     * {@inheritDoc}
     */
    public function getName(): string
    {
        return self::NAME;
    }

    /**
     * {@inheritDoc}
     */
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getGuidTypeDeclarationSQL($column);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if ($value instanceof Identity || null === $value) {
            return $value;
        }

        if (!is_string($value) || '' === $value) {
            throw ConversionException::conversionFailedInvalidType($value, self::NAME, ['null', 'non-empty-string', Identity::class]);
        }

        return new Identity($value);
    }

    /**
     * {@inheritDoc}
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value instanceof Identity) {
            return $value->value;
        }

        if (null === $value || '' === $value) {
            return null;
        }

        if (is_string($value)) {
            return $value;
        }

        throw ConversionException::conversionFailedInvalidType($value, self::NAME, ['null', 'non-empty-string', Identity::class]);
    }
}
