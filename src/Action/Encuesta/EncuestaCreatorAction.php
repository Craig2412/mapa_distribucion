<?php

namespace App\Action\Encuesta;

use App\Domain\Encuesta\Service\EncuestaCreator;
use App\Renderer\JsonRenderer;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class EncuestaCreatorAction
{
    private JsonRenderer $renderer;

    private EncuestaCreator $encuestaCreator;

    public function __construct(EncuestaCreator $encuestaCreator, JsonRenderer $renderer)
    {
        $this->encuestaCreator = $encuestaCreator;
        $this->renderer = $renderer;
        
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Extract the form data from the request body
        $data = (array)$request->getParsedBody();
        // Invoke the Domain with inputs and retain the result
        $encuestaId = $this->encuestaCreator->createEncuesta($data);

        // Build the HTTP response
        return $this->renderer
            ->json($response, ['encuesta_id' => $encuestaId])
            ->withStatus(StatusCodeInterface::STATUS_CREATED);
    }
}
