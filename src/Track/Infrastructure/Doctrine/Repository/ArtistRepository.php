<?php

declare(strict_types=1);

namespace Track\Infrastructure\Doctrine\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\QueryException;
use Track\Domain\Entity\Artist;
use Track\Domain\Repository\ArtistRepositoryInterface;

class ArtistRepository implements ArtistRepositoryInterface
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function findOneOrNullByName(string $name): ?Artist
    {
        return $this->em->createQueryBuilder()
            ->select('art')
            ->from(Artist::class, 'art')
            ->where('LOWER(art.name) = :name')
            ->setParameter('name', strtolower($name))
            ->getQuery()
            ->getOneOrNullResult();
    }

    /** @throws QueryException */
    public function findAll(): array
    {
        return $this->em->createQueryBuilder()
            ->select('art')
            ->from(Artist::class, 'art')
            ->indexBy('art', 'art.name')
            ->getQuery()
            ->getResult();
    }

    public function save(Artist $artist, bool $flush = true): void
    {
        $this->em->persist($artist);

        if ($flush) {
            $this->em->flush();
        }
    }
}
