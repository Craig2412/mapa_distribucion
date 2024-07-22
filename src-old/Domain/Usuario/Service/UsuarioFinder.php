<?php

namespace App\Domain\Usuario\Service;

use App\Domain\Usuario\Data\UsuarioFinderItem;
use App\Domain\Usuario\Data\UsuarioFinderResult;
use App\Domain\Usuario\Repository\UsuarioFinderRepository;

final class UsuarioFinder
{
    private UsuarioFinderRepository $repository;

    public function __construct(UsuarioFinderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findUsuarios(): UsuarioFinderResult
    {
        // Input validation
        // ...

        $usuarios = $this->repository->findUsuarios();

        return $this->createResult($usuarios);
    }

    private function createResult(array $usuarioRows): UsuarioFinderResult
    {
        $result = new UsuarioFinderResult();

        foreach ($usuarioRows as $usuarioRow) {
            $usuario = new UsuarioFinderItem();
            $usuario->id = $usuarioRow['id'];
            $usuario->name = $usuarioRow['name'];
            $usuario->identification = $usuarioRow['identification'];
            $usuario->email = $usuarioRow['email'];
            $usuario->id_role = $usuarioRow['id_role'];
            $usuario->role = $usuarioRow['role'];
            $usuario->created = $usuarioRow['created'];
            $usuario->updated = $usuarioRow['updated'];
            
            $result->usuarios[] = $usuario;
        }

        return $result;
    }
}
