<?php

namespace App\Action\Empresas;

use App\Domain\Empresas\Service\EmpresasUpdater;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class EmpresasUpdaterAction
{
    private EmpresasUpdater $empresasUpdater;

    private JsonRenderer $renderer;

    public function __construct(EmpresasUpdater $empresasUpdater, JsonRenderer $jsonRenderer)
    {
        $this->empresasUpdater = $empresasUpdater;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Extract the form data from the request body
        $empresasId = (int)$args['empresas_id'];
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $new_data = $this->empresasUpdater->updateEmpresas($empresasId, $data);

        // Build the HTTP response
        return $this->renderer->json($response,['Datos nuevos' => $new_data]);
    }
}
