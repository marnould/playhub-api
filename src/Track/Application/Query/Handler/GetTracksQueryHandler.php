<?php

declare(strict_types=1);

namespace Track\Application\Query\Handler;

use Core\Domain\Bus\Query\QueryHandlerInterface;
use Track\Application\Query\GetTracksQuery;
use Track\Domain\Repository\TrackRepositoryInterface;

readonly class GetTracksQueryHandler implements QueryHandlerInterface
{
    public function __construct(private TrackRepositoryInterface $trackRepository)
    {
    }

    public function __invoke(GetTracksQuery $query): array
    {
        return $this->trackRepository->findAllWithArtistsAndAlbums();
    }
}
