<?php

namespace App\Action\Encuesta;

use App\Domain\Encuesta\Data\EncuestaFinderResult;
use App\Domain\Encuesta\Service\EncuestaFiltroPregFuncFinder;
use App\Renderer\JsonRenderer;
use App\Action\argValidator;//Paginador
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;


final class EncuestaFiltroPregFuncFinderAction
{
    private EncuestaFiltroPregFuncFinder $EncuestaFiltroPregFuncsFinder;

    private JsonRenderer $renderer;

    public function __construct(EncuestaFiltroPregFuncFinder $EncuestaFiltroPregFuncsFinder, JsonRenderer $jsonRenderer)
    {
        $this->EncuestaFiltroPregFuncsFinder = $EncuestaFiltroPregFuncsFinder;
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

        $pregFunc = $args['preguntas_funcionarios'];//Preguntas o funcionarios (1 - 2)
        $encuestaId = $args['id'];//ID de lo que buscamos

        $EncuestaFiltroPregFuncs = $this->EncuestaFiltroPregFuncsFinder->findEncuestaFiltroPregFunc($nro_pag,$cant_registros,$encuestaId,$pregFunc);
    //Fin Paginador

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($EncuestaFiltroPregFuncs));
    }

    public function transform(EncuestaFinderResult $result): array
    {
        $EncuestaFiltroPregFuncs = [];


        foreach ($result->encuestaFiltroPregFunc as $EncuestaFiltroPregFunc) {
            $EncuestaFiltroPregFuncs[] = [
                'id' => $EncuestaFiltroPregFunc->id,
                'id_funcionario' => $EncuestaFiltroPregFunc->id_funcionario,
                'funcionario' => $EncuestaFiltroPregFunc->funcionario,
                'id_pregunta' => $EncuestaFiltroPregFunc->id_pregunta,
                'pregunta' => $EncuestaFiltroPregFunc->pregunta,
                'respuesta' => $EncuestaFiltroPregFunc->respuesta
            ];
        }

        return [
            'EncuestaFiltroPregFuncs' => $EncuestaFiltroPregFuncs,
        ];
    }
}
