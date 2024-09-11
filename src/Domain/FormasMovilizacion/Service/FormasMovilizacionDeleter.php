<?php

namespace App\Domain\FormasMovilizacion\Service;

use App\Domain\FormasMovilizacion\Repository\FormasMovilizacionRepository;

final class FormasMovilizacionDeleter
{
    private FormasMovilizacionRepository $repository;

    public function __construct(FormasMovilizacionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function deleteFormasMovilizacion(int $formasMovilizacionId): void
    {

        $this->repository->deleteFormasMovilizacionById($formasMovilizacionId);
    }
}
