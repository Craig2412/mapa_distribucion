<?php

namespace App\Action\Encuesta;

use App\Domain\Encuesta\Service\EncuestaDeleter;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class EncuestaDeleterAction
{
    private EncuestaDeleter $encuestaDeleter;

    private JsonRenderer $renderer;

    public function __construct(EncuestaDeleter $encuestaDeleter, JsonRenderer $renderer)
    {
        $this->encuestaDeleter = $encuestaDeleter;
        $this->renderer = $renderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $encuestaId = (int)$args['encuesta_id'];

        // Invoke the domain (service class)
        $this->encuestaDeleter->deleteEncuesta($encuestaId);

        // Render the json response
        return $this->renderer->json($response, 'Registro eliminado');
    }
}
