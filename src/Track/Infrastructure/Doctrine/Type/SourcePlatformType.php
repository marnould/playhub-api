<?php

declare(strict_types=1);

namespace Track\Infrastructure\Doctrine\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\StringType;
use Track\Domain\ValueObject\SourcePlatform;

final class SourcePlatformType extends StringType
{
    private const NAME = 'source_platform_type';

    public function convertToPHPValue($value, AbstractPlatform $platform): SourcePlatform
    {
        if ($value instanceof SourcePlatform) {
            return $value;
        }

        try {
            return SourcePlatform::from($value);
        } catch (\InvalidArgumentException) {
            throw new ConversionException();
        }
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        if ($value instanceof SourcePlatform) {
            return $value->value;
        }

        try {
            return SourcePlatform::from($value)->value;
        } catch (\InvalidArgumentException) {
            throw new ConversionException();
        }
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
