<?php

namespace App\Action\Estatus_aplicacion;

use App\Domain\Estatus_aplicacion\Service\Estatus_aplicacionUpdater;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class Estatus_aplicacionUpdaterAction
{
    private Estatus_aplicacionUpdater $estatus_aplicacionUpdater;

    private JsonRenderer $renderer;

    public function __construct(Estatus_aplicacionUpdater $estatus_aplicacionUpdater, JsonRenderer $jsonRenderer)
    {
        $this->estatus_aplicacionUpdater = $estatus_aplicacionUpdater;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Extract the form data from the request body
        $estatus_aplicacionId = (int)$args['estatus_aplicacion_id'];
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $new_data = $this->estatus_aplicacionUpdater->updateEstatus_aplicacion($estatus_aplicacionId, $data);

        // Build the HTTP response
        return $this->renderer->json($response,['Datos nuevos' => $new_data]);
    }
}
