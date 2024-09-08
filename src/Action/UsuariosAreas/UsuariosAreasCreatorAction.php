<?php

namespace App\Action\UsuariosAreas;

use App\Domain\UsuariosAreas\Service\UsuariosAreasCreator;
use App\Renderer\JsonRenderer;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use App\Auth\Auth;

final class UsuariosAreasCreatorAction
{
    private JsonRenderer $renderer;

    private UsuariosAreasCreator $usuariosareasCreator;

    public function __construct(UsuariosAreasCreator $usuariosareasCreator, JsonRenderer $renderer)
    {
        $this->usuariosareasCreator = $usuariosareasCreator;
        $this->renderer = $renderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $aud = Auth::Aud();
        if ($aud !== 'https://censoapi.sapi.gob.ve') {
            return $response->withStatus(401);
        }
        // Extract the form data from the request body
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $usuariosareasId = $this->usuariosareasCreator->createUsuariosAreas($data);

        // Build the HTTP response
        return $this->renderer
            ->json($response, ['usuariosareas_id' => $usuariosareasId])
            ->withStatus(StatusCodeInterface::STATUS_CREATED);
    }
}
