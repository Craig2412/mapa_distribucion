<?php

namespace App\Action\TiposMovilizacion;

use App\Domain\TiposMovilizacion\Service\TiposMovilizacionUpdater;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class TiposMovilizacionUpdaterAction
{
    private TiposMovilizacionUpdater $tiposMovilizacionUpdater;

    private JsonRenderer $renderer;

    public function __construct(TiposMovilizacionUpdater $tiposMovilizacionUpdater, JsonRenderer $jsonRenderer)
    {
        $this->tiposMovilizacionUpdater = $tiposMovilizacionUpdater;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Extract the form data from the request body
        $tiposMovilizacionId = (int)$args['tiposMovilizacion_id'];
        $data = (array)$request->getParsedBody();
        $data["tipo_movilizacion"] = strtoupper($data["tipo_movilizacion"]);

        // Invoke the Domain with inputs and retain the result
        $new_data = $this->tiposMovilizacionUpdater->updateTiposMovilizacion($tiposMovilizacionId, $data);

        // Build the HTTP response
        return $this->renderer->json($response,['Datos nuevos' => $new_data]);
    }
}
/*
{
    "tipo_movilizacion" : "Comercializadora"
}
*/