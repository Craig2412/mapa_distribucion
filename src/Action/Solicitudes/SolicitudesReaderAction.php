<?php

namespace App\Action\Solicitudes;

use App\Domain\Solicitudes\Data\SolicitudesReaderResult;
use App\Domain\Solicitudes\Service\SolicitudesReader;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class SolicitudesReaderAction
{
    private SolicitudesReader $solicitudesReader;

    private JsonRenderer $renderer;

    public function __construct(SolicitudesReader $solicitudesReader, JsonRenderer $jsonRenderer)
    {
        $this->solicitudesReader = $solicitudesReader;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $solicitudesId = (int)$args['id_requerimiento'];

        // Invoke the domain and get the result
        $solicitudes = $this->solicitudesReader->getSolicitudes($solicitudesId);

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($solicitudes));
    }

    private function transform(SolicitudesReaderResult $result): array
    {
        $solicitudes = [];
//var_dump($result);
        foreach ($result->solicitudes as $solicitudes) {
            $solicitud[] = [
                'id' => $solicitudes->id,
                'num_solicitud' => $solicitudes->num_solicitud,
                'num_registro' => $solicitudes->num_registro,
                'descripcion' => $solicitudes->descripcion,
                'respuesta' => $solicitudes->respuesta,
                'id_categoria' => $solicitudes->id_categoria,
                'categoria' => $solicitudes->categoria,
                'id_requerimiento' => $solicitudes->id_requerimiento,
                'id_estado' => $solicitudes->id_estado,
                'estado' => $solicitudes->estado,
                'id_condicion' => $solicitudes->id_condicion,
                'updated' => $solicitudes->updated
            ];
        }

        return [
            'solicitudes' => array_reverse($solicitud),
        ];
    }
}
