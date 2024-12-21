<?php

declare(strict_types=1);

namespace Track\Application\Command\Handler\Spotify;

use Core\Domain\Bus\Command\CommandHandlerInterface;
use Core\Domain\Port\SpotifyHttpClientInterface;
use Doctrine\ORM\EntityManagerInterface;
use Track\Application\Command\Spotify\ImportSavedTracksCommand;
use Track\Domain\Entity\Album;
use Track\Domain\Entity\Artist;
use Track\Domain\Entity\Track;
use Track\Domain\Repository\AlbumRepositoryInterface;
use Track\Domain\Repository\ArtistRepositoryInterface;
use Track\Domain\Repository\TrackRepositoryInterface;
use Track\Domain\ValueObject\SourcePlatform;

readonly class ImportSavedTracksCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private TrackRepositoryInterface $trackRepository,
        private ArtistRepositoryInterface $artistRepository,
        private AlbumRepositoryInterface $albumRepository,
        private SpotifyHttpClientInterface $spotifyHttpClient,
        private EntityManagerInterface $em,
    ) {
    }

    public function __invoke(ImportSavedTracksCommand $command): void
    {
        $offset = 0;
        $limit = 50;
        $existingArtists = $this->artistRepository->findAll();
        $existingAlbums = $this->albumRepository->findAll();
        $existingTracks = $this->trackRepository->findAllBySource(SourcePlatform::SPOTIFY);

        while (count($likedTracks[] = $this->spotifyHttpClient->getSavedTracks($offset, $limit)) > 0) {
            foreach ($likedTracks[0] as $likedTrack) {
                $artists = [];
                $trackDetails = $likedTrack['track'];
                $albumDetails = $trackDetails['album'];
                $artistsDetails = $albumDetails['artists'];

                foreach ($artistsDetails as $artistDetails) {
                    $artist = array_key_exists($artistDetails['name'], $existingArtists) ? $existingArtists[$artistDetails['name']] : null;

                    if (!$artist) {
                        $artist = Artist::create($artistDetails['name']);

                        $this->artistRepository->save($artist, false);
                    }

                    $artists[] = $artist;
                }

                $album = array_key_exists($albumDetails['name'], $existingAlbums) ? $existingAlbums[$albumDetails['name']] : null;

                if (!$album) {
                    $album = Album::create($albumDetails['name'], $artists);

                    $this->albumRepository->save($album, false);
                }

                $track = array_key_exists($trackDetails['id'], $existingTracks) ? $existingTracks[$trackDetails['id']] : null;

                if (!$track) {
                    $track = Track::create(
                        $trackDetails['name'],
                        SourcePlatform::SPOTIFY,
                        $trackDetails['id'],
                        $trackDetails['href'],
                        $artists,
                        $album
                    );
                }

                $this->trackRepository->save($track, false);
            }

            /* @TODO Doesn't respect DDD but needed to avoid memory issue - To refactor */
            $this->em->flush();

            $offset += $limit;
        }
    }
}
