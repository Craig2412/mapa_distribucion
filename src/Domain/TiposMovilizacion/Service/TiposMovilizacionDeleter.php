<?php

namespace App\Domain\TiposMovilizacion\Service;

use App\Domain\TiposMovilizacion\Repository\TiposMovilizacionRepository;

final class TiposMovilizacionDeleter
{
    private TiposMovilizacionRepository $repository;

    public function __construct(TiposMovilizacionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function deleteTiposMovilizacion(int $tiposMovilizacionId): void
    {

        $this->repository->deleteTiposMovilizacionById($tiposMovilizacionId);
    }
}
