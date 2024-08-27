<?php

namespace App\Action\TiposMayoristas;

use App\Domain\TiposMayoristas\Service\TiposMayoristasUpdater;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class TiposMayoristasUpdaterAction
{
    private TiposMayoristasUpdater $tiposMayoristasUpdater;

    private JsonRenderer $renderer;

    public function __construct(TiposMayoristasUpdater $tiposMayoristasUpdater, JsonRenderer $jsonRenderer)
    {
        $this->tiposMayoristasUpdater = $tiposMayoristasUpdater;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Extract the form data from the request body
        $tiposMayoristasId = (int)$args['tiposMayoristas_id'];
        $data = (array)$request->getParsedBody();
        $data["tipo_mayorista"] = strtoupper($data["tipo_mayorista"]);

        // Invoke the Domain with inputs and retain the result
        $new_data = $this->tiposMayoristasUpdater->updateTiposMayoristas($tiposMayoristasId, $data);

        // Build the HTTP response
        return $this->renderer->json($response,['Datos nuevos' => $new_data]);
    }
}
/*
{
    "tipo_mayorista" : "Comercializadora"
}
*/