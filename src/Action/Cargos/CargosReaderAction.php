<?php

namespace App\Action\Cargos;

use App\Domain\Cargos\Data\CargosReaderResult;
use App\Domain\Cargos\Service\CargosReader;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class CargosReaderAction
{
    private CargosReader $cargosReader;

    private JsonRenderer $renderer;

    public function __construct(CargosReader $cargosReader, JsonRenderer $jsonRenderer)
    {
        $this->cargosReader = $cargosReader;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $cargosId = (int)$args['id'];

        // Invoke the domain and get the result
        $cargos = $this->cargosReader->getCargos($cargosId);

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($cargos));
    }

    private function transform(CargosReaderResult $cargos): array
    {
        return [
            'id' => $cargos->id,
            'cargo' => $cargos->cargo
        ];
    }
}
