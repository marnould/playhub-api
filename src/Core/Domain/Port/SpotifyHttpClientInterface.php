<?php

declare(strict_types=1);

namespace Core\Domain\Port;

interface SpotifyHttpClientInterface
{
    public function getSavedTracks(int $offset, int $limit): array;
}
