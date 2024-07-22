<?php

namespace App\Action\Estatus;

use App\Domain\Estatus\Service\EstatusDeleter;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class EstatusDeleterAction
{
    private EstatusDeleter $estatusDeleter;

    private JsonRenderer $renderer;

    public function __construct(EstatusDeleter $estatusDeleter, JsonRenderer $renderer)
    {
        $this->estatusDeleter = $estatusDeleter;
        $this->renderer = $renderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $estatusId = (int)$args['estatus_id'];

        // Invoke the domain (service class)
        $this->estatusDeleter->deleteEstatus($estatusId);

        // Render the json response
        return $this->renderer->json($response, 'Registro eliminado');
    }
}
