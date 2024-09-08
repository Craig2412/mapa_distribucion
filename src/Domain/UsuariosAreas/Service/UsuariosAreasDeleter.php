<?php

namespace App\Domain\UsuariosAreas\Service;

use App\Domain\UsuariosAreas\Repository\UsuariosAreasRepository;

final class UsuariosAreasDeleter
{
    private UsuariosAreasRepository $repository;

    public function __construct(UsuariosAreasRepository $repository)
    {
        $this->repository = $repository;
    }

    public function deleteUsuariosAreas(int $usuariosareasId): void
    {
        $this->repository->deleteUsuariosAreasById($usuariosareasId);
    }
}
