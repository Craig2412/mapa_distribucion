<?php

namespace App\Action\RubrosOrigen;

use App\Domain\RubrosOrigen\Data\RubrosOrigenFinderResult;
use App\Domain\RubrosOrigen\Service\RubrosOrigenFinder;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class RubrosOrigenFinderAction
{
    private RubrosOrigenFinder $rubrosOrigenFinder;

    private JsonRenderer $renderer;

    public function __construct(RubrosOrigenFinder $rubrosOrigenFinder, JsonRenderer $jsonRenderer)
    {
        $this->rubrosOrigenFinder = $rubrosOrigenFinder;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Optional: Pass parameters from the request to the service method
        // ...

        $rubrosOrigens = $this->rubrosOrigenFinder->findRubrosOrigens();

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($rubrosOrigens));
    }

    public function transform(RubrosOrigenFinderResult $result): array
    {
        $rubrosOrigens = [];

        foreach ($result->rubrosOrigens as $rubrosOrigen) {
            $rubrosOrigens[] = [
                'id' => $rubrosOrigen->id,
                'rubro' => $rubrosOrigen->rubro,
                'presentacion' => $rubrosOrigen->presentacion,
                'precio_ves' => $rubrosOrigen->precio_ves,
                'precio_ptr' => $rubrosOrigen->precio_ptr
            ];
        }

        return [
            'rubrosOrigens' => $rubrosOrigens,
        ];
    }
}
