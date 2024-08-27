<?php

namespace App\Action\Estados_Paises;

use App\Domain\Estados_Paises\Data\Estados_PaisesReaderResult;
use App\Domain\Estados_Paises\Service\Estados_PaisesReader;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class Estados_PaisesReaderAction
{
    private Estados_PaisesReader $estados_paisesReader;

    private JsonRenderer $renderer;

    public function __construct(Estados_PaisesReader $estados_paisesReader, JsonRenderer $jsonRenderer)
    {
        $this->estados_paisesReader = $estados_paisesReader;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $estados_paisesId = (int)$args['estado_pais_id'];

        // Invoke the domain and get the result
        $estados_paises = $this->estados_paisesReader->getEstados_Paises($estados_paisesId);

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($estados_paises));
    }

    private function transform(Estados_PaisesReaderResult $estados_paises): array
    {
        return [
            'id' => $estados_paises->id,
            'estado_pais' => $estados_paises->estado_pais           
        ];
    }
}
