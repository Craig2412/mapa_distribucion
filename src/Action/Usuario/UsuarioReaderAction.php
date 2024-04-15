<?php

namespace App\Action\Usuario;

use App\Domain\Usuario\Data\UsuarioReaderResult;
use App\Domain\Usuario\Service\UsuarioReader;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class UsuarioReaderAction
{
    private UsuarioReader $usuarioReader;

    private JsonRenderer $renderer;

    public function __construct(UsuarioReader $usuarioReader, JsonRenderer $jsonRenderer)
    {
        $this->usuarioReader = $usuarioReader;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $usuarioId = (int)$args['usuario_id'];

        // Invoke the domain and get the result
        $usuario = $this->usuarioReader->getUsuario($usuarioId);

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($usuario));
    }

    private function transform(UsuarioReaderResult $usuario): array
    {
        return [
            'id' => $usuario->id,
            'name' => $usuario->name,
            'identification' => $usuario->identification,
            'email' => $usuario->email,
            'id_role' => $usuario->id_role,
            'role' => $usuario->role,
            'created' => $usuario->created,
            'updated' => $usuario->updated           
        ];
    }
}
