<?php

declare(strict_types=1);

namespace Core\Domain\Entity;

use Carbon\CarbonImmutable;
use Core\Domain\ValueObject\Source;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class Token
{
    private readonly UuidInterface $id;

    public function __construct(
        private string $accessToken,
        private readonly string $refreshToken,
        private readonly Source $source,
        private CarbonImmutable $expireDate,
    ) {
        $this->id = Uuid::uuid4();
    }

    public static function create(string $accessToken, string $refreshToken, string $source, int $secondsBeforeExpiration)
    {
        return new self(
            $accessToken,
            $refreshToken,
            Source::from($source),
            CarbonImmutable::now()->addSeconds($secondsBeforeExpiration)
        );
    }

    public function update(string $accessToken, int $secondsBeforeExpiration): void
    {
        $this->accessToken = $accessToken;
        $this->expireDate = $this->calculateExpireDate($secondsBeforeExpiration);
    }

    private function calculateExpireDate(int $secondsBeforeExpiration): CarbonImmutable
    {
        return CarbonImmutable::now()->addSeconds($secondsBeforeExpiration);
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    public function getRefreshToken(): string
    {
        return $this->refreshToken;
    }

    public function getSource(): Source
    {
        return $this->source;
    }

    public function getExpireDate(): CarbonImmutable
    {
        return $this->expireDate;
    }
}
