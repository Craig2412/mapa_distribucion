<?php

namespace App\Action\Funcionarios;

use App\Domain\Funcionarios\Service\FuncionariosUpdater;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class FuncionariosUpdaterAction
{
    private FuncionariosUpdater $funcionariosUpdater;

    private JsonRenderer $renderer;

    public function __construct(FuncionariosUpdater $funcionariosUpdater, JsonRenderer $jsonRenderer)
    {
        $this->funcionariosUpdater = $funcionariosUpdater;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Extract the form data from the request body
        $funcionariosId = (int)$args['funcionarios_id'];
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $new_data = $this->funcionariosUpdater->updateFuncionarios($funcionariosId, $data);

        // Build the HTTP response
        return $this->renderer->json($response,['Datos nuevos' => $new_data]);
    }
}
