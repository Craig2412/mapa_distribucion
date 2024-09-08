<?php

namespace App\Action\Requerimientos;

use App\Domain\Requerimientos\Service\RequerimientosUpdater;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class RequerimientosUpdaterAction
{
    private RequerimientosUpdater $requerimientosUpdater;

    private JsonRenderer $renderer;

    public function __construct(RequerimientosUpdater $requerimientosUpdater, JsonRenderer $jsonRenderer)
    {
        $this->requerimientosUpdater = $requerimientosUpdater;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Extract the form data from the request body
        $requerimientosId = (int)$args['id_requerimiento'];
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $new_date = $this->requerimientosUpdater->updateRequerimientos($requerimientosId, $data);

        // Build the HTTP response
        return $this->renderer->json($response,['datosNuevos' => $new_date]);
    }
}
