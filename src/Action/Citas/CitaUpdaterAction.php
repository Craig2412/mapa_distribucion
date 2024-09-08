<?php

namespace App\Action\Citas;

use App\Domain\Cita\Service\CitaUpdater;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class CitaUpdaterAction
{
    private CitaUpdater $citaUpdater;

    private JsonRenderer $renderer;

    public function __construct(CitaUpdater $citaUpdater, JsonRenderer $jsonRenderer)
    {
        $this->citaUpdater = $citaUpdater;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Extract the form data from the request body
        $citaId = (int)$args['id_cita'];
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $new_data = $this->citaUpdater->updateCita($citaId, $data);

        // Build the HTTP response
        return $this->renderer->json($response,['datosNuevos' => $new_data]);
    }
}
