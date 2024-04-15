<?php

namespace App\Action\Usuario;

use App\Domain\Usuario\Service\UsuarioUpdater;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class UsuarioUpdaterAction
{
    private UsuarioUpdater $usuarioUpdater;

    private JsonRenderer $renderer;

    public function __construct(UsuarioUpdater $usuarioUpdater, JsonRenderer $jsonRenderer)
    {
        $this->usuarioUpdater = $usuarioUpdater;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Extract the form data from the request body
        $usuarioId = (int)$args['usuario_id'];
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $new_data = $this->usuarioUpdater->updateUsuario($usuarioId, $data);

        // Build the HTTP response
        return $this->renderer->json($response,['Datos nuevos' => $new_data]);
    }
}
