<?php

declare(strict_types=1);

namespace Core\Infrastructure\Bus\Query;

use Core\Domain\Bus\Query\QueryBusInterface;
use Core\Domain\Bus\Query\QueryInterface;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

class SymfonyQueryBusInterface implements QueryBusInterface
{
    use HandleTrait;

    public function __construct(MessageBusInterface $queryBus)
    {
        $this->messageBus = $queryBus;
    }

    public function ask(QueryInterface $query)
    {
        return $this->handle($query);
    }
}
