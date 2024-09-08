<?php

namespace App\Action\Preguntas;

use App\Domain\Preguntas\Data\PreguntasReaderResult;
use App\Domain\Preguntas\Service\PreguntasReader;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class PreguntasReaderAction
{
    private PreguntasReader $preguntasReader;

    private JsonRenderer $renderer;

    public function __construct(PreguntasReader $preguntasReader, JsonRenderer $jsonRenderer)
    {
        $this->preguntasReader = $preguntasReader;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $preguntasId = (int)$args['preguntas_id'];

        // Invoke the domain and get the result
        $preguntas = $this->preguntasReader->getPreguntas($preguntasId);

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($preguntas));
    }

    private function transform(PreguntasReaderResult $preguntas): array
    {
        return [
            'id' => $preguntas->id,
            'pregunta' => $preguntas->pregunta,
            'etiqueta' => $preguntas->etiqueta
        ];
    }
}
