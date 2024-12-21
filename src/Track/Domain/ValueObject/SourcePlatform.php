<?php

declare(strict_types=1);

namespace Track\Domain\ValueObject;

enum SourcePlatform: string
{
    case SPOTIFY = 'spotify';

    public static function getContexts(): array
    {
        return array_map(static fn ($case) => $case->value, self::cases());
    }
}
