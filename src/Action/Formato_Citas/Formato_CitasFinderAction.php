<?php

namespace App\Action\Formato_Citas;

use App\Domain\Formato_Citas\Data\Formato_CitasFinderResult;
use App\Domain\Formato_Citas\Service\Formato_CitasFinder;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class Formato_CitasFinderAction
{
    private Formato_CitasFinder $formato_citasFinder;

    private JsonRenderer $renderer;

    public function __construct(Formato_CitasFinder $formato_citasFinder, JsonRenderer $jsonRenderer)
    {
        $this->formato_citasFinder = $formato_citasFinder;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Optional: Pass parameters from the request to the service method
        // ...

        $formato_citass = $this->formato_citasFinder->findFormato_Citass();

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($formato_citass));
    }

    public function transform(Formato_CitasFinderResult $result): array
    {
        $formato_citass = [];
        
        foreach ($result->formato_citass as $formato_citas) {
            $formato_citass[] = [
                'id' => $formato_citas->id,
                'formato_cita' => $formato_citas->formato_cita
            ];
        }

        return [
            'formato_citass' => $formato_citass,
        ];
    }
}
