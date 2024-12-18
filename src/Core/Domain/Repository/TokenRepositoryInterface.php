<?php

declare(strict_types=1);

namespace Core\Domain\Repository;

use Core\Domain\Entity\Token;
use Core\Domain\ValueObject\Source;

interface TokenRepositoryInterface
{
    public function findOneOrNullBySource(Source $tokenSource): ?Token;

    public function save(Token $token): void;
}
