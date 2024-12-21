<?php

declare(strict_types=1);

namespace Track\Domain\Entity;

use Carbon\CarbonImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class Album
{
    private readonly UuidInterface $id;
    private readonly CarbonImmutable $createdAt;

    private Collection $tracks;
    private Collection $artists;

    private function __construct(private readonly string $title)
    {
        $this->id = Uuid::uuid4();
        $this->createdAt = CarbonImmutable::now();

        $this->tracks = new ArrayCollection();
        $this->artists = new ArrayCollection();
    }

    public static function create(string $title, array $artists): self
    {
        $album = new self($title);

        foreach ($artists as $artist) {
            $album->artists->add($artist);
        }

        return $album;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getCreatedAt(): CarbonImmutable
    {
        return $this->createdAt;
    }

    /** @return Track[] */
    public function getTracks(): array
    {
        return $this->tracks->toArray();
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    /** @return Artist[] */
    public function getArtists(): array
    {
        return $this->artists->toArray();
    }
}
