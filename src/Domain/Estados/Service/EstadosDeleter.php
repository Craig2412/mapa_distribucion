<?php

namespace App\Domain\Estados\Service;

use App\Domain\Estados\Repository\EstadosRepository;

final class EstadosDeleter
{
    private EstadosRepository $repository;

    public function __construct(EstadosRepository $repository)
    {
        $this->repository = $repository;
    }

    public function deleteEstados(int $estadosId): void
    {

        $this->repository->deleteEstadosById($estadosId);
    }
}
