<?php

declare(strict_types=1);

namespace Core\Infrastructure\Doctrine\Type;

use Core\Domain\ValueObject\Source;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\StringType;

final class SourceType extends StringType
{
    private const NAME = 'core_source_type';

    public function convertToPHPValue($value, AbstractPlatform $platform): Source
    {
        if ($value instanceof Source) {
            return $value;
        }

        try {
            return Source::from($value);
        } catch (\InvalidArgumentException) {
            throw new ConversionException();
        }
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        if ($value instanceof Source) {
            return $value->value;
        }

        try {
            return Source::from($value)->value;
        } catch (\InvalidArgumentException) {
            throw new ConversionException();
        }
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
