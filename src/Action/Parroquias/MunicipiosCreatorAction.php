<?php

namespace App\Action\Estados;

use App\Domain\Estados\Service\EstadosCreator;
use App\Renderer\JsonRenderer;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class EstadosCreatorAction
{
    private JsonRenderer $renderer;

    private EstadosCreator $estadosCreator;

    public function __construct(EstadosCreator $estadosCreator, JsonRenderer $renderer)
    {
        $this->estadosCreator = $estadosCreator;
        $this->renderer = $renderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Extract the form data from the request body
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $estadosId = $this->estadosCreator->createEstados($data);

        // Build the HTTP response
        return $this->renderer
            ->json($response, ['estados_id' => $estadosId])
            ->withStatus(StatusCodeInterface::STATUS_CREATED);
    }
}
