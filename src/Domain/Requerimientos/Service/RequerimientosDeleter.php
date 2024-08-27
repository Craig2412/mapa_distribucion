<?php

namespace App\Domain\Requerimientos\Service;

use App\Domain\Requerimientos\Repository\RequerimientosRepository;

final class RequerimientosDeleter
{
    private RequerimientosRepository $repository;

    public function __construct(RequerimientosRepository $repository)
    {
        $this->repository = $repository;
    }

    public function deleteRequerimientos(int $requerimientosId): void
    {
        $this->repository->deleteRequerimientosById($requerimientosId);
    }
}
