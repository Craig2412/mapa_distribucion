<?php

namespace App\Action\Cargos;

use App\Domain\Cargos\Service\CargosCreator;
use App\Renderer\JsonRenderer;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class CargosCreatorAction
{
    private JsonRenderer $renderer;

    private CargosCreator $cargosCreator;

    public function __construct(CargosCreator $cargosCreator, JsonRenderer $renderer)
    {
        $this->cargosCreator = $cargosCreator;
        $this->renderer = $renderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Extract the form data from the request body
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $cargosId = $this->cargosCreator->createCargos($data);

        // Build the HTTP response
        return $this->renderer
            ->json($response, ['id_cargo' => $cargosId])
            ->withStatus(StatusCodeInterface::STATUS_CREATED);
    }
}
