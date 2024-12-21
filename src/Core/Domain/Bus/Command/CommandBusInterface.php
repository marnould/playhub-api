<?php

declare(strict_types=1);

namespace Core\Domain\Bus\Command;

interface CommandBusInterface
{
    public function publish(CommandInterface $command);
}
