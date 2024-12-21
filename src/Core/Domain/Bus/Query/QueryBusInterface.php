<?php

declare(strict_types=1);

namespace Core\Domain\Bus\Query;

interface QueryBusInterface
{
    public function ask(QueryInterface $query);
}
