<?php

namespace App\Action\Formato_Citas;

use App\Domain\Formato_Citas\Service\Formato_CitasDeleter;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class Formato_CitasDeleterAction
{
    private Formato_CitasDeleter $formato_citasDeleter;

    private JsonRenderer $renderer;

    public function __construct(Formato_CitasDeleter $formato_citasDeleter, JsonRenderer $renderer)
    {
        $this->formato_citasDeleter = $formato_citasDeleter;
        $this->renderer = $renderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $formato_citasId = (int)$args['formato_citas_id'];

        // Invoke the domain (service class)
        $this->formato_citasDeleter->deleteFormato_Citas($formato_citasId);

        // Render the json response
        return $this->renderer->json($response, 'Registro eliminado');
    }
}
