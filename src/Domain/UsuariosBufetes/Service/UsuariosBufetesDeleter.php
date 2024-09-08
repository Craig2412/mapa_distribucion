<?php

namespace App\Domain\UsuariosBufetes\Service;

use App\Domain\UsuariosBufetes\Repository\UsuariosBufetesRepository;

final class UsuariosBufetesDeleter
{
    private UsuariosBufetesRepository $repository;

    public function __construct(UsuariosBufetesRepository $repository)
    {
        $this->repository = $repository;
    }

    public function deleteUsuariosBufetes(int $usuariosbufetesId): void
    {
        $this->repository->deleteUsuariosBufetesById($usuariosbufetesId);
    }
}
