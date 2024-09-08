<?php

namespace App\Action\Citas;

use App\Domain\Cita\Service\CitaDeleter;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class CitaDeleterAction
{
    private CitaDeleter $citaDeleter;

    private JsonRenderer $renderer;

    public function __construct(CitaDeleter $citaDeleter, JsonRenderer $renderer)
    {
        $this->citaDeleter = $citaDeleter;
        $this->renderer = $renderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $citaId = (int)$args['id_cita'];
        // Invoke the domain (service class)
        $this->citaDeleter->deleteCita($citaId);
        // Render the json response
        return $this->renderer->json($response, 'Registro eliminado');
    }
}
