<?php

namespace App\Domain\Preguntas\Service;

use App\Domain\Preguntas\Data\PreguntasFinderItem;
use App\Domain\Preguntas\Data\PreguntasFinderResult;
use App\Domain\Preguntas\Repository\PreguntasFinderRepository;

final class PreguntasFinder
{
    private PreguntasFinderRepository $repository;

    public function __construct(PreguntasFinderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findPreguntass(): PreguntasFinderResult
    {
        // Input validation
        // ...

        $preguntass = $this->repository->findPreguntass();

        return $this->createResult($preguntass);
    }

    private function createResult(array $preguntasRows): PreguntasFinderResult
    {
        $result = new PreguntasFinderResult();

        foreach ($preguntasRows as $preguntasRow) {
            $preguntas = new PreguntasFinderItem();
            $preguntas->id = $preguntasRow['id'];
            $preguntas->pregunta = $preguntasRow['pregunta'];
            $preguntas->etiqueta = $preguntasRow['etiqueta'];
            

            $result->preguntass[] = $preguntas;
        }
        //var_dump($result);

        return $result;
    }
}
