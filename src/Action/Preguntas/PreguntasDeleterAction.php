<?php

namespace App\Action\Preguntas;

use App\Domain\Preguntas\Service\PreguntasDeleter;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class PreguntasDeleterAction
{
    private PreguntasDeleter $preguntasDeleter;

    private JsonRenderer $renderer;

    public function __construct(PreguntasDeleter $preguntasDeleter, JsonRenderer $renderer)
    {
        $this->preguntasDeleter = $preguntasDeleter;
        $this->renderer = $renderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $preguntasId = (int)$args['preguntas_id'];

        // Invoke the domain (service class)
        $this->preguntasDeleter->deletePreguntas($preguntasId);

        // Render the json response
        return $this->renderer->json($response, 'Registro eliminado');
    }
}
