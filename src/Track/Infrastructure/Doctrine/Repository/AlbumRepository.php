<?php

declare(strict_types=1);

namespace Track\Infrastructure\Doctrine\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\QueryException;
use Track\Domain\Entity\Album;
use Track\Domain\Repository\AlbumRepositoryInterface;

class AlbumRepository implements AlbumRepositoryInterface
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function findOneOrNullByTitle(string $title): ?Album
    {
        return $this->em->createQueryBuilder()
            ->select('alb')
            ->from(Album::class, 'alb')
            ->where('LOWER(alb.title) = :title')
            ->setParameter('title', strtolower($title))
            ->getQuery()
            ->getOneOrNullResult();
    }

    /** @throws QueryException */
    public function findAll(): array
    {
        return $this->em->createQueryBuilder()
            ->select('alb.title')
            ->from(Album::class, 'alb')
            ->indexBy('alb', 'alb.title')
            ->getQuery()
            ->getResult();
    }

    public function save(Album $album, bool $flush = true): void
    {
        $this->em->persist($album);

        if ($flush) {
            $this->em->flush();
        }
    }
}
