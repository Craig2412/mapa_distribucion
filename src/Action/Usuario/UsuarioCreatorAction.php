<?php

namespace App\Action\Usuario;

use App\Domain\Usuario\Service\UsuarioCreator;
use App\Renderer\JsonRenderer;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class UsuarioCreatorAction
{
    private JsonRenderer $renderer;

    private UsuarioCreator $usuarioCreator;

    public function __construct(UsuarioCreator $usuarioCreator, JsonRenderer $renderer)
    {
        $this->usuarioCreator = $usuarioCreator;
        $this->renderer = $renderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Extract the form data from the request body
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $usuarioId = $this->usuarioCreator->createUsuario($data);

        // Build the HTTP response
        return $this->renderer
            ->json($response, ['usuario_id' => $usuarioId])
            ->withStatus(StatusCodeInterface::STATUS_CREATED);
    }
}
