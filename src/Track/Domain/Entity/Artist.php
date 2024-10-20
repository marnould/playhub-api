<?php

declare(strict_types=1);

namespace Track\Domain\Entity;

use Carbon\CarbonImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Ramsey\Uuid\UuidInterface;

class Artist
{
    private readonly UuidInterface $id;
    private readonly CarbonImmutable $createdAt;
    private Collection $tracks;
    private Collection $albums;

    private function __construct(private readonly string $name)
    {
        $this->createdAt = CarbonImmutable::now();

        $this->tracks = new ArrayCollection();
        $this->albums = new ArrayCollection();
    }

    public static function create(string $name): self
    {
        return new self($name);
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

    /** @return Album[] */
    public function getAlbums(): array
    {
        return $this->albums->toArray();
    }

    public function getName(): string
    {
        return $this->name;
    }
}
