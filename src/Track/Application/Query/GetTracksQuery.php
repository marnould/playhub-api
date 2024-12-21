<?php

declare(strict_types=1);

namespace Track\Application\Query;

use Core\Domain\Bus\Query\QueryInterface;

readonly class GetTracksQuery implements QueryInterface
{
    public function __construct()
    {
    }
}
