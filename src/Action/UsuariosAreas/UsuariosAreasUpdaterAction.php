<?php

namespace App\Action\UsuariosAreas;

use App\Domain\UsuariosAreas\Service\UsuariosAreasUpdater;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class UsuariosAreasUpdaterAction
{
    private UsuariosAreasUpdater $usuariosareasUpdater;

    private JsonRenderer $renderer;

    public function __construct(UsuariosAreasUpdater $usuariosareasUpdater, JsonRenderer $jsonRenderer)
    {
        $this->usuariosareasUpdater = $usuariosareasUpdater;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Extract the form data from the request body
        $usuariosareasId = (int)$args['usuarios_area_id'];
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $new_date = $this->usuariosareasUpdater->updateUsuariosAreas($usuariosareasId, $data);

        // Build the HTTP response
        return $this->renderer->json($response,['datosNuevos' => $new_date]);
    }
}
