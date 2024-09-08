<?php

namespace App\Action\Mensaje;

use App\Domain\Mensaje\Service\MensajeDeleter;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class MensajeDeleterAction
{
    private MensajeDeleter $mensajeDeleter;

    private JsonRenderer $renderer;

    public function __construct(MensajeDeleter $mensajeDeleter, JsonRenderer $renderer)
    {
        $this->mensajeDeleter = $mensajeDeleter;
        $this->renderer = $renderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $mensajeId = (int)$args['mensaje_id'];
        // Invoke the domain (service class)
        $this->mensajeDeleter->deleteMensaje($mensajeId);
        // Render the json response
        return $this->renderer->json($response, 'Registro eliminado');
    }
}
