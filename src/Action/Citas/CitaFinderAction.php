<?php

namespace App\Action\Citas;

use App\Domain\Cita\Data\CitaFinderResult;
use App\Domain\Cita\Service\CitaFinder;
use App\Renderer\JsonRenderer;
use App\Action\argValidator;//Paginador
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class CitaFinderAction
{
    private CitaFinder $citaFinder;

    private JsonRenderer $renderer;

    public function __construct(CitaFinder $citaFinder, JsonRenderer $jsonRenderer)
    {
        $this->citaFinder = $citaFinder;
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

        if (isset($args['params'])) {
            $clase_busqueda = New argValidator;
            $params = explode('/', $args['params']);
            $params = json_decode($params[0]);          
            $parametros = $clase_busqueda->whereGenerate($params,'citas');          
        }else {
           $parametros = null;
        }

        $citas = $this->citaFinder->findCita($nro_pag,$parametros,$cant_registros);
    //Fin Paginador
    //$nro_pag,$parametros,$cant_registros

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($citas));
    }

    public function transform(CitaFinderResult $result): array
    {
        $citas = [];
        if (isset($result->cita)) {
            foreach ($result->cita as $cita) {
                $citas[] = [
                    'id' => $cita->id,
                    'nombre' => $cita->nombre,
                    'fecha_cita' => $cita->fecha_cita,
                    'id_requerimiento' => $cita->id_requerimiento,
                    'estado' => $cita->estado,
                    'id_estado' => $cita->id_estado,
                    'id_formato_cita' => $cita->id_formato_cita,
                    'formato_cita' => $cita->formato_cita,
                    'id_condicion' => $cita->id_condicion,
                    'updated' => $cita->updated,
                    'created' => $cita->created
                ];
            }
        }        

        return [
            'citas' => $citas,
        ];
    }
}
