<?php

namespace App\Domain\EstatusCategoria\Service;

use App\Domain\EstatusCategoria\Data\EstatusCategoriaReaderResult;
use App\Domain\EstatusCategoria\Repository\EstatusCategoriaRepository;

/**
 * Service.
 */
final class EstatusCategoriaReader
{
    private EstatusCategoriaRepository $repository;

    /**
     * The constructor.
     *
     * @param EstatusCategoriaRepository $repository The repository
     */
    public function __construct(EstatusCategoriaRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Read a estatusCategorias.
     *
     * @param int $estatusCategoriasId The estatusCategorias id
     *
     * @return EstatusCategoriaReaderResult The result
     */
    public function getEstatusCategoria(int $estatusCategoriasId): EstatusCategoriaReaderResult
    {
        // Input validation
        // ...

        // Fetch data from the database
        $estatusCategoriasRow = $this->repository->getEstatusCategoriaById($estatusCategoriasId);

        // Optional: Add or invoke your complex business logic here
        // ...

        // Create domain result
        $result = new EstatusCategoriaReaderResult();
        $result->id = $estatusCategoriasRow['id'];
        $result->estatusCategoria = $estatusCategoriasRow['estatus_categoria'];
        $result->id_categoria = $estatusCategoriasRow['id_categoria'];
        $result->categoria = $estatusCategoriasRow['categoria'];
        $result->created = $estatusCategoriasRow['created'];
        $result->updated = $estatusCategoriasRow['updated'];
        
        return $result;
    }
}
