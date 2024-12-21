<?php

declare(strict_types=1);

namespace Track\Presentation\Http\Rest\Controller\Spotify;

use Core\Domain\Bus\Command\CommandBusInterface;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Track\Application\Command\Spotify\ImportSavedTracksCommand;

readonly class ImportSavedTracksController
{
    public function __construct(private CommandBusInterface $commandBus)
    {
    }

    #[Route('/spotify/import-saved-tracks', methods: ['POST'])]
    #[OA\Response(
        response: 201,
        description: 'All saved tracks and related albums and artists have been imported from Spotify',
    )]
    #[OA\Tag(name: 'spotify')]
    public function __invoke(): JsonResponse
    {
        $this->commandBus->publish(new ImportSavedTracksCommand());

        return new JsonResponse(null, Response::HTTP_CREATED);
    }
}
