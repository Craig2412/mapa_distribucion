<?php

namespace App\Action\Solicitudes;

use App\Domain\Solicitudes\Data\SolicitudesFinderResult;
use App\Domain\Solicitudes\Service\SolicitudesFinder;
use App\Action\conexionSipi;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class SolicitudesFinderAction
{
    private SolicitudesFinder $solicitudFinder;

    private JsonRenderer $renderer;

    public function __construct(SolicitudesFinder $solicitudFinder, JsonRenderer $jsonRenderer)
    {
        $this->solicitudFinder = $solicitudFinder;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
                
        $solicitudes = $this->solicitudFinder->findSolicitudes();

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($solicitudes));
    }

    public function transform(SolicitudesFinderResult $result): array
    {
        $solicitudes = [];

        foreach ($result->solicitudes as $solicitud) {
            $solicitudes[] = [
                'id' => $solicitud->id,
                'num_solicitud' => $solicitud->num_solicitud,
                'num_registro' => $solicitud->num_registro,
                'descripcion' => $solicitud->descripcion,
                'respuesta' => $solicitud->respuesta,
                'id_categoria' => $solicitud->id_categoria,
                'categoria' => $solicitud->categoria,
                'id_requerimiento' => $solicitud->id_requerimiento,
                'id_estado' => $solicitud->id_estado,
                'estado' => $solicitud->estado,
                'id_condicion' => $solicitud->id_condicion,
                'created' => $solicitud->created,
                'updated' => $solicitud->updated
            ];
        }

        return [
            'solicitudes' => $solicitudes,
        ];
    }
}
