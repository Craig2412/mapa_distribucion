<?php

namespace App\Domain\Encuesta\Service;

use App\Domain\Encuesta\Repository\EncuestaRepository;

final class EncuestaDeleter
{
    private EncuestaRepository $repository;

    public function __construct(EncuestaRepository $repository)
    {
        $this->repository = $repository;
    }

    public function deleteEncuesta(int $encuestaId): void
    {

        $this->repository->deleteEncuestaById($encuestaId);
    }
}
