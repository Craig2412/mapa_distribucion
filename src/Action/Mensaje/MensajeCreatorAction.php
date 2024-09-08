<?php

namespace App\Action\Mensaje;

use App\Domain\Mensaje\Service\MensajeCreator;
use App\Renderer\JsonRenderer;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class MensajeCreatorAction
{
    private JsonRenderer $renderer;

    private MensajeCreator $mensajeCreator;

    public function __construct(MensajeCreator $mensajeCreator, JsonRenderer $renderer)
    {
        $this->mensajeCreator = $mensajeCreator;
        $this->renderer = $renderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Extract the form data from the request body
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $mensajeId = $this->mensajeCreator->createMensaje($data);

        // Build the HTTP response
        return $this->renderer
            ->json($response, ['mensaje_id' => $mensajeId])
            ->withStatus(StatusCodeInterface::STATUS_CREATED);
    }
}
