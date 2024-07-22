<?php

namespace App\Domain\Funcionarios\Service;

use App\Domain\Funcionarios\Repository\FuncionariosRepository;

final class FuncionariosDeleter
{
    private FuncionariosRepository $repository;

    public function __construct(FuncionariosRepository $repository)
    {
        $this->repository = $repository;
    }

    public function deleteFuncionarios(int $funcionariosId): void
    {

        $this->repository->deleteFuncionariosById($funcionariosId);
    }
}
