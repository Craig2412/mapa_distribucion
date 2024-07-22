<?php

namespace App\Action\Preguntas;

use App\Domain\Preguntas\Service\PreguntasUpdater;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class PreguntasUpdaterAction
{
    private PreguntasUpdater $preguntasUpdater;

    private JsonRenderer $renderer;

    public function __construct(PreguntasUpdater $preguntasUpdater, JsonRenderer $jsonRenderer)
    {
        $this->preguntasUpdater = $preguntasUpdater;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Extract the form data from the request body
        $preguntasId = (int)$args['preguntas_id'];
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $new_data = $this->preguntasUpdater->updatePreguntas($preguntasId, $data);

        // Build the HTTP response
        return $this->renderer->json($response,['Datos nuevos' => $new_data]);
    }
}
