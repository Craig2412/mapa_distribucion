<?php

namespace App\Domain\Empresas\Service;

use App\Domain\Empresas\Repository\EmpresasRepository;

final class EmpresasDeleter
{
    private EmpresasRepository $repository;

    public function __construct(EmpresasRepository $repository)
    {
        $this->repository = $repository;
    }

    public function deleteEmpresas(int $empresasId): void
    {

        $this->repository->deleteEmpresasById($empresasId);
    }
}
