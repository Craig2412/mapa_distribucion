<?php

namespace App\Domain\Estatus\Service;

use App\Domain\Estatus\Repository\EstatusRepository;

final class EstatusDeleter
{
    private EstatusRepository $repository;

    public function __construct(EstatusRepository $repository)
    {
        $this->repository = $repository;
    }

    public function deleteEstatus(int $estatusId): void
    {

        $this->repository->deleteEstatusById($estatusId);
    }
}
