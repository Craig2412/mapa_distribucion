<?php

namespace App\Action\Preguntas;

use App\Domain\Preguntas\Service\PreguntasCreator;
use App\Renderer\JsonRenderer;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class PreguntasCreatorAction
{
    private JsonRenderer $renderer;

    private PreguntasCreator $preguntasCreator;

    public function __construct(PreguntasCreator $preguntasCreator, JsonRenderer $renderer)
    {
        $this->preguntasCreator = $preguntasCreator;
        $this->renderer = $renderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Extract the form data from the request body
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $preguntasId = $this->preguntasCreator->createPreguntas($data);

        // Build the HTTP response
        return $this->renderer
            ->json($response, ['preguntas_id' => $preguntasId])
            ->withStatus(StatusCodeInterface::STATUS_CREATED);
    }
}
