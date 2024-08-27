<?php

namespace App\Action\TiposMayoristas;

use App\Domain\TiposMayoristas\Service\TiposMayoristasCreator;
use App\Renderer\JsonRenderer;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class TiposMayoristasCreatorAction
{
    private JsonRenderer $renderer;

    private TiposMayoristasCreator $tiposMayoristasCreator;

    public function __construct(TiposMayoristasCreator $tiposMayoristasCreator, JsonRenderer $renderer)
    {
        $this->tiposMayoristasCreator = $tiposMayoristasCreator;
        $this->renderer = $renderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Extract the form data from the request body
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        
        $data["tipo_mayorista"] = strtoupper($data["tipo_mayorista"]);
        $tiposMayoristasId = $this->tiposMayoristasCreator->createTiposMayoristas($data);

        // Build the HTTP response
        return $this->renderer
            ->json($response, ['tiposMayoristas_id' => $tiposMayoristasId])
            ->withStatus(StatusCodeInterface::STATUS_CREATED);
    }
}
/*
{
    "tipo_mayorista" : "Comercializadora"
}
*/