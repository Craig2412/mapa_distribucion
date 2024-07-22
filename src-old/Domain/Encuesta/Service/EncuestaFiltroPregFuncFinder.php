<?php

namespace App\Domain\Encuesta\Service;

use App\Domain\Encuesta\Data\EncuestaFinderItem;
use App\Domain\Encuesta\Data\EncuestaFinderResult;
use App\Domain\Encuesta\Repository\EncuestaFiltroPregFuncFinderRepository;

final class EncuestaFiltroPregFuncFinder
{
    private EncuestaFiltroPregFuncFinderRepository $repository;

    public function __construct(EncuestaFiltroPregFuncFinderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findEncuestaFiltroPregFunc($nro_pag,$cant_registros,$encuestaId,$pregFunc): EncuestaFinderResult
    {
        // Input validation
        $encuestaFiltroPregFunc = $this->repository->findEncuestaFiltroPregFunc($nro_pag,$cant_registros,$encuestaId,$pregFunc);
        
        return $this->createResult($encuestaFiltroPregFunc);
    }

    private function createResult(array $encuestaFiltroPregFuncRows): EncuestaFinderResult
    {
        $result = new EncuestaFinderResult();

        foreach ($encuestaFiltroPregFuncRows as $encuestaFiltroPregFuncRow) {
            
            $encuestaFiltroPregFunc = new EncuestaFinderItem();            
            $encuestaFiltroPregFunc->id = $encuestaFiltroPregFuncRow['id'];
            $encuestaFiltroPregFunc->id_pregunta = $encuestaFiltroPregFuncRow['id_pregunta'];
            $encuestaFiltroPregFunc->id_funcionario = $encuestaFiltroPregFuncRow['id_funcionario'];
            $encuestaFiltroPregFunc->funcionario = $encuestaFiltroPregFuncRow['apellidos_nombres'];
            $encuestaFiltroPregFunc->pregunta = $encuestaFiltroPregFuncRow['pregunta'];
            $encuestaFiltroPregFunc->respuesta = $encuestaFiltroPregFuncRow['respuesta'];          

            $result->encuestaFiltroPregFunc[] = $encuestaFiltroPregFunc;
        }
        
        return $result;
    }
}
