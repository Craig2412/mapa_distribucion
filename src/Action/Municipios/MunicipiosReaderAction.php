<?php

namespace App\Action\Municipios;

use App\Domain\Municipios\Data\MunicipiosReaderResult;
use App\Domain\Municipios\Service\MunicipiosReader;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class MunicipiosReaderAction
{
    private MunicipiosReader $municipiosReader;

    private JsonRenderer $renderer;

    public function __construct(MunicipiosReader $municipiosReader, JsonRenderer $jsonRenderer)
    {
        $this->municipiosReader = $municipiosReader;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $municipiosId = (int)$args['municipios_id'];

        // Invoke the domain and get the result
        $municipios = $this->municipiosReader->getMunicipios($municipiosId);

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($municipios));
    }

    private function transform(MunicipiosReaderResult $municipios): array
    {
        return [
            'id' => $municipios->id,
            'municipio' => $municipios->municipio
        ];
    }
}
