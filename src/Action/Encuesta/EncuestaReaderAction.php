<?php

namespace App\Action\Encuesta;

use App\Domain\Encuesta\Data\EncuestaReaderResult;
use App\Domain\Encuesta\Service\EncuestaReader;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class EncuestaReaderAction
{
    private EncuestaReader $encuestaReader;

    private JsonRenderer $renderer;

    public function __construct(EncuestaReader $encuestaReader, JsonRenderer $jsonRenderer)
    {
        $this->encuestaReader = $encuestaReader;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $encuestaId = (int)$args['encuesta_id'];

        // Invoke the domain and get the result
        $encuesta = $this->encuestaReader->getEncuesta($encuestaId);

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($encuesta));
    }

    private function transform(EncuestaReaderResult $encuesta): array
    {
        return [
            'id' => $encuestas->id,
            'id_funcionario' => $encuestas->id_funcionario,
            'funcionario' => $encuestas->funcionario,
            'id_pregunta' => $encuestas->id_pregunta,
            'pregunta' => $encuestas->pregunta,
            'respuesta' => $encuestas->respuesta
        ];
    }
}
