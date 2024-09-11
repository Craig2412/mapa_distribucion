<?php

namespace App\Action\Historial;

use App\Domain\Historial\Data\HistorialMayoristaFinderResult;
use App\Domain\Historial\Service\HistorialMayoristaFinder;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class HistorialMayoristaFinderAction
{
    private HistorialMayoristaFinder $historialMayoristaFinder;

    private JsonRenderer $renderer;

    public function __construct(HistorialMayoristaFinder $historialMayoristaFinder, JsonRenderer $jsonRenderer)
    {
        $this->historialMayoristaFinder = $historialMayoristaFinder;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        // Optional: Pass parameters from the request to the service method
        // ...
        $id_mayorista = (int)$args['id_mayorista'];

        $historialMayoristas = $this->historialMayoristaFinder->findHistorialMayoristas($id_mayorista);

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($historialMayoristas));
    }

    public function transform(HistorialMayoristaFinderResult $result): array
    {
        $historialMayoristas = [];

        foreach ($result->historialMayoristas as $historialMayorista) {
            $historialMayoristas[] = [
                'id' => $historialMayorista->id,
                'id_mayorista' => $historialMayorista->id_mayorista,
                'campo' => $historialMayorista->campo,
                'dato_nuevo' => $historialMayorista->dato_nuevo,
                'fecha' => $historialMayorista->fecha
            ];
        }

        return [
            'historialMayoristas' => $historialMayoristas,
        ];
    }
}
