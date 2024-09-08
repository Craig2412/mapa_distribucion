<?php

namespace App\Action\Requerimientos;

use App\Domain\Requerimientos\Data\RequerimientosbyEstadosFinderResult;
use App\Domain\Requerimientos\Service\RequerimientosbyVisitasFinder;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class RequerimientosbyVisitasFinderAction
{
    
    private RequerimientosbyVisitasFinder $requerimientosbyVisitasFinder;

    private JsonRenderer $renderer;

    public function __construct(RequerimientosbyVisitasFinder $requerimientosbyVisitasFinder, JsonRenderer $jsonRenderer)
    {

        $this->requerimientosbyVisitasFinder = $requerimientosbyVisitasFinder;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {

        $requerimientosbyEstados = $this->requerimientosbyVisitasFinder->findRequerimientosbyEstados();
  

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($requerimientosbyEstados));
    }

    public function transform(RequerimientosbyEstadosFinderResult $result): array
    {
        $requerimientosbyEstados = [];

        foreach ($result->requerimientosbyEstados as $requerimientosbyEstado) {
            $requerimientosbyEstados[] = [
                'estado' => $requerimientosbyEstado->estado,
                'total' => $requerimientosbyEstado->total,
            ];
        }

        return [
            'requerimientosbyEstados' => $requerimientosbyEstados,
        ];
    }
}
/*


EJEMPLO DEL STRING QUE SE DEBE ENVIAR POR LOS PARAMETROS CON FORMATO JSON:
    {"area": "some_value", "status": "some_name", "type_requerimientosbyEstados": "some_surname"}
*/