<?php

namespace App\Action\Estados;

use App\Domain\Estados\Data\EstadosFinderResult;
use App\Domain\Estados\Service\EstadosFinder;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class EstadosFinderAction
{
    private EstadosFinder $estadosFinder;

    private JsonRenderer $renderer;

    public function __construct(EstadosFinder $estadosFinder, JsonRenderer $jsonRenderer)
    {
        $this->estadosFinder = $estadosFinder;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Optional: Pass parameters from the request to the service method
        // ...
        $estadoss = $this->estadosFinder->findEstadoss();

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($estadoss));
    }

    public function transform(EstadosFinderResult $result): array
    {
        $estadoss = [];

        foreach ($result->estadoss as $estados) {
            $estadoss[] = [
                'id' => $estados->id,
                'estado' => $estados->estado
            ];
        }

        return [
            'estadoss' => $estadoss,
        ];
    }
}
