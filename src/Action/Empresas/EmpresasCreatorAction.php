<?php

namespace App\Action\Empresas;

use App\Domain\Empresas\Service\EmpresasCreator;
use App\Renderer\JsonRenderer;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class EmpresasCreatorAction
{
    private JsonRenderer $renderer;

    private EmpresasCreator $empresasCreator;

    public function __construct(EmpresasCreator $empresasCreator, JsonRenderer $renderer)
    {
        $this->empresasCreator = $empresasCreator;
        $this->renderer = $renderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Extract the form data from the request body
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $empresasId = $this->empresasCreator->createEmpresas($data);

        // Build the HTTP response
        return $this->renderer
            ->json($response, ['empresas_id' => $empresasId])
            ->withStatus(StatusCodeInterface::STATUS_CREATED);
    }
}
