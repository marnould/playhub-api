<?php

declare(strict_types=1);

namespace Track\Domain\Repository;

use Ramsey\Uuid\UuidInterface;
use Track\Domain\Entity\Track;
use Track\Domain\ValueObject\SourcePlatform;

interface TrackRepositoryInterface
{
    public function findOneById(UuidInterface $trackId): Track;

    public function findOneOrNullBySourceTrackId(string $sourceTrackId): ?Track;

    public function findAll(): array;

    public function findAllBySource(SourcePlatform $source): array;

    public function save(Track $track, bool $flush = true): void;
}
