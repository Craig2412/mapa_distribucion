<?php

namespace App\Domain\Categorias\Service;

use App\Domain\Categorias\Data\CategoriasReaderResult;
use App\Domain\Categorias\Repository\CategoriasRepository;

/**
 * Service.
 */
final class CategoriasReader
{
    private CategoriasRepository $repository;

    /**
     * The constructor.
     *
     * @param CategoriasRepository $repository The repository
     */
    public function __construct(CategoriasRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Read a categoria.
     *
     * @param int $categoriaId The categoria id
     *
     * @return CategoriasReaderResult The result
     */
    public function getCategorias(int $categoriaId): CategoriasReaderResult
    {
        // Input validation
        // ...

        // Fetch data from the database
        $categoriaRow = $this->repository->getCategoriasById($categoriaId);

        // Optional: Add or invoke your complex business logic here
        // ...

        // Create domain result
        $result = new CategoriasReaderResult();
        $result->id = $categoriaRow['id'];
        $result->categoria = $categoriaRow['categoria'];
        $result->id_condicion = $categoriaRow['id_condicion'];
        $result->id_departamento = $categoriaRow['id_departamento'];
        $result->departamento = $categoriaRow['departamento'];
        $result->created = $categoriaRow['created'];
        $result->updated = $categoriaRow['updated'];

        return $result;
    }
}