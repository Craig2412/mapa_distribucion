<?php

namespace App\Action\Requerimientos;

use App\Domain\Requerimientos\Service\RequerimientosDeleter;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class RequerimientosDeleterAction
{
    private RequerimientosDeleter $requerimientosDeleter;

    private JsonRenderer $renderer;

    public function __construct(RequerimientosDeleter $requerimientosDeleter, JsonRenderer $renderer)
    {
        $this->requerimientosDeleter = $requerimientosDeleter;
        $this->renderer = $renderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $requerimientosId = (int)$args['id_requerimientos'];
        // Invoke the domain (service class)
        $this->requerimientosDeleter->deleteRequerimientos($requerimientosId);
        // Render the json response
        return $this->renderer->json($response, 'Registro eliminado');
    }
}
