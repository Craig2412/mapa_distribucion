<?php

namespace App\Action\Usuario;

use App\Domain\Usuario\Data\UsuarioFinderResult;
use App\Domain\Usuario\Service\UsuarioFinder;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class UsuarioFinderAction
{
    private UsuarioFinder $usuarioFinder;

    private JsonRenderer $renderer;

    public function __construct(UsuarioFinder $usuarioFinder, JsonRenderer $jsonRenderer)
    {
        $this->usuarioFinder = $usuarioFinder;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Optional: Pass parameters from the request to the service method
        // ...

        $usuarios = $this->usuarioFinder->findUsuarios();

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($usuarios));
    }

    public function transform(UsuarioFinderResult $result): array
    {
        $usuarios = [];
        foreach ($result->usuarios as $usuario) {
            $usuarios[] = [
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

        return [
            'usuarios' => $usuarios,
        ];
    }
}
