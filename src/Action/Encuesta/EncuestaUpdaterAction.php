<?php

namespace App\Action\Encuesta;

use App\Domain\Encuesta\Service\EncuestaUpdater;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class EncuestaUpdaterAction
{
    private EncuestaUpdater $encuestaUpdater;

    private JsonRenderer $renderer;

    public function __construct(EncuestaUpdater $encuestaUpdater, JsonRenderer $jsonRenderer)
    {
        $this->encuestaUpdater = $encuestaUpdater;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Extract the form data from the request body
        $encuestaId = (int)$args['encuesta_id'];
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $new_data = $this->encuestaUpdater->updateEncuesta($encuestaId, $data);

        // Build the HTTP response
        return $this->renderer->json($response,['Datos nuevos' => $new_data]);
    }
}
