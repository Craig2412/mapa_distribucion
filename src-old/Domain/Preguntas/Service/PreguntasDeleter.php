<?php

namespace App\Domain\Preguntas\Service;

use App\Domain\Preguntas\Repository\PreguntasRepository;

final class PreguntasDeleter
{
    private PreguntasRepository $repository;

    public function __construct(PreguntasRepository $repository)
    {
        $this->repository = $repository;
    }

    public function deletePreguntas(int $preguntasId): void
    {

        $this->repository->deletePreguntasById($preguntasId);
    }
}
