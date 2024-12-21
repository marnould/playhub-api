<?php

declare(strict_types=1);

namespace Core\Infrastructure\Bus\Command;

use Core\Domain\Bus\Command\CommandBusInterface;
use Core\Domain\Bus\Command\CommandInterface;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

class SymfonyCommandBusInterface implements CommandBusInterface
{
    use HandleTrait;

    public function __construct(MessageBusInterface $commandBus)
    {
        $this->messageBus = $commandBus;
    }

    public function publish(CommandInterface $command)
    {
        return $this->handle($command);
    }
}
