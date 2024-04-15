<?php

namespace App\Action\Preguntas;

use App\Domain\Preguntas\Data\PreguntasFinderResult;
use App\Domain\Preguntas\Service\PreguntasFinder;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class PreguntasFinderAction
{
    private PreguntasFinder $preguntasFinder;

    private JsonRenderer $renderer;

    public function __construct(PreguntasFinder $preguntasFinder, JsonRenderer $jsonRenderer)
    {
        $this->preguntasFinder = $preguntasFinder;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Optional: Pass parameters from the request to the service method
        // ...

        $preguntass = $this->preguntasFinder->findPreguntass();

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($preguntass));
    }

    public function transform(PreguntasFinderResult $result): array
    {
        $preguntass = [];

        foreach ($result->preguntass as $preguntas) {
            $preguntass[] = [
                'id' => $preguntas->id,
                'pregunta' => $preguntas->pregunta,
                'etiqueta' => $preguntas->etiqueta
            ];
        }

        return [
            'preguntass' => $preguntass,
        ];
    }
}
