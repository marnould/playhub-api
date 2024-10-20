<?php

declare(strict_types=1);

namespace Track\Domain\ValueObject;

enum SourcePlatform: string
{
    case SPOTIFY = 'login';
    case YOUTUBE = 'subscription_funnel';

    public static function getContexts(): array
    {
        return array_map(static fn ($case) => $case->value, self::cases());
    }
}
