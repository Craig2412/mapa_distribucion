<?php

namespace App\Action\Encuesta;

use App\Domain\Encuesta\Data\EncuestaFinderResult;
use App\Domain\Encuesta\Service\EncuestaFinder;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class EncuestaFinderAction
{
    private EncuestaFinder $encuestasFinder;

    private JsonRenderer $renderer;

    public function __construct(EncuestaFinder $encuestasFinder, JsonRenderer $jsonRenderer)
    {
        $this->encuestasFinder = $encuestasFinder;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Optional: Pass parameters from the request to the service method
        // ...

        $encuestass = $this->encuestasFinder->findEncuestas();

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($encuestass));
    }

    public function transform(EncuestaFinderResult $result): array
    { 
        $encuestass = [];
        foreach ($result->encuestas as $encuesta) {
            $encuestass[] = [
                'id' => $encuesta->id,
                'id_funcionario' => $encuesta->id_funcionario,
                'funcionario' => $encuesta->funcionario,
                'id_pregunta' => $encuesta->id_pregunta,
                'pregunta' => $encuesta->pregunta,
                'respuesta' => $encuesta->respuesta
            ];
        }

        return [
            'encuestass' => $encuestass,
        ];
    }
}
