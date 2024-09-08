<?php

namespace App\Action\Solicitudes;

use App\Domain\Solicitudes\Data\SolicitudesConsultaReaderResult;
use App\Domain\Solicitudes\Service\SolicitudesConsultaReader;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class SolicitudesConsultaReaderAction
{
    private SolicitudesConsultaReader $solicitudesConsultaReader;

    private JsonRenderer $renderer;

    public function __construct(SolicitudesConsultaReader $solicitudesConsultaReader, JsonRenderer $jsonRenderer)
    {
        $this->solicitudesConsultaReader = $solicitudesConsultaReader;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $solicitudesConsultaId = (string)$args['nro_solicitud'];

        // Invoke the domain and get the result
        $solicitudesConsulta = $this->solicitudesConsultaReader->getSolicitudesConsulta($solicitudesConsultaId);

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($solicitudesConsulta));
    }

    private function transform(SolicitudesConsultaReaderResult $solicitudesConsulta): array
    {
        return [
            'poder' => $solicitudesConsulta->nro_derecho,
            'registro' => $solicitudesConsulta->registro,
            'solicitud' => $solicitudesConsulta->solicitud,
            'nombre' => $solicitudesConsulta->nombre,
            'categoria' => $solicitudesConsulta->categoria,
            'nombre_categoria' => $solicitudesConsulta->nombre_categoria
        ];
    }
}
