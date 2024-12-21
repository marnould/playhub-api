<?php

declare(strict_types=1);

namespace Track\Infrastructure\Doctrine\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\Query\QueryException;
use Ramsey\Uuid\UuidInterface;
use Track\Domain\Entity\Track;
use Track\Domain\Repository\TrackRepositoryInterface;
use Track\Domain\ValueObject\SourcePlatform;

class TrackRepository implements TrackRepositoryInterface
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function findOneById(UuidInterface $trackId): Track
    {
        $track = $this->em->createQueryBuilder()
            ->select('t')
            ->from(Track::class, 't')
            ->where('t.id = :trackId')
            ->setParameter('trackId', $trackId->toString())
            ->getQuery()
            ->getOneOrNullResult();

        if (!$track) {
            throw EntityNotFoundException::fromClassNameAndIdentifier(Track::class, [$trackId->toString()]);
        }

        return $track;
    }

    public function findOneOrNullBySourceTrackId(string $sourceTrackId): ?Track
    {
        return $this->em->createQueryBuilder()
            ->select('t')
            ->from(Track::class, 't')
            ->where('t.sourceTrackId = :sourceTrackId')
            ->setParameter('sourceTrackId', $sourceTrackId)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findAll(): array
    {
        return $this->em->createQueryBuilder()
            ->select('t')
            ->from(Track::class, 't')
            ->getQuery()
            ->getArrayResult();
    }

    /** @throws QueryException */
    public function findAllBySource(SourcePlatform $source): array
    {
        return $this->em->createQueryBuilder()
            ->select('t')
            ->from(Track::class, 't')
            ->where('t.sourcePlatform = :source')
            ->setParameter('source', $source->value)
            ->indexBy('t', 't.sourceTrackId')
            ->getQuery()
            ->getResult();
    }

    public function save(Track $track, bool $flush = true): void
    {
        $this->em->persist($track);

        if ($flush) {
            $this->em->flush();
        }
    }
}
