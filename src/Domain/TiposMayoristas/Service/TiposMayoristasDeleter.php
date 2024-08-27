<?php

namespace App\Domain\TiposMayoristas\Service;

use App\Domain\TiposMayoristas\Repository\TiposMayoristasRepository;

final class TiposMayoristasDeleter
{
    private TiposMayoristasRepository $repository;

    public function __construct(TiposMayoristasRepository $repository)
    {
        $this->repository = $repository;
    }

    public function deleteTiposMayoristas(int $tiposMayoristasId): void
    {

        $this->repository->deleteTiposMayoristasById($tiposMayoristasId);
    }
}
