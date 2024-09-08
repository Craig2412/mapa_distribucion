<?php

namespace App\Action\Paises;

use App\Domain\Paises\Data\PaisesReaderResult;
use App\Domain\Paises\Service\PaisesReader;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class PaisesReaderAction
{
    private PaisesReader $paisesReader;

    private JsonRenderer $renderer;

    public function __construct(PaisesReader $paisesReader, JsonRenderer $jsonRenderer)
    {
        $this->paisesReader = $paisesReader;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $paisesId = (int)$args['pais_id'];

        // Invoke the domain and get the result
        $paises = $this->paisesReader->getPaises($paisesId);

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($paises));
    }

    private function transform(PaisesReaderResult $paises): array
    {
        return [
            'id' => $paises->id,
            'pais' => $paises->pais           
        ];
    }
}
