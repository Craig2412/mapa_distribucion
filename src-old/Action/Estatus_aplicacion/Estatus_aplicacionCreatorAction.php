<?php

namespace App\Action\Estatus_aplicacion;

use App\Domain\Estatus_aplicacion\Service\Estatus_aplicacionCreator;
use App\Renderer\JsonRenderer;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class Estatus_aplicacionCreatorAction
{
    private JsonRenderer $renderer;

    private Estatus_aplicacionCreator $estatus_aplicacionCreator;

    public function __construct(Estatus_aplicacionCreator $estatus_aplicacionCreator, JsonRenderer $renderer)
    {
        $this->estatus_aplicacionCreator = $estatus_aplicacionCreator;
        $this->renderer = $renderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Extract the form data from the request body
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $estatus_aplicacionId = $this->estatus_aplicacionCreator->createEstatus_aplicacion($data);

        // Build the HTTP response
        return $this->renderer
            ->json($response, ['estatus_aplicacion_id' => $estatus_aplicacionId])
            ->withStatus(StatusCodeInterface::STATUS_CREATED);
    }
}
