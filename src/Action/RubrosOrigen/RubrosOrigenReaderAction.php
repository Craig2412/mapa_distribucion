<?php

namespace App\Action\RubrosOrigen;

use App\Domain\RubrosOrigen\Data\RubrosOrigenReaderResult;
use App\Domain\RubrosOrigen\Service\RubrosOrigenReader;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class RubrosOrigenReaderAction
{
    private RubrosOrigenReader $rubrosOrigenReader;

    private JsonRenderer $renderer;

    public function __construct(RubrosOrigenReader $rubrosOrigenReader, JsonRenderer $jsonRenderer)
    {
        $this->rubrosOrigenReader = $rubrosOrigenReader;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $rubrosOrigenId = (int)$args['rubrosOrigen_id'];

        // Invoke the domain and get the result
        $rubrosOrigen = $this->rubrosOrigenReader->getRubrosOrigen($rubrosOrigenId);

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($rubrosOrigen));
    }

    private function transform(RubrosOrigenReaderResult $rubrosOrigen): array
    {
        return [
            'id' => $rubrosOrigen->id,
            'rubro' => $rubrosOrigen->rubro,
            'presentacion' => $rubrosOrigen->presentacion,
            'precio_ves' => $rubrosOrigen->precio_ves,
            'precio_ptr' => $rubrosOrigen->precio_ptr
        ];
    }
}
