<?php

namespace App\Action\Solicitudes;

use App\Domain\Solicitudes\Service\SolicitudesDeleter;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class SolicitudesDeleterAction
{
    private SolicitudesDeleter $solicitudesDeleter;

    private JsonRenderer $renderer;

    public function __construct(SolicitudesDeleter $solicitudesDeleter, JsonRenderer $renderer)
    {
        $this->solicitudesDeleter = $solicitudesDeleter;
        $this->renderer = $renderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $solicitudesId = (int)$args['id_solicitud'];
        // Invoke the domain (service class)
        $this->solicitudesDeleter->deleteSolicitudes($solicitudesId);
        // Render the json response
        return $this->renderer->json($response, 'Registro eliminado');
    }
}
