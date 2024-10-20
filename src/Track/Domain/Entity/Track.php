<?php

declare(strict_types=1);

namespace Track\Domain\Entity;

use Carbon\CarbonImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Ramsey\Uuid\UuidInterface;
use Track\Domain\ValueObject\SourcePlatform;

class Track
{
    private readonly UuidInterface $id;
    private readonly CarbonImmutable $createdAt;
    private Collection $artists;
    private Album $album;

    private function __construct(
        private readonly string $title,
        private readonly SourcePlatform $sourcePlatform,
        private readonly string $sourceTrackId,
        private readonly string $streamUrl,
    ) {
        $this->createdAt = CarbonImmutable::now();
        $this->artists = new ArrayCollection();
    }

    public static function create(
        string $title,
        SourcePlatform $sourcePlatform,
        string $sourceTrackId,
        string $streamUrl,
        ?array $artists = null,
        ?Album $album = null,
    ): self {
        $track = new self($title, $sourcePlatform, $sourceTrackId, $streamUrl);

        if ($album) {
            $track->album = $album;
        }

        if ($artists) {
            foreach ($artists as $artist) {
                $track->artists->add($artist);
            }
        }

        return $track;
    }

    public function addArtist(Artist $artist): self
    {
        $this->artists->add($artist);

        return $this;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getCreatedAt(): CarbonImmutable
    {
        return $this->createdAt;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getSourcePlatform(): SourcePlatform
    {
        return $this->sourcePlatform;
    }

    public function getSourceTrackId(): string
    {
        return $this->sourceTrackId;
    }

    /** @return Artist[] */
    public function getArtists(): array
    {
        return $this->artists->toArray();
    }

    public function getAlbum(): Album
    {
        return $this->album;
    }

    public function getStreamUrl(): string
    {
        return $this->streamUrl;
    }
}
