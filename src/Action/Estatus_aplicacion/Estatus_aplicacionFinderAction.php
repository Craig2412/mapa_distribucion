<?php

namespace App\Action\Estatus_aplicacion;

use App\Domain\Estatus_aplicacion\Data\Estatus_aplicacionFinderResult;
use App\Domain\Estatus_aplicacion\Service\Estatus_aplicacionFinder;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class Estatus_aplicacionFinderAction
{
    private Estatus_aplicacionFinder $estatus_aplicacionFinder;

    private JsonRenderer $renderer;

    public function __construct(Estatus_aplicacionFinder $estatus_aplicacionFinder, JsonRenderer $jsonRenderer)
    {
        $this->estatus_aplicacionFinder = $estatus_aplicacionFinder;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Optional: Pass parameters from the request to the service method
        // ...

        $estatus_aplicacions = $this->estatus_aplicacionFinder->findEstatus_aplicacions();

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($estatus_aplicacions));
    }

    public function transform(Estatus_aplicacionFinderResult $result): array
    {
        $estatus_aplicacions = [];

        foreach ($result->estatus_aplicacions as $estatus_aplicacion) {
            $estatus_aplicacions[] = [
                'id' => $estatus_aplicacion->id,
                'estatus_aplicacion' => $estatus_aplicacion->estatus_aplicacion
            ];
        }

        return [
            'estatus_aplicaciones' => $estatus_aplicacions,
        ];
    }
}
