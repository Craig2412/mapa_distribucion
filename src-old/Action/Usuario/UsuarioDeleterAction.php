<?php

namespace App\Action\Usuario;

use App\Domain\Usuario\Service\UsuarioDeleter;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class UsuarioDeleterAction
{
    private UsuarioDeleter $usuarioDeleter;

    private JsonRenderer $renderer;

    public function __construct(UsuarioDeleter $usuarioDeleter, JsonRenderer $renderer)
    {
        $this->usuarioDeleter = $usuarioDeleter;
        $this->renderer = $renderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $usuarioId = (int)$args['usuario_id'];

        // Invoke the domain (service class)
        $this->usuarioDeleter->deleteUsuario($usuarioId);

        // Render the json response
        return $this->renderer->json($response, 'Registro eliminado');
    }
}
