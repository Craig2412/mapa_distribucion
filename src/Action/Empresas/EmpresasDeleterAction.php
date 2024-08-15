<?php

namespace App\Action\Empresas;

use App\Domain\Empresas\Service\EmpresasDeleter;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class EmpresasDeleterAction
{
    private EmpresasDeleter $empresasDeleter;

    private JsonRenderer $renderer;

    public function __construct(EmpresasDeleter $empresasDeleter, JsonRenderer $renderer)
    {
        $this->empresasDeleter = $empresasDeleter;
        $this->renderer = $renderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $empresasId = (int)$args['empresas_id'];

        // Invoke the domain (service class)
        $this->empresasDeleter->deleteEmpresas($empresasId);

        // Render the json response
        return $this->renderer->json($response, 'Registro eliminado');
    }
}
