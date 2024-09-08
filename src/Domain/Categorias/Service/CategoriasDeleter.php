<?php

namespace App\Domain\Categorias\Service;

use App\Domain\Categorias\Repository\CategoriasRepository;

final class CategoriasDeleter
{
    private CategoriasRepository $repository;

    public function __construct(CategoriasRepository $repository)
    {
        $this->repository = $repository;
    }

    public function deleteCategorias(int $categoriasId): void
    {
        $this->repository->deleteCategoriasById($categoriasId);
    }
}
