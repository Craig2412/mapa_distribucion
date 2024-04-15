<?php

namespace App\Action\Funcionarios;

use App\Domain\Funcionarios\Service\FuncionariosCreator;
use App\Renderer\JsonRenderer;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class FuncionariosCreatorAction
{
    private JsonRenderer $renderer;

    private FuncionariosCreator $funcionariosCreator;

    public function __construct(FuncionariosCreator $funcionariosCreator, JsonRenderer $renderer)
    {
        $this->funcionariosCreator = $funcionariosCreator;
        $this->renderer = $renderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Extract the form data from the request body
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $funcionariosId = $this->funcionariosCreator->createFuncionarios($data);

        // Build the HTTP response
        return $this->renderer
            ->json($response, ['funcionarios_id' => $funcionariosId])
            ->withStatus(StatusCodeInterface::STATUS_CREATED);
    }
}
