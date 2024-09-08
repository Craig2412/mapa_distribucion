<?php

namespace App\Domain\Categorias\Service;

use App\Domain\Categorias\Data\CategoriasFinderItem;
use App\Domain\Categorias\Data\CategoriasFinderResult;
use App\Domain\Categorias\Repository\CategoriasFinderRepository;

final class CategoriasFinder
{
    private CategoriasFinderRepository $repository;

    public function __construct(CategoriasFinderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findCategorias(): CategoriasFinderResult
    {
        // Input validation
        // ...

        $categorias = $this->repository->findCategorias();

        return $this->createResult($categorias);
    }

    private function createResult(array $categoriasRows): CategoriasFinderResult
    {
        $result = new CategoriasFinderResult();

        foreach ($categoriasRows as $categoriasRow) {
            $categorias = new CategoriasFinderItem();
            
            $categorias->id = $categoriasRow['id'];
            $categorias->categoria = $categoriasRow['categoria'];
            $categorias->id_condicion = $categoriasRow['id_condicion'];
            $categorias->id_departamento = $categoriasRow['id_departamento'];
            $categorias->departamento = $categoriasRow['departamento'];
            $categorias->created = $categoriasRow['created'];
            $categorias->updated = $categoriasRow['updated'];

            $result->categorias[] = $categorias;
        }

        return $result;
    }
}
