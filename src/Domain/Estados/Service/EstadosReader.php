<?php

namespace App\Domain\Estados\Service;

use App\Domain\Estados\Data\EstadosReaderResult;
use App\Domain\Estados\Repository\EstadosRepository;

/**
 * Service.
 */
final class EstadosReader
{
    private EstadosRepository $repository;

    /**
     * The constructor.
     *
     * @param EstadosRepository $repository The repository
     */
    public function __construct(EstadosRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Read a estados.
     *
     * @param int $estadosId The estados id
     *
     * @return EstadosReaderResult The result
     */
    public function getEstados(int $estadosId): EstadosReaderResult
    {
        // Input validation
        // ...

        // Fetch data from the database
        $estadosRow = $this->repository->getEstadosById($estadosId);

        // Optional: Add or invoke your complex business logic here
        // ...
        // Create domain result
        $result = new EstadosReaderResult();
        $result->id = $estadosRow['id'];
        $result->estado = $estadosRow['estado'];
        
        return $result;
    }
}
