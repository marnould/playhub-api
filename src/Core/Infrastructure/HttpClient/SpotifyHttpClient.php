<?php

declare(strict_types=1);

namespace Core\Infrastructure\HttpClient;

use Core\Domain\Entity\Token;
use Core\Domain\Port\SpotifyHttpClientInterface;
use Core\Domain\Repository\TokenRepositoryInterface;
use Core\Domain\ValueObject\Source;
use Ramsey\Uuid\Nonstandard\Uuid;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class SpotifyHttpClient implements SpotifyHttpClientInterface
{
    public const SPOTIFY_BASE_URL = 'https://api.spotify.com/v1';
    public const REDIRECT_URI = 'http://127.0.0.1:8000';

    private readonly HttpClientInterface $client;

    public function __construct(
        private readonly string $spotifyClientId,
        private readonly string $spotifyClientSecret,
        private readonly TokenRepositoryInterface $tokenRepository,
    ) {
        $this->client = HttpClient::create();
    }

    /** @TODO Need to be passed in front in order to ask the user grants and retrieve the auth code used in getAccessToken() call */
    private function authorize()
    {
        $responseType = 'code';
        $scope = 'user-read-playback-state user-modify-playback-state user-read-currently-playing app-remote-control streaming playlist-read-private playlist-modify-private playlist-modify-public user-read-playback-position user-library-read user-read-private';
        $state = Uuid::uuid4()->toString();

        $queryString = sprintf(
            'response_type=%s&client_id=%s&scope=%s&redirect_uri=%s&state=%s&show_dialog=%s',
            $responseType,
            $this->spotifyClientId,
            $scope,
            self::REDIRECT_URI,
            $state,
            false
        );

        $response = $this->client->request(
            'GET',
            sprintf('https://accounts.spotify.com/authorize?%s', $queryString)
        );

        return $response->getContent();
    }

    private function getToken(): Token
    {
        $existingAccessToken = $this->tokenRepository->findOneOrNullBySource(Source::SPOTIFY);

        switch ($existingAccessToken) {
            case null:
                $accessToken = $this->getAccessToken();
                $this->tokenRepository->save($accessToken);

                return $accessToken;

            case $existingAccessToken->getExpireDate()->isPast():
                $refreshToken = $this->getRefreshToken($existingAccessToken);

                $this->tokenRepository->save($refreshToken);

                return $refreshToken;

            case $existingAccessToken->getExpireDate()->isFuture():
            default:
                return $existingAccessToken;
        }
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    private function getAccessToken(): Token
    {
        $encodedCredentials = base64_encode(
            sprintf('%s:%s', $this->spotifyClientId, $this->spotifyClientSecret)
        );

        $response = $this->client->request(
            'POST',
            'https://accounts.spotify.com/api/token',
            [
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                    'Authorization' => sprintf('Basic %s', $encodedCredentials),
                ],
                'body' => [
                    'grant_type' => 'authorization_code',
                    'code' => null, // @TODO Implement auth code retrieve with front
                    'redirect_uri' => self::REDIRECT_URI,
                ],
            ]
        );

        $responseToken = $response->toArray();

        return Token::create(
            $responseToken['access_token'],
            $responseToken['refresh_token'],
            'spotify',
            $responseToken['expires_in']
        );
    }

    private function getRefreshToken(Token $existingToken): Token
    {
        $encodedCredentials = base64_encode(
            sprintf('%s:%s', $this->spotifyClientId, $this->spotifyClientSecret)
        );

        $response = $this->client->request(
            'POST',
            'https://accounts.spotify.com/api/token',
            [
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                    'Authorization' => sprintf('Basic %s', $encodedCredentials),
                ],
                'body' => [
                    'grant_type' => 'refresh_token',
                    'refresh_token' => $existingToken->getRefreshToken(),
                ],
            ]
        );

        $responseToken = $response->toArray();

        $existingToken->update($responseToken['access_token'], $responseToken['expires_in']);

        return $existingToken;
    }

    /**
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function getSavedTracks(int $offset, int $limit): array
    {
        $response = $this->client->request(
            'GET',
            sprintf(
                self::SPOTIFY_BASE_URL.'/me/tracks?offset=%s&limit=%s&market=FR',
                $offset,
                $limit
            ),
            [
                'headers' => [
                    'Authorization' => 'Bearer '.$this->getToken()->getAccessToken(),
                ],
            ]
        );

        return $response->toArray()['items'];
    }
}
