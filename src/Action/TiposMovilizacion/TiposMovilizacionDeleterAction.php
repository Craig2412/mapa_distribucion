<?php

namespace App\Action\TiposMovilizacion;

use App\Domain\TiposMovilizacion\Service\TiposMovilizacionDeleter;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class TiposMovilizacionDeleterAction
{
    private TiposMovilizacionDeleter $tiposMovilizacionDeleter;

    private JsonRenderer $renderer;

    public function __construct(TiposMovilizacionDeleter $tiposMovilizacionDeleter, JsonRenderer $renderer)
    {
        $this->iposMovilizacionDeleter = $tiposMovilizacionDeleter;
        $this->renderer = $renderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $tiposMovilizacionId = (int)$args['tiposMovilizacion_id'];

        // Invoke the domain (service class)
        $this->iposMovilizacionDeleter->deleteTiposMovilizacion($tiposMovilizacionId);

        // Render the json response
        return $this->renderer->json($response, 'Registro eliminado');
    }
}
