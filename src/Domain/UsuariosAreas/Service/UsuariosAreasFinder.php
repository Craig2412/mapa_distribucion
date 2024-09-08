<?php

namespace App\Domain\UsuariosAreas\Service;

use App\Domain\UsuariosAreas\Data\UsuariosAreasFinderItem;
use App\Domain\UsuariosAreas\Data\UsuariosAreasFinderResult;
use App\Domain\UsuariosAreas\Repository\UsuariosAreasFinderRepository;

final class UsuariosAreasFinder
{
    private UsuariosAreasFinderRepository $repository;

    public function __construct(UsuariosAreasFinderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findUsuariosAreas(): UsuariosAreasFinderResult
    {
        // Input validation
        // ...

        $usuariosareas = $this->repository->findUsuariosAreas();

        return $this->createResult($usuariosareas);
    }

    private function createResult(array $usuariosareasRows): UsuariosAreasFinderResult
    {
        $result = new UsuariosAreasFinderResult();

        foreach ($usuariosareasRows as $usuariosareasRow) {
            $usuariosareas = new UsuariosAreasFinderItem();
            
            $usuariosareas->id = $usuariosareasRow['id'];
            $usuariosareas->id_area = $usuariosareasRow['id_area'];
            $usuariosareas->id_usuario = $usuariosareasRow['id_usuario'];
            $usuariosareas->nombre = $usuariosareasRow['nombre'];
            $usuariosareas->area = $usuariosareasRow['area'];

            $result->usuariosareas[] = $usuariosareas;
        }

        return $result;
    }
}
