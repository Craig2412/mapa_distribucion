<?php

namespace App\Domain\Estatus_aplicacion\Service;

use App\Domain\Estatus_aplicacion\Repository\Estatus_aplicacionRepository;

final class Estatus_aplicacionDeleter
{
    private Estatus_aplicacionRepository $repository;

    public function __construct(Estatus_aplicacionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function deleteEstatus_aplicacion(int $estatus_aplicacionId): void
    {

        $this->repository->deleteEstatus_aplicacionById($estatus_aplicacionId);
    }
}
