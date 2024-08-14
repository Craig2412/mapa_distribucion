<?php

namespace App\Action\Municipios;

use App\Domain\Municipios\Data\MunicipiosFinderResult;
use App\Domain\Municipios\Service\MunicipiosFinder;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class MunicipiosFinderAction
{
    private MunicipiosFinder $municipiosFinder;

    private JsonRenderer $renderer;

    public function __construct(MunicipiosFinder $municipiosFinder, JsonRenderer $jsonRenderer)
    {
        $this->municipiosFinder = $municipiosFinder;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        // Optional: Pass parameters from the request to the service method
        // ...
        $estadoId = (int)$args['estado_id'];

        $municipioss = $this->municipiosFinder->findMunicipioss($estadoId);

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($municipioss));
    }

    public function transform(MunicipiosFinderResult $result): array
    {
        $municipioss = [];

        foreach ($result->municipioss as $municipios) {
            $municipioss[] = [
                'id' => $municipios->id,
                'municipio' => $municipios->municipio
            ];
        }

        return [
            'municipioss' => $municipioss,
        ];
    }
}
