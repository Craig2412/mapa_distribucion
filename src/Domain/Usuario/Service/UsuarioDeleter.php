<?php

namespace App\Domain\Usuario\Service;

use App\Domain\Usuario\Repository\UsuarioRepository;

final class UsuarioDeleter
{
    private UsuarioRepository $repository;

    public function __construct(UsuarioRepository $repository)
    {
        $this->repository = $repository;
    }

    public function deleteUsuario(int $UsuarioId): void
    {

        $this->repository->deleteUsuarioById($UsuarioId);
    }
}
