<?php

namespace App\Action\Solicitudes;

use App\Domain\Solicitudes\Data\SolicitudesUnicasReaderResult;
use App\Domain\Solicitudes\Service\SolicitudesUnicasReader;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class SolicitudesUnicasReaderAction
{
    private SolicitudesUnicasReader $solicitudesUnicasReader;

    private JsonRenderer $renderer;

    public function __construct(SolicitudesUnicasReader $solicitudesUnicasReader, JsonRenderer $jsonRenderer)
    {
        $this->solicitudesUnicasReader = $solicitudesUnicasReader;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $solicitudesUnicasId = (int)$args['id_solicitud'];

        // Invoke the domain and get the result
        $solicitudesUnicas = $this->solicitudesUnicasReader->getSolicitudesUnicas($solicitudesUnicasId);

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($solicitudesUnicas));
    }

    private function transform(SolicitudesUnicasReaderResult $solicitudesUnicas): array
    {
        return [
            'id' => $solicitudesUnicas->id,
            'num_solicitud' => $solicitudesUnicas->num_solicitud,
            'num_registro' => $solicitudesUnicas->num_registro,
            'descripcion' => $solicitudesUnicas->descripcion,
            'respuesta' => $solicitudesUnicas->respuesta,
            'id_categoria' => $solicitudesUnicas->id_categoria,
            'categoria' => $solicitudesUnicas->categoria,
            'id_requerimiento' => $solicitudesUnicas->id_requerimiento,
            'id_estado' => $solicitudesUnicas->id_estado,
            'estado' => $solicitudesUnicas->estado,
            'id_condicion' => $solicitudesUnicas->id_condicion,
            'updated' => $solicitudesUnicas->updated
            
        ];
    }
}
