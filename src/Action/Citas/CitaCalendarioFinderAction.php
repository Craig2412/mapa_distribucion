<?php

namespace App\Action\Citas;

use App\Domain\Cita\Data\CitaFinderResult;
use App\Domain\Cita\Service\CitaCalendarioFinder;
use App\Renderer\JsonRenderer;
use App\Action\argValidator;//Paginador
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;


final class CitaCalendarioFinderAction
{
    private CitaCalendarioFinder $citaCalendarioFinder;

    private JsonRenderer $renderer;

    public function __construct(CitaCalendarioFinder $citaCalendarioFinder, JsonRenderer $jsonRenderer)
    {
        $this->citaCalendarioFinder = $citaCalendarioFinder;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        
        
    //Paginador
        if (isset($args['nro_pag']) && ($args['nro_pag'] > 0)) {
            $nro_pag = (int)$args['nro_pag'];
        }else {
            $nro_pag = 1;
        }

        if (isset($args['cant_registros']) && ($args['cant_registros'] > 0)) {
            $cant_registros = $args['cant_registros'];
        }else {
            $cant_registros = 10;
        }

        $fecha_inicial = $args['fecha_inicial'];
        $fecha_final = $args['fecha_final'];

        $citaCalendario = $this->citaCalendarioFinder->findCitaCalendario($nro_pag,$cant_registros,$fecha_inicial,$fecha_final);
    //Fin Paginador

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($citaCalendario));
    }

    public function transform(CitaFinderResult $result): array
    {
        $citaCalendario = [];

        foreach ($result->citaCalendario as $citaCalendario) {
            $citasCalendario[] = [
                'id' => $citaCalendario->id,
                'fecha_cita' => $citaCalendario->fecha_cita,
                                
                'id_requerimiento' => $citaCalendario->id_requerimiento,//
                'id_usuario' => $citaCalendario->id_usuario,
                'nombre' => $citaCalendario->nombre,
                'title' => $citaCalendario->nombre.' / '.$citaCalendario->formato_cita,
                'id_estado' => $citaCalendario->id_estado,
                'estado' => $citaCalendario->estado,
                'id_formato_cita' => $citaCalendario->id_formato_cita,
                'formato_cita' => $citaCalendario->formato_cita,
                'id_condicion' => $citaCalendario->id_condicion,

                'created' => $citaCalendario->created,
                'updated' => $citaCalendario->updated
            ];
        }

        return [
            'citasCalendario' => $citasCalendario,
        ];
    }
}
/*

EJEMPLO DEL STRING QUE SE DEBE ENVIAR POR LOS PARAMETROS CON FORMATO JSON:
{"area": "some_value", "status": "some_name", "type_citaCalendario": "some_surname"}
 
    
    
EJEMPLO DE FORMATO DE CITAS PARA CITA CALENDARIO:

2023-12-01/2023-12-31
*/
