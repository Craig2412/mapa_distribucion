<?php

namespace App\Action\UsuariosBufetes;

use App\Domain\UsuariosBufetes\Service\UsuariosBufetesDeleter;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class UsuariosBufetesDeleterAction
{
    private UsuariosBufetesDeleter $usuariosbufetesDeleter;

    private JsonRenderer $renderer;

    public function __construct(UsuariosBufetesDeleter $usuariosbufetesDeleter, JsonRenderer $renderer)
    {
        $this->usuariosbufetesDeleter = $usuariosbufetesDeleter;
        $this->renderer = $renderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $usuariosbufetesId = (int)$args['usuarios_bufete_id'];
        // Invoke the domain (service class)
        $this->usuariosbufetesDeleter->deleteUsuariosBufetes($usuariosbufetesId);
        // Render the json response
        return $this->renderer->json($response, 'Registro eliminado');
    }
}
