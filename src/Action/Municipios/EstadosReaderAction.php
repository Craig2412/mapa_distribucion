<?php

namespace App\Action\Rubros;

use App\Domain\Rubros\Data\RubrosReaderResult;
use App\Domain\Rubros\Service\RubrosReader;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class RubrosReaderAction
{
    private RubrosReader $rubrosReader;

    private JsonRenderer $renderer;

    public function __construct(RubrosReader $rubrosReader, JsonRenderer $jsonRenderer)
    {
        $this->rubrosReader = $rubrosReader;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $rubrosId = (int)$args['rubros_id'];

        // Invoke the domain and get the result
        $rubros = $this->rubrosReader->getRubros($rubrosId);

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($rubros));
    }

    private function transform(RubrosReaderResult $rubros): array
    {
        return [
            'id' => $rubros->id,
            'rubros' => $rubros->rubros,
            'presentacion' => $rubros->presentacion,
            'precio_ves' => $rubros->precio_ves,
            'precio_ptr' => $rubros->precio_ptr
        ];
    }
}
