<?php

namespace App\Action\Requerimientos;

use App\Domain\Requerimientos\Data\RequerimientosFinderResult;
use App\Domain\Requerimientos\Service\RequerimientosFinder;
use App\Renderer\JsonRenderer;
use App\Action\argValidator;//Paginador
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;


final class RequerimientosFinderAction
{
    private RequerimientosFinder $requerimientosFinder;

    private JsonRenderer $renderer;

    public function __construct(RequerimientosFinder $requerimientosFinder, JsonRenderer $jsonRenderer)
    {
        $this->requerimientosFinder = $requerimientosFinder;
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
            $parametros = $clase_busqueda->whereGenerate($params,'appointments');          
        }else {
            $parametros = null;
        }

        $requerimientos = $this->requerimientosFinder->findRequerimientos($nro_pag,$parametros,$cant_registros);
    //Fin Paginador
    //$nro_pag,$parametros,$cant_registros


        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($requerimientos));
    }

    public function transform(RequerimientosFinderResult $result): array
    {
        $requerimientos = [];

        foreach ($result->requerimientos as $requerimiento) {
            $requerimientos[] = [
                'id' => $requerimiento->id,
                'agent_name' => $requerimiento->agent_name,
                'agent_lastname' => $requerimiento->agent_lastname,
                'agent_identification' => $requerimiento->agent_identification,
                'agent_rif' => $requerimiento->agent_rif,
                'agent_gender' => $requerimiento->agent_gender,
                'agent_type' => $requerimiento->agent_type,
                'agent_number_type' => $requerimiento->agent_number_type,
                'agent_telefone' => $requerimiento->agent_telefone,
                'agent_number' => $requerimiento->agent_number,
                'agent_email' => $requerimiento->agent_email,
                'agent_estado' => $requerimiento->agent_estado,
                'created' => $requerimiento->created,

            ];
        }

        return [
            'requerimientos' => $requerimientos,
        ];
    }
}

/*
EJEMPLO DEL STRING QUE SE DEBE ENVIAR POR LOS PARAMETROS CON FORMATO JSON:
    {"area": "some_value", "status": "some_name", "type_tasks": "some_surname"}
 
*/