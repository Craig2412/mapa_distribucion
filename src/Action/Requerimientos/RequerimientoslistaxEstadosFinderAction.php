<?php

namespace App\Action\Requerimientos;

use App\Domain\Requerimientos\Data\RequerimientoslistaxEstadosFinderResult;
use App\Domain\Requerimientos\Service\RequerimientoslistaxEstadosFinder;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class RequerimientoslistaxEstadosFinderAction
{
    
    private RequerimientoslistaxEstadosFinder $requerimientoslistaxEstadosFinder;

    private JsonRenderer $renderer;

    public function __construct(RequerimientoslistaxEstadosFinder $requerimientoslistaxEstadosFinder, JsonRenderer $jsonRenderer)
    {

        $this->requerimientoslistaxEstadosFinder = $requerimientoslistaxEstadosFinder;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {

        $requerimientoslistaxEstados = $this->requerimientoslistaxEstadosFinder->findRequerimientoslistaxEstados();
  

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($requerimientoslistaxEstados));
    }

    public function transform(RequerimientoslistaxEstadosFinderResult $result): array
    {
        $requerimientoslistaxEstados = [];

        foreach ($result->requerimientoslistaxEstados as $requerimientolistaxEstados) {
            $requerimientoslistaxEstados[] = [
                'id' => $requerimientolistaxEstados->id,
                'id_formato_cita' => $requerimientolistaxEstados->id_formato_cita,
                'formato_cita' => $requerimientolistaxEstados->formato_cita,
                'id_usuario' => $requerimientolistaxEstados->id_usuario,
                'nombre' => $requerimientolistaxEstados->nombre,
                'trabajador' => $requerimientolistaxEstados->trabajador,
                'apellido' => $requerimientolistaxEstados->apellido,
                'identificacion' => $requerimientolistaxEstados->identificacion,
                'id_pais' => $requerimientolistaxEstados->id_pais,
                'pais' => $requerimientolistaxEstados->pais,
                'id_estado_pais' => $requerimientolistaxEstados->id_estado_pais,
                'estado_pais' => $requerimientolistaxEstados->estado_pais,
                'id_condicion' => $requerimientolistaxEstados->id_condicion,
                'id_estado' => $requerimientolistaxEstados->id_estado,
                'estado' => $requerimientolistaxEstados->estado,
                'id_trabajador' => $requerimientolistaxEstados->id_trabajador,
                'created' => $requerimientolistaxEstados->created,
                'updated' => $requerimientolistaxEstados->updated
            ];
        }

        return [
            'requerimientoslistaxEstados' => $requerimientoslistaxEstados,
        ];
    }
}
/*


EJEMPLO DEL STRING QUE SE DEBE ENVIAR POR LOS PARAMETROS CON FORMATO JSON:
    {"area": "some_value", "status": "some_name", "type_requerimientoslistaxEstados": "some_surname"}
*/