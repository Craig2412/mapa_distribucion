<?php

namespace App\Domain\Encuesta\Service;

use App\Domain\Encuesta\Data\EncuestaFinderItem;
use App\Domain\Encuesta\Data\EncuestaFinderResult;
use App\Domain\Encuesta\Repository\EncuestaFinderRepository;

final class EncuestaFinder
{
    private EncuestaFinderRepository $repository;

    public function __construct(EncuestaFinderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findEncuestas(): EncuestaFinderResult
    {
        // Input validation
        // ...

        $encuestas = $this->repository->findEncuestas();

        return $this->createResult($encuestas);
    }

    private function createResult(array $encuestaRows): EncuestaFinderResult
    {
        $result = new EncuestaFinderResult();

        foreach ($encuestaRows as $encuestaRow) {
            $encuesta = new EncuestaFinderItem();
            $encuesta->id = $encuestaRow['id'];
            $encuesta->id_pregunta = $encuestaRow['id_pregunta'];
            $encuesta->id_funcionario = $encuestaRow['id_funcionario'];
            $encuesta->funcionario = $encuestaRow['apellidos_nombres'];
            $encuesta->pregunta = $encuestaRow['pregunta'];
            $encuesta->respuesta = $encuestaRow['respuesta'];
            

            $result->encuestas[] = $encuesta;
        }
        return $result;
    }
}
