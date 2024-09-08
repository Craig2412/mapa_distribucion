<?php

namespace App\Action\Solicitudes;

use App\Domain\Solicitudes\Data\SolicitudesbyCategoriasFinderResult;
use App\Domain\Solicitudes\Service\SolicitudesbyCategoriasFinder;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class SolicitudesbyCategoriasFinderAction
{
    
    private SolicitudesbyCategoriasFinder $solicitudesbyCategoriasFinder;

    private JsonRenderer $renderer;

    public function __construct(SolicitudesbyCategoriasFinder $solicitudesbyCategoriasFinder, JsonRenderer $jsonRenderer)
    {

        $this->solicitudesbyCategoriasFinder = $solicitudesbyCategoriasFinder;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {

        $solicitudesbyCategorias = $this->solicitudesbyCategoriasFinder->findSolicitudesbyCategorias();
  

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($solicitudesbyCategorias));
    }

    public function transform(SolicitudesbyCategoriasFinderResult $result): array
    {
        $solicitudesbyCategorias = [];

        foreach ($result->solicitudesbyCategorias as $solicitudesbyEstado) {
            $solicitudesbyCategorias[] = [
                'estado' => $solicitudesbyEstado->categoria,
                'total' => $solicitudesbyEstado->total,
            ];
        }

        return [
            'solicitudesbyCategorias' => $solicitudesbyCategorias
        ];
    }
}
/*


EJEMPLO DEL STRING QUE SE DEBE ENVIAR POR LOS PARAMETROS CON FORMATO JSON:
    {"area": "some_value", "status": "some_name", "type_solicitudesbyCategorias": "some_surname"}
*/