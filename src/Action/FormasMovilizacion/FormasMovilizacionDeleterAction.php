<?php

namespace App\Action\FormasMovilizacion;

use App\Domain\FormasMovilizacion\Service\FormasMovilizacionDeleter;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class FormasMovilizacionDeleterAction
{
    private FormasMovilizacionDeleter $formasMovilizacionDeleter;

    private JsonRenderer $renderer;

    public function __construct(FormasMovilizacionDeleter $formasMovilizacionDeleter, JsonRenderer $renderer)
    {
        $this->iposMovilizacionDeleter = $formasMovilizacionDeleter;
        $this->renderer = $renderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $formasMovilizacionId = (int)$args['formasMovilizacion_id'];

        // Invoke the domain (service class)
        $this->iposMovilizacionDeleter->deleteFormasMovilizacion($formasMovilizacionId);

        // Render the json response
        return $this->renderer->json($response, 'Registro eliminado');
    }
}
