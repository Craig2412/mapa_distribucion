<?php

namespace App\Action\TiposMovilizacion;

use App\Domain\TiposMovilizacion\Data\TiposMovilizacionReaderResult;
use App\Domain\TiposMovilizacion\Service\TiposMovilizacionReader;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class TiposMovilizacionReaderAction
{
    private TiposMovilizacionReader $tiposMovilizacionReader;

    private JsonRenderer $renderer;

    public function __construct(TiposMovilizacionReader $tiposMovilizacionReader, JsonRenderer $jsonRenderer)
    {
        $this->tiposMovilizacionReader = $tiposMovilizacionReader;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $tiposMovilizacionId = (int)$args['tiposMovilizacion_id'];

        // Invoke the domain and get the result
        $tiposMovilizacion = $this->tiposMovilizacionReader->getTiposMovilizacion($tiposMovilizacionId);

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($tiposMovilizacion));
    }

    private function transform(TiposMovilizacionReaderResult $tiposMovilizacion): array
    {
        return [
            'id' => $tiposMovilizacion->id,
            'tipo_movilizacion' => strtoupper($tiposMovilizacion->tipo_movilizacion)
        ];
    }
}
