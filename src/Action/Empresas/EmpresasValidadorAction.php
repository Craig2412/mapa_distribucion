<?php

namespace App\Action\Empresas;

use App\Domain\Empresas\Service\EmpresasValidator;
use App\Renderer\JsonRenderer;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class EmpresasValidadorAction
{
    private JsonRenderer $renderer;

    private EmpresasValidator $EmpresasValidator;

    public function __construct(EmpresasValidator $EmpresasValidator, JsonRenderer $renderer)
    {
        $this->EmpresasValidator = $EmpresasValidator;
        $this->renderer = $renderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Extract the form data from the request body
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $empresasId = $this->EmpresasValidator->validateRepresentanteLegal($data);

        // Build the HTTP response
        return $this->renderer
            ->json($response, ['estatus' => true])
            ->withStatus(StatusCodeInterface::STATUS_CREATED);
    }
}
