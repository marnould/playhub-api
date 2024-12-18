<?php

declare(strict_types=1);

namespace Track\Domain\Repository;

use Track\Domain\Entity\Artist;

interface ArtistRepositoryInterface
{
    public function findOneOrNullByName(string $name): ?Artist;

    public function findAll(): array;

    public function save(Artist $artist, bool $flush = true): void;
}
