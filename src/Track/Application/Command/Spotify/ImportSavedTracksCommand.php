<?php

declare(strict_types=1);

namespace Track\Application\Command\Spotify;

use Core\Domain\Bus\Command\CommandInterface;

readonly class ImportSavedTracksCommand implements CommandInterface
{
    public function __construct()
    {
    }
}
