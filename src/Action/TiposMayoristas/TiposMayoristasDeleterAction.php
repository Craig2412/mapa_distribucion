<?php

namespace App\Action\TiposMayoristas;

use App\Domain\TiposMayoristas\Service\TiposMayoristasDeleter;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class TiposMayoristasDeleterAction
{
    private TiposMayoristasDeleter $tiposMayoristasDeleter;

    private JsonRenderer $renderer;

    public function __construct(TiposMayoristasDeleter $tiposMayoristasDeleter, JsonRenderer $renderer)
    {
        $this->iposMayoristasDeleter = $tiposMayoristasDeleter;
        $this->renderer = $renderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $tiposMayoristasId = (int)$args['tiposMayoristas_id'];

        // Invoke the domain (service class)
        $this->iposMayoristasDeleter->deleteTiposMayoristas($tiposMayoristasId);

        // Render the json response
        return $this->renderer->json($response, 'Registro eliminado');
    }
}
