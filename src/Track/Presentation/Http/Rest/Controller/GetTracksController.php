<?php

declare(strict_types=1);

namespace Track\Presentation\Http\Rest\Controller;

use Core\Domain\Bus\Command\CommandBusInterface;
use Core\Domain\Bus\Query\QueryBusInterface;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Track\Application\Command\Spotify\ImportSavedTracksCommand;
use Track\Application\Query\GetTracksQuery;

readonly class GetTracksController
{
    public function __construct(private QueryBusInterface $queryBus)
    {
    }

    #[Route('/api/tracks', methods: ['GET'])]
    #[OA\Response(
        response: 200,
        description: 'Retrieve all local tracks',
    )]
    #[OA\Tag(name: 'api')]
    public function __invoke(): JsonResponse
    {
        return new JsonResponse($this->queryBus->ask(new GetTracksQuery()), Response::HTTP_OK);
    }
}
