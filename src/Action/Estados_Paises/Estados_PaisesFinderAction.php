<?php

namespace App\Action\Estados_Paises;

use App\Domain\Estados_Paises\Data\Estados_PaisesFinderResult;
use App\Domain\Estados_Paises\Service\Estados_PaisesFinder;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class Estados_PaisesFinderAction
{
    private Estados_PaisesFinder $estados_paisesFinder;

    private JsonRenderer $renderer;

    public function __construct(Estados_PaisesFinder $estados_paisesFinder, JsonRenderer $jsonRenderer)
    {
        $this->estados_paisesFinder = $estados_paisesFinder;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Optional: Pass parameters from the request to the service method
        // ...

        $estados_paisess = $this->estados_paisesFinder->findEstados_Paisess();

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($estados_paisess));
    }

    public function transform(Estados_PaisesFinderResult $result): array
    {
        $estados_paisess = [];
        
        foreach ($result->estados_paisess as $estados_paises) {
            $estados_paisess[] = [
                'id' => $estados_paises->id,
                'estado_pais' => $estados_paises->estado_pais
            ];
        }

        return [
            'estados_paisess' => $estados_paisess,
        ];
    }
}
