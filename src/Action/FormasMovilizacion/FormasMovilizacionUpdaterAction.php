<?php

namespace App\Action\TiposMovilizacion;

use App\Domain\TiposMovilizacion\Service\TiposMovilizacionUpdater;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class TiposMovilizacionUpdaterAction
{
    private TiposMovilizacionUpdater $formasMovilizacionUpdater;

    private JsonRenderer $renderer;

    public function __construct(TiposMovilizacionUpdater $formasMovilizacionUpdater, JsonRenderer $jsonRenderer)
    {
        $this->formasMovilizacionUpdater = $formasMovilizacionUpdater;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Extract the form data from the request body
        $formasMovilizacionId = (int)$args['formasMovilizacion_id'];
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $new_data = $this->formasMovilizacionUpdater->updateTiposMovilizacion($formasMovilizacionId, $data);

        // Build the HTTP response
        return $this->renderer->json($response,['Datos nuevos' => $new_data]);
    }
}
/*
{
    "id_mayorista" : 1,
    "id_tipo_movilizacion" : 1
}
*/