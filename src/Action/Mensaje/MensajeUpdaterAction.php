<?php

namespace App\Action\Mensaje;

use App\Domain\Mensaje\Service\MensajeUpdater;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class MensajeUpdaterAction
{
    private MensajeUpdater $mensajeUpdater;

    private JsonRenderer $renderer;

    public function __construct(MensajeUpdater $mensajeUpdater, JsonRenderer $jsonRenderer)
    {
        $this->mensajeUpdater = $mensajeUpdater;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Extract the form data from the request body
        $mensajeId = (int)$args['mensaje_id'];
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $new_date = $this->mensajeUpdater->updateMensaje($mensajeId, $data);

        // Build the HTTP response
        return $this->renderer->json($response,['datosNuevos' => $new_date]);
    }
}
