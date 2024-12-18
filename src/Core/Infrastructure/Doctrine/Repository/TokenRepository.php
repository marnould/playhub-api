<?php

declare(strict_types=1);

namespace Core\Infrastructure\Doctrine\Repository;

use Core\Domain\Entity\Token;
use Core\Domain\Repository\TokenRepositoryInterface;
use Core\Domain\ValueObject\Source;
use Doctrine\ORM\EntityManagerInterface;

class TokenRepository implements TokenRepositoryInterface
{
    public function __construct(private readonly EntityManagerInterface $em)
    {
    }

    public function findOneOrNullBySource(Source $tokenSource): ?Token
    {
        return $this->em->createQueryBuilder()
            ->select('t')
            ->from(Token::class, 't')
            ->where('t.source = :source')
            ->setParameter('source', $tokenSource->value)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function save(Token $token): void
    {
        $this->em->persist($token);
        $this->em->flush();
    }
}
