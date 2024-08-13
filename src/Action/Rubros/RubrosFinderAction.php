<?php

namespace App\Action\Rubros;

use App\Domain\Rubros\Data\RubrosFinderResult;
use App\Domain\Rubros\Service\RubrosFinder;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class RubrosFinderAction
{
    private RubrosFinder $rubrosFinder;

    private JsonRenderer $renderer;

    public function __construct(RubrosFinder $rubrosFinder, JsonRenderer $jsonRenderer)
    {
        $this->rubrosFinder = $rubrosFinder;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Optional: Pass parameters from the request to the service method
        // ...

        $rubross = $this->rubrosFinder->findRubross();

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($rubross));
    }

    public function transform(RubrosFinderResult $result): array
    {
        $rubross = [];

        foreach ($result->rubross as $rubros) {
            $rubross[] = [
                'id' => $rubros->id,
                'rubros' => $rubros->rubros,
                'presentacion' => $rubros->presentacion,
                'precio_ves' => $rubros->precio_ves,
                'precio_ptr' => $rubros->precio_ptr
            ];
        }

        return [
            'rubross' => $rubross,
        ];
    }
}
