<?php

namespace App\Action\Estatus_aplicacion;

use App\Domain\Estatus_aplicacion\Service\Estatus_aplicacionDeleter;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class Estatus_aplicacionDeleterAction
{
    private Estatus_aplicacionDeleter $estatus_aplicacionDeleter;

    private JsonRenderer $renderer;

    public function __construct(Estatus_aplicacionDeleter $estatus_aplicacionDeleter, JsonRenderer $renderer)
    {
        $this->estatus_aplicacionDeleter = $estatus_aplicacionDeleter;
        $this->renderer = $renderer;

    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $estatus_aplicacionId = (int)$args['estatus_aplicacion_id'];

        // Invoke the domain (service class)
        $this->estatus_aplicacionDeleter->deleteEstatus_aplicacion($estatus_aplicacionId);
        // Render the json response
        return $this->renderer->json($response, 'Registro eliminado');
    }
}
