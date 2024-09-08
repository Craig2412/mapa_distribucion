<?php

namespace App\Action\Formato_Citas;

use App\Domain\Formato_Citas\Service\Formato_CitasUpdater;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class Formato_CitasUpdaterAction
{
    private Formato_CitasUpdater $formato_citasUpdater;

    private JsonRenderer $renderer;

    public function __construct(Formato_CitasUpdater $formato_citasUpdater, JsonRenderer $jsonRenderer)
    {
        $this->formato_citasUpdater = $formato_citasUpdater;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Extract the form data from the request body
        $formato_citasId = (int)$args['formato_citas_id'];
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $new_data = $this->formato_citasUpdater->updateFormato_Citas($formato_citasId, $data);

        // Build the HTTP response
        return $this->renderer->json($response,['datosNuevos' => $new_data]);
    }
}
