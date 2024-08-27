<?php

namespace App\Action\TiposMayoristas;

use App\Domain\TiposMayoristas\Service\TiposMayoristasDeleter;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class TiposMayoristasDeleterAction
{
    private TiposMayoristasDeleter $iposMayoristasDeleter;

    private JsonRenderer $renderer;

    public function __construct(TiposMayoristasDeleter $iposMayoristasDeleter, JsonRenderer $renderer)
    {
        $this->iposMayoristasDeleter = $iposMayoristasDeleter;
        $this->renderer = $renderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $iposMayoristasId = (int)$args['iposMayoristas_id'];

        // Invoke the domain (service class)
        $this->iposMayoristasDeleter->deleteTiposMayoristas($iposMayoristasId);

        // Render the json response
        return $this->renderer->json($response, 'Registro eliminado');
    }
}
