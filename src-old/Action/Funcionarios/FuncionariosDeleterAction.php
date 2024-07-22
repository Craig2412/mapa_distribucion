<?php

namespace App\Action\Funcionarios;

use App\Domain\Funcionarios\Service\FuncionariosDeleter;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class FuncionariosDeleterAction
{
    private FuncionariosDeleter $funcionariosDeleter;

    private JsonRenderer $renderer;

    public function __construct(FuncionariosDeleter $funcionariosDeleter, JsonRenderer $renderer)
    {
        $this->funcionariosDeleter = $funcionariosDeleter;
        $this->renderer = $renderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $funcionariosId = (int)$args['funcionarios_id'];

        // Invoke the domain (service class)
        $this->funcionariosDeleter->deleteFuncionarios($funcionariosId);

        // Render the json response
        return $this->renderer->json($response, 'Registro eliminado');
    }
}
