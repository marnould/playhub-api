<?php

declare(strict_types=1);

namespace Track\Domain\Repository;

use Track\Domain\Entity\Album;

interface AlbumRepositoryInterface
{
    public function findOneOrNullByTitle(string $title): ?Album;

    public function findAll(): array;

    public function save(Album $album, bool $flush = true): void;
}
