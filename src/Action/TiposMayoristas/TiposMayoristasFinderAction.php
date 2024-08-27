<?php

namespace App\Action\TiposMayoristas;

use App\Domain\TiposMayoristas\Data\TiposMayoristasFinderResult;
use App\Domain\TiposMayoristas\Service\TiposMayoristasFinder;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class TiposMayoristasFinderAction
{
    private TiposMayoristasFinder $tiposMayoristasFinder;

    private JsonRenderer $renderer;

    public function __construct(TiposMayoristasFinder $tiposMayoristasFinder, JsonRenderer $jsonRenderer)
    {
        $this->tiposMayoristasFinder = $tiposMayoristasFinder;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Optional: Pass parameters from the request to the service method
        // ...

        $tiposMayoristass = $this->tiposMayoristasFinder->findTiposMayoristass();

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($tiposMayoristass));
    }

    public function transform(TiposMayoristasFinderResult $result): array
    {
        $tiposMayoristass = [];

        foreach ($result->tiposMayoristass as $tiposMayoristas) {
            $tiposMayoristass[] = [
                'id' => $tiposMayoristas->id,
                'tipo_mayorista' => $tiposMayoristas->tipo_mayorista
            ];
        }

        return [
            'tiposMayoristass' => $tiposMayoristass,
        ];
    }
}
