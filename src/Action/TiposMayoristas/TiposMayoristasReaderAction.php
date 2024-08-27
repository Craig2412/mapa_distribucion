<?php

namespace App\Action\TiposMayoristas;

use App\Domain\TiposMayoristas\Data\TiposMayoristasReaderResult;
use App\Domain\TiposMayoristas\Service\TiposMayoristasReader;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class TiposMayoristasReaderAction
{
    private TiposMayoristasReader $tiposMayoristasReader;

    private JsonRenderer $renderer;

    public function __construct(TiposMayoristasReader $tiposMayoristasReader, JsonRenderer $jsonRenderer)
    {
        $this->tiposMayoristasReader = $tiposMayoristasReader;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $tiposMayoristasId = (int)$args['tiposMayoristas_id'];

        // Invoke the domain and get the result
        $tiposMayoristas = $this->tiposMayoristasReader->getTiposMayoristas($tiposMayoristasId);

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($tiposMayoristas));
    }

    private function transform(TiposMayoristasReaderResult $tiposMayoristas): array
    {
        return [
            'id' => $tiposMayoristas->id,
            'tipo_mayorista' => $tiposMayoristas->tipo_mayorista
        ];
    }
}
