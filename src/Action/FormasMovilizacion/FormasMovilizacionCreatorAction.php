<?php

namespace App\Action\FormasMovilizacion;

use App\Domain\FormasMovilizacion\Service\FormasMovilizacionCreator;
use App\Renderer\JsonRenderer;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class FormasMovilizacionCreatorAction
{
    private JsonRenderer $renderer;

    private FormasMovilizacionCreator $formasMovilizacionCreator;

    public function __construct(FormasMovilizacionCreator $formasMovilizacionCreator, JsonRenderer $renderer)
    {
        $this->formasMovilizacionCreator = $formasMovilizacionCreator;
        $this->renderer = $renderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Extract the form data from the request body
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $formasMovilizacionId = $this->formasMovilizacionCreator->createFormasMovilizacion($data);

        // Build the HTTP response
        return $this->renderer
            ->json($response, ['formasMovilizacion_id' => $formasMovilizacionId])
            ->withStatus(StatusCodeInterface::STATUS_CREATED);
    }
}
/*
{
    "id_mayorista" : 1,
    "id_tipo_movilizacion" : 1
}
*/