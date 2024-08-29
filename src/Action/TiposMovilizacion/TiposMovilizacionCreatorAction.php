<?php

namespace App\Action\TiposMovilizacion;

use App\Domain\TiposMovilizacion\Service\TiposMovilizacionCreator;
use App\Renderer\JsonRenderer;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class TiposMovilizacionCreatorAction
{
    private JsonRenderer $renderer;

    private TiposMovilizacionCreator $tiposMovilizacionCreator;

    public function __construct(TiposMovilizacionCreator $tiposMovilizacionCreator, JsonRenderer $renderer)
    {
        $this->tiposMovilizacionCreator = $tiposMovilizacionCreator;
        $this->renderer = $renderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Extract the form data from the request body
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        
        $data["tipo_movilizacion"] = strtoupper($data["tipo_movilizacion"]);
        $tiposMovilizacionId = $this->tiposMovilizacionCreator->createTiposMovilizacion($data);

        // Build the HTTP response
        return $this->renderer
            ->json($response, ['tiposMovilizacion_id' => $tiposMovilizacionId])
            ->withStatus(StatusCodeInterface::STATUS_CREATED);
    }
}
/*
{
    "tipo_movilizacion" : "Comercializadora"
}
*/