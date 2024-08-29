<?php

namespace App\Action\TiposMovilizacion;

use App\Domain\TiposMovilizacion\Data\TiposMovilizacionFinderResult;
use App\Domain\TiposMovilizacion\Service\TiposMovilizacionFinder;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class TiposMovilizacionFinderAction
{
    private TiposMovilizacionFinder $tiposMovilizacionFinder;

    private JsonRenderer $renderer;

    public function __construct(TiposMovilizacionFinder $tiposMovilizacionFinder, JsonRenderer $jsonRenderer)
    {
        $this->tiposMovilizacionFinder = $tiposMovilizacionFinder;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Optional: Pass parameters from the request to the service method
        // ...

        $tiposMovilizacions = $this->tiposMovilizacionFinder->findTiposMovilizacions();

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($tiposMovilizacions));
    }

    public function transform(TiposMovilizacionFinderResult $result): array
    {
        $tiposMovilizacions = [];

        foreach ($result->tiposMovilizacions as $tiposMovilizacion) {
            $tiposMovilizacions[] = [
                'id' => $tiposMovilizacion->id,
                'tipo_movilizacion' => strtoupper($tiposMovilizacion->tipo_movilizacion)
            ];
        }

        return [
            'tiposMovilizacions' => $tiposMovilizacions,
        ];
    }
}
