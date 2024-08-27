<?php

namespace App\Action\Formato_Citas;

use App\Domain\Formato_Citas\Service\Formato_CitasCreator;
use App\Renderer\JsonRenderer;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class Formato_CitasCreatorAction
{
    private JsonRenderer $renderer;

    private Formato_CitasCreator $formato_citasCreator;

    public function __construct(Formato_CitasCreator $formato_citasCreator, JsonRenderer $renderer)
    {
        $this->formato_citasCreator = $formato_citasCreator;
        $this->renderer = $renderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Extract the form data from the request body
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $formato_citasId = $this->formato_citasCreator->createFormato_Citas($data);

        // Build the HTTP response
        return $this->renderer
            ->json($response, ['formato_citas_id' => $formato_citasId])
            ->withStatus(StatusCodeInterface::STATUS_CREATED);
    }
}
