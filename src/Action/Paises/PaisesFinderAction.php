<?php

namespace App\Action\Paises;

use App\Domain\Paises\Data\PaisesFinderResult;
use App\Domain\Paises\Service\PaisesFinder;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class PaisesFinderAction
{
    private PaisesFinder $paisesFinder;

    private JsonRenderer $renderer;

    public function __construct(PaisesFinder $paisesFinder, JsonRenderer $jsonRenderer)
    {
        $this->paisesFinder = $paisesFinder;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Optional: Pass parameters from the request to the service method
        // ...

        $paisess = $this->paisesFinder->findPaisess();

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($paisess));
    }

    public function transform(PaisesFinderResult $result): array
    {
        $paisess = [];
        
        foreach ($result->paisess as $paises) {
            $paisess[] = [
                'id' => $paises->id,
                'pais' => $paises->pais
            ];
        }

        return [
            'paisess' => $paisess,
        ];
    }
}
