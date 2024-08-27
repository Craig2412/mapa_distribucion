<?php

namespace App\Action\UsuariosAreas;

use App\Domain\UsuariosAreas\Service\UsuariosAreasDeleter;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class UsuariosAreasDeleterAction
{
    private UsuariosAreasDeleter $usuariosareasDeleter;

    private JsonRenderer $renderer;

    public function __construct(UsuariosAreasDeleter $usuariosareasDeleter, JsonRenderer $renderer)
    {
        $this->usuariosareasDeleter = $usuariosareasDeleter;
        $this->renderer = $renderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $usuariosareasId = (int)$args['usuarios_area_id'];
        // Invoke the domain (service class)
        $this->usuariosareasDeleter->deleteUsuariosAreas($usuariosareasId);
        // Render the json response
        return $this->renderer->json($response, 'Registro eliminado');
    }
}
